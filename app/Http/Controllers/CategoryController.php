<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class CategoryController extends Controller
{

    public function index()
    {
        $blogs = Category::all();
        return view('dashboard.category.index',compact('blogs'));
    }


    public function create()
    {
        return view('dashboard.category.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }



        Category::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath,
        ]);

        return redirect()->route('blog')->with('success', 'Blog created successfully');
    }

    public function edit($id)
    {
        $blog = Category::find($id);

        if(!$blog){
            return redirect()->route('blog')->with('error', 'Blog not found.');
        }

        return view('dashboard.category.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        // Find the article by ID
        $blog = Category::findOrFail($id);

        // Handle the image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($blog->image) {
                Storage::delete('public/' . $blog->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('blogs', 'public');
            $blog->image = $imagePath;
        }

        // Update the article with the new data
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->save();

        // Redirect to the article listing page with a success message
        return redirect()->route('blog')->with('success', 'Blog updated successfully');
    }

    public function destroy($id)
    {
    $blog = Category::findOrFail($id);
    $blog->delete();
    return redirect()->route('blog')->with('error', 'Blog deleted successfully');
    }
}
