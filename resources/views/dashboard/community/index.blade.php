@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Communities</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Communities</li>
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
                            <div class="card-title">Communities</div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-basic" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Content</th>
                                    <th>Media</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($communities as $community)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $community->title }}</td>
                                        <td>{{ $community->subtitle ?? 'N/A' }}</td>
                                        <td>{{ Str::limit(strip_tags($community->content), 50) }}</td>
                                        <td>
                                            @if($community->mainImage)
                                                <a href="{{ $community->mainImage->media_link }}" target="_blank">
                                                    <img src="{{ $community->mainImage->media_link }}" alt="Community Image" style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px;">
                                                </a>
                                            @else
                                                <span class="avatar avatar-sm avatar-rounded me-2">
                                                    <i class="fas fa-image fa-2x text-secondary"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $community->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('community.edit', $community->id) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="far fa-edit text-success"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-secondary btn-sm delete-community-btn" data-community_id="{{ $community->id }}" data-bs-toggle="modal" data-bs-target="#delete_community_modal">
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
    <div class="modal fade" id="delete_community_modal" tabindex="-1" aria-labelledby="delete_community_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_community_modal_label">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this community?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete_community_form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-community-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const communityId = this.getAttribute('data-community_id');
                const deleteForm = document.getElementById('delete_community_form');
                deleteForm.action = "{{ route('community.destroy', ':id') }}".replace(':id', communityId);
            });
        });
    </script>
@endsection
