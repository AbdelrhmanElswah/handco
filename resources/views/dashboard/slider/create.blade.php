@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Add Slider</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Slider</li>
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
                    <form method="POST" action="{{ route('sliders.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" style="font-size: 21px">Title</label>
                                    <input type="text" placeholder="Slider Title" name="title" class="form-control" value="{{ old('title') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subtitle"style="font-size: 21px">Subtitle</label>
                                    <input type="text" placeholder="Slider Subtitle" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
                                </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="description" style="font-size: 21px">Description</label>
                                    <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="button_text" style="font-size: 21px">Button Text</label>
                                    <input type="text" placeholder="Button Text" name="button_text" class="form-control" value="{{ old('button_text') }}">
                                </div>
                                <div class="form-group">
                                    <label for="button_link"style="font-size: 21px">Button Link</label>
                                    <input type="url" placeholder="Button Link" name="button_link" class="form-control" value="{{ old('button_link') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="main_image" style="font-size: 21px">Main Image</label>
                                    <input type="file" name="main_image" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Add Slider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
