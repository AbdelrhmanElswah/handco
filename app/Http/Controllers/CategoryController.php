<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\MediaUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::with('media')->get(); 
        return view('dashboard.category.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $category =Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        if(isset($request->image)){
            (new mediaUploadService())->uploadMedia($request->image, $category, 'categories');
        }


        return redirect()->route('category')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('category')->with('error', 'Category not found.');
        }

        return view('dashboard.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();

        if(isset($request->image)){
            (new mediaUploadService())->editMedia([$request->image],$category,'categories');
        }

        return redirect()->route('category')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        ($this->mediaUploadService())->deleteMedia(null, $category, 'files/categories/');

        $category->delete();
        return redirect()->route('category')->with('error', 'Category deleted successfully');
    }
}
