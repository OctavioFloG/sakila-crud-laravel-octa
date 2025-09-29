<?php

namespace App\Http\Controllers;
use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function index() {
        $actors = Actor::orderBy('actor_id','desc')->get();
        return view('actors.index', compact('actors'));
    }

    public function create() { return view('actors.create'); }

    public function store(Request $r) {
        $data = $r->validate([
            'first_name'=>'required|string|max:45',
            'last_name'=>'required|string|max:45',
        ]);
        Actor::create($data);
        return redirect()->route('actors.index')->with('ok','Actor creado');
    }

    public function show(Actor $actor) { return view('actors.show', compact('actor')); }

    public function edit(Actor $actor) { return view('actors.edit', compact('actor')); }

    public function update(Request $r, Actor $actor) {
        $data = $r->validate([
            'first_name'=>'required|string|max:45',
            'last_name'=>'required|string|max:45',
        ]);
        $actor->update($data);
        return redirect()->route('actors.index')->with('ok','Actor actualizado');
    }

    public function destroy(Actor $actor) {
        $actor->delete();
        return back()->with('ok','Actor eliminado');
    }
}
