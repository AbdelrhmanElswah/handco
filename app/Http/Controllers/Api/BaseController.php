<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    // Store contact information
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Contact information submitted successfully!',
            'data' => $contact,
        ], 201);
    }

    public function getBlogs(Request $request)
    {
        $perPage = $request->input('per_page', 10); 
        $blogs = Blog::paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $blogs,
        ], 200);
    }

    // Fetch all portfolios with pagination
    public function getPortfolios(Request $request)
    {
        $perPage = $request->input('per_page', 10); 
        $portfolios = Portfolio::paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $portfolios,
        ], 200);
    }
}
