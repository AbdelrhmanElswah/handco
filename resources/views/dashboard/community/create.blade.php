@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Add Community</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Community</li>
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
                    <form method="POST" action="{{ route('community.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" style="font-size: 21px">Title (Community Name)</label>
                                    <input type="text" placeholder="Title" name="title" class="form-control" value="{{ old('title') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subtitle" style="font-size: 21px">Subtitle (Optional)</label>
                                    <input type="text" placeholder="Subtitle" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="content" style="font-size: 21px">Content</label>
                                    <div id="community-content-editor" style="height: 400px;">{!! old('content', '') !!}</div>
                                    <textarea name="content" id="community-content" style="display: none;" required>{{ old('content') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="main_image" style="font-size: 21px">Main Image</label>
                                    <input type="file" name="main_image" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="location_link" style="font-size: 21px">Google Maps Embed URL (Optional)</label>
                                    <input type="url" placeholder="https://www.google.com/maps/embed?pb=..." name="location_link" class="form-control" value="{{ old('location_link') }}">
                                    <small class="text-muted">Get embed URL from Google Maps: Share → Embed a map → Copy HTML → Extract src URL</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Add Community</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('script')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toolbarOptions = [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'font': [] }],
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            ['link', 'image', 'video'],
            ['clean']
        ];

        var quill = new Quill('#community-content-editor', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });

        // Set initial content if exists
        var initialContent = {!! json_encode(old('content', '')) !!};
        if (initialContent) {
            quill.root.innerHTML = initialContent;
        }

        // Update hidden textarea before form submit
        var form = document.querySelector('form');
        var textarea = document.getElementById('community-content');
        
        form.addEventListener('submit', function(e) {
            textarea.value = quill.root.innerHTML;
        });

        // Also update on content change
        quill.on('text-change', function() {
            textarea.value = quill.root.innerHTML;
        });
    });
</script>
@endpush
