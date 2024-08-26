<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactUsRequest;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Portfolio;
use App\Models\Setting;
use App\Traits\HandleResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use HandleResponse;

    public function __construct(protected Contact $contact , protected Setting $settings)
    {

    }

    // Store contact information
    public function store(StoreContactUsRequest $request)
    {
        $contact = $this->contact::create($request->validated());

        return $this->successWithData($contact,'Contact information submitted successfully!');
    }

    public function getAboutUs()
    {
        $setting = $this->settings::first();

        if ($setting) {
            return $this->successWithData($setting->about_us, 'About Us content fetched successfully!');
        } else {
            return $this->errorResponse('About Us content not found', 404);
        }
    }
}
