<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactUsRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Setting;
use App\Traits\HandleResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use HandleResponse;

    public function __construct(protected Contact $contact , protected Setting $settings , protected Category $category, protected Product $product)
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
            return $this->badRequestResponse('About Us content not found', 404);
        }
    }
    public function getProductsByCategory($categoryId)
    {
        // Validate the category ID
        $categories = $this->category::find($categoryId);
    
        if (!$categories) {
            return $this->badRequestResponse('Category not found', 404);
        }
    
        // Retrieve products that belong to the specified category
        $products = $this->product::where('category_id', $categoryId)->with('category','media')->get();
    
        return $this->successWithData($products, 'Products fetched successfully!');
    }

    public function getCategory($id)
{
    // Find the category or fail
    $categories = $this->category::with('media')->find($id);

    if ($categories) {
        return $this->successWithData($categories, 'Category fetched successfully!');
    } else {
        return $this->badRequestResponse('Category not found', 404);
    }
}

    

    


}
