<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function withDebt()
    {
        $users = User::where('debit', '>', 0)->orderBy('debit', 'desc')->get();

        return view('users.with-debt', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,bibliotecario,cliente',
        ]);

        $user->update($validated);

      return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function payDebit(User $user)
    {
        $this->authorize('payDebit', $user);

        $user->update([
            'debit' => 0
        ]);

        return redirect()
        ->route('users.withDebt')
        ->with('success', 'Débito quitado com sucesso.');
    }
}
