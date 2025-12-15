@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Property</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Property</li>
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
                            <div class="card-title">Property</div>
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
                                        <th>Garage</th>
                                        <th>Featured</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
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

                                            <!-- Garage Status -->
                                            <td>
                                                @if($project->utility)
                                                    <span class="badge {{ $project->utility->garage_facility ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $project->utility->garage_facility ? 'Yes' : 'No' }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">N/A</span>
                                                @endif
                                            </td>

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
                            
                            <!-- Pagination -->
                            @if($projects->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="text-muted">
                                        Showing {{ $projects->firstItem() ?? 0 }} to {{ $projects->lastItem() ?? 0 }} of {{ $projects->total() }} properties
                                    </div>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($projects->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link" aria-label="Previous">
                                                        <i class="fe fe-chevron-left"></i> Previous
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $projects->previousPageUrl() }}" rel="prev" aria-label="Previous">
                                                        <i class="fe fe-chevron-left"></i> Previous
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Pagination Links --}}
                                            @php
                                                $currentPage = $projects->currentPage();
                                                $lastPage = $projects->lastPage();
                                                $start = max(1, $currentPage - 2);
                                                $end = min($lastPage, $currentPage + 2);
                                            @endphp

                                            {{-- First Page --}}
                                            @if ($start > 1)
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $projects->url(1) }}">1</a>
                                                </li>
                                                @if ($start > 2)
                                                    <li class="page-item disabled">
                                                        <span class="page-link">...</span>
                                                    </li>
                                                @endif
                                            @endif

                                            {{-- Page Numbers --}}
                                            @for ($page = $start; $page <= $end; $page++)
                                                @if ($page == $currentPage)
                                                    <li class="page-item active">
                                                        <span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $projects->url($page) }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endfor

                                            {{-- Last Page --}}
                                            @if ($end < $lastPage)
                                                @if ($end < $lastPage - 1)
                                                    <li class="page-item disabled">
                                                        <span class="page-link">...</span>
                                                    </li>
                                                @endif
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $projects->url($lastPage) }}">{{ $lastPage }}</a>
                                                </li>
                                            @endif

                                            {{-- Next Page Link --}}
                                            @if ($projects->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $projects->nextPageUrl() }}" rel="next" aria-label="Next">
                                                        Next <i class="fe fe-chevron-right"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link" aria-label="Next">
                                                        Next <i class="fe fe-chevron-right"></i>
                                                    </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            @endif
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
