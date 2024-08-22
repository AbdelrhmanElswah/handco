<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('category')->get();
        return view('dashboard.products.index',compact('products'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($request->all());

        return redirect()->route('products')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $products = Product::find($id);

        if(!$products){
            return redirect()->route('products')->with('error', 'Product not found.');
        }

        return view('dashboard.products.edit', compact('products','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Find the article by ID
        $products = Product::findOrFail($id);

        $products->name = $request->input('name');
        $products->details = $request->input('details');
        $products->price = $request->input('price');
        $products->category_id = $request->input('category_id');
        $products->save();

        return redirect()->route('products')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
    $products = Product::findOrFail($id);
    $products->delete();
    return redirect()->route('products')->with('error', 'Product deleted successfully');
    }
}
