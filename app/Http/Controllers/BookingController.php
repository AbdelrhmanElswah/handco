<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Contact;
use App\Models\Project; // Assuming bookings are related to projects
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        $contacts = Contact::all();
        return view('dashboard.booking.index', compact('bookings', 'contacts'));
    }
    use Illuminate\Support\Facades\Http;

public function store(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'email' => 'required|email',
        'message' => 'nullable|string',
    ]);

    $project = Project::find($request->project_id);

    if ($project->status === 'sold_out') {
        return redirect()->back()->with('error', 'This Property is sold out.');
    }

    Booking::create($request->only(['project_id', 'name', 'phone_number', 'email', 'message']));

  
    try {
        $response = Http::withHeaders([
            'X-PIXXI-TOKEN' => '***REMOVED***', 
            'Content-Type' => 'application/json',
        ])->post('https://dataapi.pixxicrm.ae/pixxiapi/webhook/v1/form', [
            'formId' => 'dda077d2-085e-45ce-b20a-8b8237678348', 
            'propertyId' => (string) ($project->id ?? ''),
            'name' => $request->name,
            'phone' => $request->phone_number,
            'email' => $request->email,
            'nationality' => 'UAE',
            'extraData' => [
                'message' => $request->message,
                'project' => $project->title,
            ],
        ]);

        if (!$response->successful()) {
            \Log::warning('Pixxi API error', ['body' => $response->body()]);
        }
    } catch (\Exception $e) {
        \Log::error('Pixxi API exception', ['error' => $e->getMessage()]);
    }

    return redirect()->back()->with('success', 'Booking created and sent to Pixxi CRM.');
}

    public function exportToCSV()
    {
        $bookings = Booking::with('project')->get();
        $contacts = Contact::all();

        $response = new StreamedResponse(function () use ($bookings, $contacts) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, ['ID', 'Type', 'Project/Subject', 'Name', 'Email', 'Phone Number', 'Message']);

            // Add Bookings data
            foreach ($bookings as $booking) {
                fputcsv($handle, [
                    $booking->id,
                    'Booking',
                    $booking->project->title ?? 'N/A',
                    $booking->name,
                    $booking->email,
                    $booking->phone_number,
                    $booking->message,
                ]);
            }

            // Add Contacts data
            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->id,
                    'Contact',
                    $contact->subject ?? 'N/A',
                    $contact->name,
                    $contact->email,
                    'N/A', // Contacts don't have phone numbers
                    $contact->message,
                ]);
            }

            fclose($handle);
        });

        // Define headers
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="bookings_contacts.csv"');

        return $response;
    }

}
