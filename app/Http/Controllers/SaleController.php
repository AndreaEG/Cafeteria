<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)
            ->orWhere('always_available', true)
            ->orderBy('name')
            ->get();

        return view('pos.index', compact('products'));
    }

    // Búsqueda rápida (AJAX) por nombre o código de barras
    public function search(Request $request)
    {
        $q = $request->get('q');

        $products = Product::where('name', 'ilike', "%{$q}%")
            ->orWhere('barcode', $q)
            ->orWhere('internal_sku', $q)
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        try {
            $sale = DB::transaction(function () use ($data) {
                $sale = Sale::create(['user_id' => auth()->id(), 'total' => 0]);
                $total = 0;

                foreach ($data['items'] as $item) {
                    // Bloqueo de fila para evitar condiciones de carrera en el stock
                    $product = Product::where('id', $item['product_id'])->lockForUpdate()->first();

                    // RN-03: bloquear venta si no hay stock (salvo "siempre disponible")
                    if (!$product->always_available && $product->stock < $item['quantity']) {
                        throw new \Exception("Stock insuficiente para {$product->name}");
                    }

                    $subtotal = $product->sale_price * $item['quantity'];

                    $sale->details()->create([
                        'product_id' => $product->id,
                        'quantity'   => $item['quantity'],
                        'unit_price' => $product->sale_price,
                        'subtotal'   => $subtotal,
                    ]);

                    if (!$product->always_available) {
                        $product->decrement('stock', $item['quantity']);
                    }

                    $total += $subtotal;
                }

                $sale->update(['total' => $total]);
                return $sale;
            });

            return response()->json(['success' => true, 'sale_id' => $sale->id, 'total' => $sale->total]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}