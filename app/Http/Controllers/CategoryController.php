<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'type' => 'required|string|max:255',
        ]);

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Categoría creada');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'type' => 'required|string|max:255',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->withErrors('No puedes eliminar una categoría con productos asignados');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada');
    }
}
