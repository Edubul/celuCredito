<?php

namespace App\Http\Controllers;

use App\Models\Celulares;
use App\Models\Marcas;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CelularesController extends Controller
{
    public function index()
    {
        $celulares = Celulares::with('marca')->paginate(10);
        // dd($celulares);

        return Inertia::render('Celulares/Index', [
            'celulares' => $celulares,

        ]);
    }

    public function create()
    {
        $marcas = Marcas::all();
        return Inertia::render('Celulares/Create', [
            'marcas' => $marcas,
        ]);
    }

    public function store()
    {
        // dd(Request::all());
        $request = Request::validate([
            'modelo' => ['required', 'string', 'max:25'],
            'marca_id' => ['required', 'integer', 'exists:marcas,id'],
            'stock' => ['required', 'min:1'],
        ]);


        Celulares::create([
            'modelo' => $request['modelo'],
            'marca_id' => $request['marca_id'],
            'stock' => $request['stock'],
        ]);

        return Redirect::back()->with('success', 'Celular agregado correctamente');
    }

    public function edit()
    {
        $celular = Celulares::findOrFail(Request::route('celular_id'));
        $marcas = Marcas::all();
        // dd($celular);
        return Inertia::render('Celulares/Edit', [
            'celular' => $celular,
            'marcas' => $marcas,
        ]);
    }

    public function update()
    {

        $request = Request::validate([
            'id' => ['required', 'numeric', 'exists:celulares,id'],
            'modelo' => ['required', 'string', 'max:25'],
            'marca_id' => ['required', 'integer', 'exists:marcas,id'],
            'stock' => ['required', 'min:1'],
        ]);

        $celular = Celulares::findOrFail($request['id'])->where('id', $request['id'])->first();
        // dd($celular);
        $celular->update([
            'id' => $request['id'],
            'modelo' => $request['modelo'],
            'marca_id' => $request['marca_id'],
            'stock' => $request['stock'],

        ]);

        return Redirect::back()->with('success', 'Celular actualizado correctamente');
    }

    public function destroy($celular_id)
    {
        $celulares = Celulares::findOrFail($celular_id);
        $celulares->delete();

        return Redirect::route('celulares')->with('success', 'Celular eliminado correctamente');
    }
}
