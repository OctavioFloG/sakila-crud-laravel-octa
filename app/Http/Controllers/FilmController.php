<?php
namespace App\Http\Controllers;
use App\Models\Film;
use App\Models\Actor;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index() {
        $films = Film::withCount('actors')->orderBy('film_id','desc')->get();
        return view('films.index', compact('films'));
    }

    public function create() {
        $actors = Actor::orderBy('first_name')->get();
        return view('films.create', compact('actors'));
    }

    public function store(Request $r) {
        $data = $r->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'release_year'=>'nullable|integer',
            'language_id'=>'required|integer',
            'rental_duration'=>'required|integer',
            'rental_rate'=>'required|numeric',
            'length'=>'nullable|integer',
            'replacement_cost'=>'required|numeric',
            'rating'=>'nullable|string|max:10',
            'actor_ids'=>'array'
        ]);
        $film = Film::create($data);
        $film->actors()->sync($r->input('actor_ids', [])); // usa tabla film_actor
        return redirect()->route('films.index')->with('ok','Película creada');
    }

    public function edit(Film $film) {
        $actors = Actor::orderBy('first_name')->get();
        $film->load('actors');
        return view('films.edit', compact('film','actors'));
    }

    public function update(Request $r, Film $film) {
        $data = $r->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'release_year'=>'nullable|integer',
            'language_id'=>'required|integer',
            'rental_duration'=>'required|integer',
            'rental_rate'=>'required|numeric',
            'length'=>'nullable|integer',
            'replacement_cost'=>'required|numeric',
            'rating'=>'nullable|string|max:10',
            'actor_ids'=>'array'
        ]);
        $film->update($data);
        $film->actors()->sync($r->input('actor_ids', []));
        return redirect()->route('films.index')->with('ok','Película actualizada');
    }

    public function show(Film $film) {
        $film->load('actors','inventories');
        return view('films.show', compact('film'));
    }

    public function destroy(Film $film) {
        $film->actors()->detach();
        $film->delete();
        return back()->with('ok','Película eliminada');
    }
}
