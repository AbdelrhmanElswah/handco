@extends('dashboard.partials.app')
@section('content')

    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Blogs</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Blogs</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header Close -->
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

            <!-- Start::row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                Blogs
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-basic" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 0 @endphp

                                @foreach($blogs as $blog)
                                    @php $i++ @endphp
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$blog->title}}</td>
                                        <td>{{$blog->description}}</td>
                                        <td><img src="{{ asset('storage/app/' . $blog->image) }}" alt="{{ $blog->title }}" width="100"></td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                                <a class="pr-1" style="color:white;" href="{{ route('blogs.edit', [$blog->id]) }}">
                                                    <span class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Edit Blog">
                                                        <i class="far fa-edit text-success"></i>
                                                    </span>
                                                </a>
                                                <a class="pr-1 delete-blog-btn" style="color: white; margin-left: 10px;" href="#" data-blog_id="{{$blog->id}}" data-bs-toggle="modal" data-bs-target="#delete_blog_modal">
                                                    <span class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Delete Blog">
                                                        <i class="far fa-trash-alt text-danger"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->

        </div>
    </div>
    <!-- End::app-content -->

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_blog_modal" tabindex="-1" aria-labelledby="delete_blog_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_blog_modal_label">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this blog?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete_blog_form" method="POST" action="{{ route('blogs.destroy', ['id' => 1]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="{{asset('dashboard/assets/js/datatables.js')}}"></script>

    <script>
        // Attach click event listener to delete blog buttons
        document.querySelectorAll('.delete-blog-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Get the blog ID from the data attribute
                const blogId = this.getAttribute('data-blog_id');

                // Update the form action with the correct blog ID
                const deleteForm = document.getElementById('delete_blog_form');
                deleteForm.action = "{{ url('admin/blogs') }}" + '/' + blogId;
            });
        });
    </script>
@endsection
