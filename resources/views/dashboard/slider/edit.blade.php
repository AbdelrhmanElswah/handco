@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Edit Slider</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Slider</li>
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
                    <form method="POST" action="{{ route('sliders.update', $slider->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" style="font-size: 21px">Title</label>
                                    <input type="text" placeholder="Slider Title"  name="title" class="form-control" value="{{ old('title', $slider->title) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subtitle"style="font-size: 21px">Subtitle</label>
                                    <input type="text" placeholder="Slider Subtitle" name="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle) }}">
                                </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="description" style="font-size: 21px">Description</label>
                                    <textarea name="description" class="form-control" id="description">{{ old('description', $slider->description) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="button_text" style="font-size: 21px">Button Text</label>
                                    <input type="text" placeholder="Button Text" name="button_text" class="form-control" value="{{ old('button_text', $slider->button_text) }}">
                                </div>
                                <div class="form-group">
                                    <label for="button_link" style="font-size: 21px">Button Link</label>
                                    <input type="url" placeholder="Button Link" name="button_link" class="form-control" value="{{ old('button_link', $slider->button_link) }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="main_image" style="font-size: 21px">Main Image</label>
                                    <input type="file" name="main_image" class="form-control" accept="image/*">
                                    <small class="text-muted">Upload an image (JPEG, PNG, JPG, GIF - Max 2MB)</small>
                                    @if($slider->mainImage)
                                        <div class="mt-2">
                                            <img src="{{ $slider->mainImage->media_link }}" alt="Main Image" class="img-fluid" width="150" style="display: block; margin-bottom: 10px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="delete_main_image" id="delete_main_image" value="1">
                                                <label class="form-check-label text-danger" for="delete_main_image" style="font-size: 14px;">
                                                    <i class="fas fa-trash"></i> Delete Image
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="main_video" style="font-size: 21px">Main Video (Alternative)</label>
                                    <input type="file" name="main_video" class="form-control" accept="video/*">
                                    <small class="text-muted">Upload a video (MP4, WebM, OGG - Max 10MB)</small>
                                    @if($slider->mainVideo)
                                        <div class="mt-2">
                                            <video width="150" controls style="display: block; margin-bottom: 10px;">
                                                <source src="{{ $slider->mainVideo->media_link }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="delete_main_video" id="delete_main_video" value="1">
                                                <label class="form-check-label text-danger" for="delete_main_video" style="font-size: 14px;">
                                                    <i class="fas fa-trash"></i> Delete Video
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update Slider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
