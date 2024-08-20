<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactUsRequest;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Portfolio;
use App\Traits\HandleResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use HandleResponse;

    public function __construct(protected Contact $contact ,protected Blog $blog ,protected Portfolio $portfolio)
    {

    }

    // Store contact information
    public function store(StoreContactUsRequest $request)
    {
        $contact = $this->contact::create($request->validated());

        return $this->successWithData($contact,'Contact information submitted successfully!');
    }

    public function getBlogs()
    {
        $blogs = $this->blog::paginate();

        return  $this->successWithData($blogs,'Blogs fetched successfully!');
    }

    public function getBlog($id)
    {
    $blog = $this->blog::find($id);

         if ($blog) {
                return $this->successWithData($blog, 'Blog fetched successfully!');
                 } else {
                return $this->errorResponse('Blog not found!', 404);
            }
    }

    public function getPortfolios()
    {
        $portfolios = $this->portfolio::paginate();

        return $this->successWithData($portfolios,'Portfolios fetched successfully!');
    }
}
