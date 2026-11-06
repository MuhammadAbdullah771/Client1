<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order')->orderBy('name')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? true : false;

        try {
            Category::create($validated);
            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Category creation failed: ' . $e->getMessage(), [
                'data' => $validated,
            ]);
            
            return back()->withInput()->withErrors([
                'error' => 'Failed to create category: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        try {
            $category->update($validated);
            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Category update failed: ' . $e->getMessage(), [
                'category_id' => $category->id,
                'data' => $validated,
            ]);
            
            return back()->withInput()->withErrors([
                'error' => 'Failed to update category: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(Category $category)
    {
        if ($category->insights()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category with existing insights.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}

