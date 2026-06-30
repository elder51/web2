<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{

    public function index()
    {
        $publishers = Publisher::all();
        return view('publishers.index', compact('publishers'));
    }

    public function create()
    {
        $this->authorize('create', Publisher::class);

        return view('publishers.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Publisher::class);

        $request->validate([
            'name' => 'required|string|unique:publishers|max:255',
        ]);

        Publisher::create($request->all());

        return redirect()->route('publishers.index')->with('success', 'Editora criada com sucesso.');
    }

    public function show(Publisher $publisher)
    {
        return view('publishers.show', compact('publisher'));
    }

    public function edit(Publisher $publisher)
    {
        $this->authorize('update', $publisher);

        return view('publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $this->authorize('update', $publisher);

        $request->validate([
            'name' => 'required|string|unique:publishers,name,' . $publisher->id . '|max:255',
        ]);

        $publisher->update($request->all());

        return redirect()->route('publishers.index')->with('success', 'Editora atualizada com sucesso.');
    }

    public function destroy(Publisher $publisher)
    {
        $this->authorize('delete', $publisher);

        $publisher->delete();
        
        return redirect()->route('publishers.index')->with('success', 'Editora excluída com sucesso.');
    }
}
