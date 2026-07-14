<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $ventasHoy = Sale::whereDate('created_at', today())->sum('total');
        $pedidosHoy = Sale::whereDate('created_at', today())->count();
        $productosSinStock = Product::where('stock', '<=', 0)
            ->where('always_available', false)
            ->get();

        return view('dashboard', compact('ventasHoy', 'pedidosHoy', 'productosSinStock'));
    }
}