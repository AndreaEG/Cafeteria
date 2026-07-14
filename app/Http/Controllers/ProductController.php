<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('name')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'barcode'      => 'nullable|string|unique:products,barcode',
            'cost_price'   => 'required|numeric|min:0',
            'sale_price'   => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'min_stock'    => 'nullable|integer|min:0',
            'always_available' => 'nullable|boolean',
            // RN: solo jpg, png, webp y máximo 2MB
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        AuditLog::log('created', 'products', $product->id, null, $product->toArray());

        return redirect()->route('products.index')->with('success', 'Producto creado');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $old = $product->toArray();

        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'barcode'      => 'nullable|string|unique:products,barcode,' . $product->id,
            'cost_price'   => 'required|numeric|min:0',
            'sale_price'   => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'min_stock'    => 'nullable|integer|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        AuditLog::log('updated', 'products', $product->id, $old, $product->toArray());

        return redirect()->route('products.index')->with('success', 'Producto actualizado');
    }

    public function destroy(Product $product)
    {
        $old = $product->toArray();
        $product->delete(); // soft delete: se mantiene para auditoría contable

        AuditLog::log('deleted', 'products', $product->id, $old, null);

        return redirect()->route('products.index')->with('success', 'Producto eliminado');
    }

    public function adjustStock(Request $request, Product $product)
    {
        $data = $request->validate(['stock' => 'required|integer|min:0']);
        $old = $product->toArray();
        $product->update(['stock' => $data['stock']]);

        AuditLog::log('stock_adjusted', 'products', $product->id, $old, $product->toArray());

        return back()->with('success', 'Stock ajustado');
    }
}