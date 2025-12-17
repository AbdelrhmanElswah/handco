@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Edit Community</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Community</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card custom-card">
                <div class="card-body">
                    <form method="POST" action="{{ route('community.update', $community->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" style="font-size: 21px">Title (Community Name)</label>
                                    <input type="text" placeholder="Title" name="title" class="form-control" value="{{ old('title', $community->title) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subtitle" style="font-size: 21px">Subtitle (Optional)</label>
                                    <input type="text" placeholder="Subtitle" name="subtitle" class="form-control" value="{{ old('subtitle', $community->subtitle) }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="content" style="font-size: 21px">Content</label>
                                    <textarea name="content" class="form-control" rows="5" required>{{ old('content', $community->content) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="main_image" style="font-size: 21px">Main Image</label>
                                    <input type="file" name="main_image" class="form-control">
                                    @if($community->mainImage)
                                        <small class="text-muted">Current image: <a href="{{ $community->mainImage->media_link }}" target="_blank">View</a></small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="location_link" style="font-size: 21px">Google Maps Embed URL (Optional)</label>
                                    <input type="url" placeholder="https://www.google.com/maps/embed?pb=..." name="location_link" class="form-control" value="{{ old('location_link', $community->location_link) }}">
                                    <small class="text-muted">Get embed URL from Google Maps: Share → Embed a map → Copy HTML → Extract src URL</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update Community</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
