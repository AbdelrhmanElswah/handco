@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Projects</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Projects</li>
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
                            <div class="card-title">Projects</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-basic" class="table table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Area</th>
                                        <th>Featured</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $project->title }}</td>
                                            <td>${{ number_format($project->price, 2) }}</td>
                                            <td>{{ $project->category->name }}</td>
                                            <td>
                                                <a href="{{ $project->location_link }}" target="_blank" title="View on Google Maps">
                                                    <i class="fas fa-map-marker-alt text-primary"></i> {{ $project->location_name }}
                                                </a>
                                            </td>

                                            <td>
                                                <span class="badge {{ $project->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </td>
                                            <!-- Floor Area -->
                                            <td>{{ $project->floor_area ? $project->floor_area . ' sq ft' : '-' }}</td>

                                            <!-- Featured Status -->
                                            <td>
                                              <span class="badge {{ $project->featured ? 'bg-success' : 'bg-danger' }}">
                                                           {{ $project->featured ? 'Yes' : 'No' }}
                                                             </span>
                                            </td>
                                            <!-- Actions -->
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-outline-secondary" title="Edit Project">
                                                        <i class="fas fa-edit text-success"></i>
                                                    </a>
                                                    <button class="btn btn-outline-secondary delete-project-btn" data-project_id="{{ $project->id }}" data-bs-toggle="modal" data-bs-target="#delete_project_modal" title="Delete Project">
                                                        <i class="fas fa-trash-alt text-danger"></i>
                                                    </button>
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
            </div>

        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_project_modal" tabindex="-1" aria-labelledby="delete_project_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_project_modal_label">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this project?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete_project_form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-project-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const projectId = this.getAttribute('data-project_id');
                const deleteForm = document.getElementById('delete_project_form');
                deleteForm.action = "{{ route('projects.destroy', '') }}" + '/' + projectId;
            });
        });

    </script>

@endsection
