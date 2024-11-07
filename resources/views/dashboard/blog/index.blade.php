@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Blogs</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Blogs</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Blogs</div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-basic" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Content</th>
                                    <th>Media</th> <!-- Media column header -->
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blogs as $blog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->category->name ?? 'Uncategorized' }}</td>
                                        <td>{{ Str::limit($blog->content, 50) }}</td>
                                        <!-- Media column with image or placeholder icon -->
                                        <td>
                                            @if($blog->mainImage)
                                                <a href="{{ $blog->mainImage->media_link }}" target="_blank">
                                                    <img src="{{ $blog->mainImage->media_link }}" alt="Blog Image" style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px;">
                                                </a>
                                            @else
                                                <span class="avatar avatar-sm avatar-rounded me-2">
                                                    <i class="fas fa-image fa-2x text-secondary"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $blog->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('blog.edit', $blog->id) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="far fa-edit text-success"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-secondary btn-sm delete-blog-btn" data-blog_id="{{ $blog->id }}" data-bs-toggle="modal" data-bs-target="#delete_blog_modal">
                                                <i class="far fa-trash-alt text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_blog_modal" tabindex="-1" aria-labelledby="delete_blog_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_blog_modal_label">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this blog post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete_blog_form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-blog-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const blogId = this.getAttribute('data-blog_id');
                const deleteForm = document.getElementById('delete_blog_form');
                deleteForm.action = "{{ route('blog.destroy', ':id') }}".replace(':id', blogId);
            });
        });
    </script>
@endsection
