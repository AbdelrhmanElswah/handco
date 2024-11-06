<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Project; // Assuming bookings are related to projects
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('dashboard.booking.index', compact('bookings'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email',
            'message' => 'nullable|string',
        ]);

        // Retrieve the project
        $project = Project::find($request->project_id);

        // Check if the project is sold out
        if ($project->status === 'sold_out') {
            return redirect()->back()->with('error', 'This Property is sold out.');
        }

        // Create the booking if project is available
        Booking::create($request->only(['project_id', 'name', 'phone_number', 'email', 'message']));

        return redirect()->back()->with('success', 'Booking created successfully');
    }
}
