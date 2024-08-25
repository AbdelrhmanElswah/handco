@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Create About Us</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">
                                About Us
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

                            <form method="post" action="{{ route('about.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="5" placeholder="About Us description">{{ old('description', $setting->about_us ?? '') }}</textarea>
                                    </div>


                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Add</button>
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
