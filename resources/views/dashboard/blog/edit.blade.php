@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Edit Blog</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Blog</li>
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
                    <form method="POST" action="{{ route('blog.update', $blog->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title"style="font-size: 21px">Title</label>
                                    <input type="text"  placeholder="Title" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id" style="font-size: 21px">Category</label>
                                    <select name="category_id" class="form-control">
                                        <option value="" {{ old('category_id', $blog->category_id) === '' || old('category_id', $blog->category_id) === null ? 'selected' : '' }}>None</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="content" style="font-size: 21px">Content</label>
                                    <div id="blog-content-editor" style="height: 400px;">{!! old('content', $blog->content) !!}</div>
                                    <textarea name="content" id="blog-content" style="display: none;" required>{{ old('content', $blog->content) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="main_image" style="font-size: 21px">Main Image</label>
                                    <input type="file" name="main_image" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update Blog</button>
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

        var quill = new Quill('#blog-content-editor', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });

        // Update hidden textarea before form submit
        var form = document.querySelector('form');
        var textarea = document.getElementById('blog-content');
        
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




