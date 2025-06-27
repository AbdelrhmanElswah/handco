<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PixxiController extends Controller
{
    private $apiUrl = 'https://dataapi.pixxicrm.ae/pixxiapi/v1/properties';

    private $authToken = 'eyJhbGciOiJIUzUxMiJ9.eyJ1c2VyUGFzc3dvcmQiOiIkMmEkMTAkNGtjOWg5R3BsMEdrSGsyd09NRFpTT2NzUGM3WTlRMjAyWDVhdFZvSDBwN2N0a2RVMWk5VG0iLCJ1c2VyRW1haWwiOiJpbmZvQGhhbmRjb3Byb3BlcnRpZXMuY29tIiwidXNlck5pY2tOYW1lIjoiU2lhcm1pZSBHb256YWxlcyIsInVzZXJUeXBlIjoiVEVOQU5UX1VTRVIiLCJ1c2VyaWQiOjM4NDMsInZlcnNpb24iOiJ2MjAyNTA3MDcifQ.fsrxHZkqGcWyWbJ7skkgMKGXAvqqwapXOW4_da5DU-_T0k8_gIzRDgu3FR5f28JqYXP_p_IyBC-JRIL9XgE1Hw';

    private $pixxiToken = '***REMOVED***';

    public function index(Request $request)
    {
        $listingType = $request->get('listingType', 'SELL');
        $status = $request->get('status', 'ACTIVE');
        $currentPage = $request->get('page', 1);

        $properties = $this->fetchPixxiProperties($listingType, $status, $currentPage);

        return view('dashboard.pixxi-properties.index', compact('properties', 'listingType', 'status', 'currentPage'));
    }

    private function fetchPixxiProperties($listingType = 'SELL', $status = 'ACTIVE', $page = 1)
    {
        try {
            $response = Http::withHeaders([
                'Authorization'   => 'Bearer ' . $this->authToken,
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'X-PIXXI-TOKEN'   => $this->pixxiToken
            ])->post($this->apiUrl, [
                'listingType' => $listingType,
                'status'      => $status,
                'page'        => $page
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Pixxi API Error: ' . $response->body());
                return [
                    'statusCode' => 500,
                    'message' => 'Failed to fetch properties',
                    'data' => ['list' => [], 'totalListings' => 0, 'totalSize' => 0]
                ];
            }
        } catch (\Exception $e) {
            Log::error('Pixxi API Exception: ' . $e->getMessage());
            return [
                'statusCode' => 500,
                'message' => 'API connection failed: ' . $e->getMessage(),
                'data' => ['list' => [], 'totalListings' => 0, 'totalSize' => 0]
            ];
        }
    }
public function show($propertyId)
{
    try {
        $url = "https://dataapi.pixxicrm.ae/pixxiapi/v1/$propertyId";

        $response = Http::withHeaders([
            'X-PIXXI-TOKEN' => $this->pixxiToken,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->get($url); // ✅ GET مش POST

        if ($response->successful()) {
            $property = $response->json('data');
            if (!$property || !isset($property['id'])) {
                abort(404, 'Property not found');
            }

            return view('dashboard.pixxi-properties.show', compact('property'));
        } else {
            Log::error('Pixxi Show API Error: ' . $response->body());
            abort(500, 'Error loading property');
        }

    } catch (\Exception $e) {
        Log::error('Pixxi Show Exception: ' . $e->getMessage());
        abort(500, 'API Error');
    }
}



}
