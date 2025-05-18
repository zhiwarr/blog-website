<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoriesController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/Categories/Index', [
            'categories' => CategoryResource::collection(Category::latest()->paginate()->withQueryString())
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Categories/Form');
    }
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Admin/Categories/Form', [
            'category' => $category
        ]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return redirect()->back()->with('error', 'Category has posts');
        }
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
