<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;

class BorrowingController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $bookBorrowingOpen = Borrowing::where('book_id', $book->id)
        ->whereNull('returned_at')
        ->exists();

        if ($bookBorrowingOpen) {
            return redirect()
            ->route('books.show', $book)
            ->with('error', 'Este livro já está emprestado.');
        }

        $userBorrowingsOpen = Borrowing::where('user_id', $request->user_id)
        ->whereNull('returned_at')
        ->count();

        if ($userBorrowingsOpen >= 5) {
            return redirect()
            ->route('books.show', $book)
            ->with('error', 'Este usuário já atingiu o limite de 5 livros emprestados.');
        }

        if ($user->debit > 0) {
            return redirect()
            ->route('books.show', $book)
            ->with('error', 'Este usuário possui multas pendentes.');
        }

        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        return redirect()->route('books.show', $book)->with('success', 'Empréstimo registrado com sucesso.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        $user = $borrowing->user;

        $borrowedAt = $borrowing->borrowed_at;
        $returnedAt = now();
        $days = $borrowedAt->diffInDays($returnedAt);

        if ($days > 15) {
            $delay = $days - 15;
            $fine = $delay * 0.50;
            $user->increment('debit', $fine);
        }

        $borrowing->update([
            'returned_at' => now(),
        ]);

        return redirect()->route('books.show', $borrowing->book_id)->with('success', 'Devolução registrada com sucesso.');
    }

    public function userBorrowings(User $user)
    {
        $borrowings = $user->books()->withPivot('borrowed_at', 'returned_at')->get();

        return view('users.borrowings', compact('user', 'borrowings'));
    }
}
