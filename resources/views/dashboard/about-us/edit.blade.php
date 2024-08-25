@extends('dashboard.partials.app')

@section('content')

<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Edit Product</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Products
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('products.update', $products->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Use PUT method for updating -->

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Product Name" aria-label="name" value="{{ old('name', $products->name) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" class="form-control" name="price" placeholder="Price" aria-label="price" value="{{ old('price', $products->price) }}" min="0" step="0.01">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="details" class="form-label">Details</label>
                                    <textarea class="form-control" name="details" id="details" rows="3">{{ old('details', $products->details) }}</textarea>
                                </div>
                            </div>

                            <!-- Row containing Category Select and Image Upload -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-select" name="category_id" aria-label="category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $products->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Upload New Images</label>
                                    <input type="file" class="form-control" name="image[]" aria-label="image" multiple>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Existing Images</label>
                                    <div class="d-flex flex-wrap">
                                        @foreach($products->media as $media)
                                           <div class="position-relative me-2 mb-2" id="image_{{ $media->id }}">
                                           <img src="{{ $media->media_link }}" alt="{{ $products->name }}" width="100" class="img-thumbnail">
                                           <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeImage({{ $media->id }})">
                                           &times;
                                                </button>
                                          <input type="hidden" name="existing_images[]" value="{{ $media->id }}">
                                            <input type="hidden" name="deleted_images[]" id="deleted_image_{{ $media->id }}" value="{{$media->id }}">
                                                    </div>
                                @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function removeImage(mediaId) {
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    fetch(`/admin/products/media/${mediaId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: mediaId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`image_${mediaId}`).remove();
            console.log(`Image with ID ${mediaId} deleted successfully.`);
        } else {
            console.error('Failed to delete image:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}


</script>
 

@endsection
