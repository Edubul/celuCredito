<?php

namespace App\Http\Controllers;

use App\Models\Celulares;
use App\Models\Marcas;
use App\Models\User;
use App\Models\Ventas;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class VentasController extends Controller
{
    //
    public function index()
    {
        $ventas = Ventas::select('ventas.id', 'celulares.modelo', 'marcas.name', 'ventas.nombre_cliente', 'ventas.numero_celular_cliente', 'ventas.imei', 'ventas.precio', 'ventas.fecha', 'ventas.cc_cliente')
            ->join('celulares', 'celulares.id', '=', 'ventas.id_celular')
            ->join('marcas', 'marcas.id', '=', 'celulares.marca_id')
            ->filter(Request::only('search', 'opcion'))
            ->orderBy('fecha', 'desc')
            ->paginate(10);


        return Inertia::render('Ventas/Index', [
            'ventas' => $ventas,
            'filters' => Request::all('search', 'opcion'),
        ]);
    }

    public function create()
    {
        $marcas = Marcas::pluck('name', 'id');
        $modelos = Celulares::where('marca_id', Request::only('modelos'))->pluck('modelo', 'id');
        return Inertia::render('Ventas/Create', [
            'marcas' => $marcas,
            'modelos' => $modelos,

        ]);
    }

    public function edit(Ventas $venta)
    {
        $marcas = Marcas::pluck('name', 'id');
        $modelos = Celulares::where('marca_id', Request::only('modelos'))->pluck('modelo', 'id');

        // dd();
        return Inertia::render('Ventas/Edit', [
            'venta' => [
                'id' => $venta->id,
                'id_celular' => $venta->id_celular,
                'nombre_cliente' => $venta->nombre_cliente,
                'numero_celular_cliente' => $venta->numero_celular_cliente,
                'imei' => $venta->imei,
                'cc_cliente' => $venta->cc_cliente,
                'fecha' => $venta->fecha,
                'marcas' => $marcas,
                'precio' => $venta->precio,
                'modelos' => $modelos,
            ],
        ]);
    }

    public function update()
    {
        $venta = Ventas::findOrFail(Request::only('id'))->first();
        // dd($ventas->id);
        $request = Request::validate([
            'id_celular' => ['required', 'numeric', 'exists:celulares,id'],
            'marca' => ['required', 'numeric', 'exists:marcas,id'],
            'modelo' => ['required'],
            'nombre_cliente' => ['required', 'string', 'max:50'],
            'numero_celular_cliente' => ['required', 'max:50'],
            'imei' => ['required', 'numeric'],
            'cc_cliente' => ['required', 'max:50'],
            'precio' => ['required'],
            'fecha' => ['required', 'max:50'],
        ]);
        $celular = Celulares::where('marca_id', Request::only('marca'))->first();

        $venta->update(
            [
                'id_celular' => $celular->id,
                'nombre_cliente' => $request['nombre_cliente'],
                'numero_celular_cliente' => $request['numero_celular_cliente'],
                'imei' => $request['imei'],
                'cc_cliente' => $request['cc_cliente'],
                'precio' => $request['precio'],
                'fecha' => $request['fecha'],
            ]
        );

        // dd(Request::all());

        return Redirect::back()->with('success', 'Venta actualizada.');
    }

    public function store()
    {
        $celular = Celulares::where('marca_id', Request::only('marca'))->first();

        $request = Request::validate([
            // 'id_celular' => ['required', 'numeric', 'exists:celulares,id'],
            'nombre_cliente' => ['required', 'string', 'max:50'],
            'numero_celular_cliente' => ['required', 'max:50'],
            'imei' => ['required', 'numeric'],
            'cc_cliente' => ['required', 'max:50'],
            'precio' => ['required'],
            'fecha' => ['required', 'max:50'],
        ]);
        $celular->update(
            ['stock' => $celular->stock - 1]
        );
        Ventas::create([
            'id_celular' => $celular->id,
            'nombre_cliente' => $request['nombre_cliente'],
            'numero_celular_cliente' => $request['numero_celular_cliente'],
            'imei' => $request['imei'],
            'cc_cliente' => $request['cc_cliente'],
            'precio' => $request['precio'],
            'fecha' => $request['fecha'],
        ]);
        return Redirect::route('ventas')->with('success', 'Venta creada exitosamente.');
    }

    public function destroy($venta_id)
    {
        $venta = Ventas::findOrFail($venta_id);
        $venta->delete();

        return Redirect::route('ventas')->with('success', 'Venta deleted.');
    }
}
