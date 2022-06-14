<?php

namespace App\Http\Controllers;

use App\Models\Gastos;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class GastosController extends Controller
{
    //
    public function index()
    {

        // dd(Request::all('search', 'opcion'));
        return Inertia::render('Gastos/Index', [
            'filters' => Request::all('search', 'opcion'),
            'gastos' => Gastos::with('user')
                ->orderBy('fecha', 'desc')
                ->filter(Request::only('search', 'opcion'))
                ->paginate(10),
        ]);
    }

    public function create()
    {
        $user = User::all();
        // dd($user);
        return Inertia::render('Gastos/Create', ['gastos' => [
            'user' => $user,
        ]]);
    }

    public function store()
    {

        $request = Request::validate([
            // 'id_celular' => ['required', 'numeric', 'exists:celulares,id'],
            'user_id' => ['required', 'numeric'],
            'motivo' => ['required', 'max:150'],
            'cantidad' => ['required', 'numeric'],
            'fecha' => ['required'],

        ]);
        dd($request);
        Gastos::create([
            'user_id' => $request['user_id'],
            'motivo' => $request['motivo'],
            'cantidad' => $request['cantidad'],
            'fecha' => $request['fecha'],
        ]);

        return Redirect::route('gastos')->with('success', 'Gasto creado exitosamente.');
    }

    public function edit($gasto_id)
    {
        $gasto = Gastos::findOrFail($gasto_id);
        return Inertia::render('Gastos/Edit', [
            'gasto' => [
                'id' => $gasto->id,
                'empleado' => $gasto->user->name,
                'motivo' => $gasto->motivo,
                'cantidad' => $gasto->cantidad,
                'fecha' => $gasto->fecha,
            ]
        ]);
    }

    public function update($gasto_id)
    {
        $gasto = Gastos::findOrFail($gasto_id);
        $request = Request::validate([
            'motivo' => ['required', 'max:150'],
            'cantidad' => ['required', 'numeric'],
            'fecha' => ['required', 'date'],
        ]);

        $gasto->update([
            'motivo' => $request['motivo'],
            'cantidad' => $request['cantidad'],
            'fecha' => $request['fecha'],
        ]);

        return Redirect::back()->with('success', 'Gasto actualizado.');
    }

    public function destroy($gasto_id)
    {
        $gasto = Gastos::findOrFail($gasto_id);
        $gasto->delete();
        return Redirect::route('gastos')->with('success', 'Gasto eliminado.');
    }
}
