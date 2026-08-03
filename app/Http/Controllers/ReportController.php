<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to   = $request->get('to', now()->toDateString());

        $fromDate = Carbon::parse($from)->startOfDay();
        $toDate   = Carbon::parse($to)->endOfDay();

        $sales = Sale::with('details.product')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        $totalVentas = $sales->sum('total');

        $totalGanancia = $sales->flatMap->details->sum(function ($detail) {
            return ($detail->unit_price - $detail->product->cost_price) * $detail->quantity;
        });

        return view('reports.index', compact('sales', 'totalVentas', 'totalGanancia', 'from', 'to'));
    }
}
