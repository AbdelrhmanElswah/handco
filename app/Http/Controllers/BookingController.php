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

    public function create()
    {
        $projects = Project::all(); // Get all projects for the booking form
        return view('dashboard.booking.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'message' => 'nullable|string',
        ]);

        Booking::create($request->only(['project_id', 'name', 'email', 'phone_number', 'message']));
        return redirect()->route('booking.index')->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking)
    {
        $projects = Project::all();
        return view('dashboard.booking.edit', compact('booking', 'projects'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'message' => 'nullable|string',
        ]);

        $booking->update($request->only(['project_id', 'name', 'email', 'phone_number', 'message']));
        return redirect()->route('booking.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('booking.index')->with('success', 'Booking deleted successfully.');
    }
}
