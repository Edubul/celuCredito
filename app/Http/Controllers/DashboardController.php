<?php

namespace App\Http\Controllers;

use App\Models\Celulares;
use App\Models\Gastos;
use App\Models\Ventas;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        $date = (Request::get('date')) ? Request::get('date') : date('Y-m-d');
        $dateTime = date('Y-m-d', strtotime($date));
        $totalGastos = Gastos::sum('cantidad');
        $totalVentas = Celulares::join('ventas', 'ventas.id_celular', '=', 'celulares.id')->sum('precio');
        $totalCelulares = Celulares::sum('stock');
        $totalVentasHoy = Celulares::join('ventas', 'ventas.id_celular', '=', 'celulares.id')->where('ventas.fecha', $dateTime)->sum('precio');
        $totalGastosHoy = Gastos::where('fecha', $dateTime)->sum('cantidad');

        $resumenToday = Ventas::select(
            'celulares.modelo',
            'marcas.name',
            DB::raw('count(ventas.id_celular) as totalVendidos'),
            DB::raw('sum(celulares.precio) as precioTotal'),
            'ventas.fecha'
        )
            ->join('celulares', 'celulares.id', '=', 'ventas.id_celular')
            ->join('marcas', 'marcas.id', '=', 'celulares.marca_id')
            ->where('ventas.fecha', $dateTime)
            ->groupBy('marcas.name', 'celulares.modelo', 'ventas.fecha')
            ->paginate();

        // dd($dateTime);

        return Inertia::render('Dashboard/Index', [
            'filter' => Request::all('search'), 'totalGastos' => $totalGastos,
            'totalVentas' => $totalVentas, 'totalCelulares' => $totalCelulares,
            'resumenToday' => $resumenToday, 'totalVentasHoy' => $totalVentasHoy,
            'totalGastosHoy' => $totalGastosHoy, 'gastos' => Gastos::with('user')->orderBy('fecha', 'desc')->where('gastos.fecha', $dateTime)->paginate(10),
        ]);
    }
}
