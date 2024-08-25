@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Create Product</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Product</li>
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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Product Name" value="{{ old('name') }}" aria-label="name">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="Price" value="{{ old('price') }}" aria-label="price" min="0" step="1">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="details" class="form-label">Details</label>
                                        <textarea class="form-control" name="details" id="details" rows="3">{{ old('details') }}</textarea>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" name="category_id" aria-label="category">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="images">Icons</label>
                                            <input type="file" name="images[]" class="form-control" multiple>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Add Product</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
