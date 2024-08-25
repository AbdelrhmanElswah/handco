<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Services\MediaUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', 


        ]);

        $product = Product::create($request->only('name', 'details', 'price', 'category_id'));


        if ($request->hasFile('images')) {
            $mediaUploadService = new MediaUploadService();
            $mediaUploadService->uploadMedia($request->file('images'), $product, 'products/');
        }

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
        // Find the product or fail
        $product = Product::findOrFail($id);
    
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'details' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image.*' => 'sometimes|file|mimes:jpg,jpeg,png,gif|max:10240',
        ]);
    
        // Update the product's basic details
        $product->update([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'details' => $validatedData['details'],
            'category_id' => $validatedData['category_id'],
        ]);
    
        // Debug: Check if files are being uploaded
        if ($request->hasFile('image')) {
            
            $mediaUploadService = new MediaUploadService();
            $result = $mediaUploadService->uploadMedia($request->file('image'), $product, 'products');
            
            if (!$result) {
                return redirect()->back()->withErrors('Failed to upload media.');
            }
        } 
    
        return redirect()->route('products')->with('success', 'Product updated successfully.');
    }
    

    

    public function deleteMedia(Request $request, $id)
    {
        try {
            $media = Media::findOrFail($id);
            $product = $media->modelable; 
    
            $media->delete();
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Failed to delete media: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete media'], 500);
        }
    }
    

    
    public function destroy($id)
    {
    $products = Product::findOrFail($id);
    $products->delete();
    return redirect()->route('products')->with('error', 'Product deleted successfully');
    }
}
