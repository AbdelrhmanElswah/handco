@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Off Plan Projects</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Off Plan Projects</li>
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
                            <div class="card-title">Off Plan Projects</div>
                            <div class="card-options">
                                <a href="{{ route('off-plan-projects.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add New Project
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-basic" class="table table-bordered text-nowrap" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project Name</th>
                                        <th>Developer</th>
                                        <th>Location</th>
                                        <th>Starting Price</th>
                                        <th>Completion Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>{{ $project->project_name }}</td>
                                            <td>{{ $project->developer }}</td>
                                            <td>
                                                @if($project->location_link)
                                                    <a href="{{ $project->location_link }}" target="_blank" title="View on Google Maps">
                                                        <i class="fas fa-map-marker-alt text-primary"></i> {{ $project->location }}
                                                    </a>
                                                @else
                                                    {{ $project->location }}
                                                @endif
                                            </td>
                                            <td>{{ $project->starting_price ? 'AED ' . number_format($project->starting_price, 2) : '-' }}</td>
                                            <td>{{ $project->completion_date ?? '-' }}</td>
                                            <td>
                                                <span class="badge {{ $project->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $project->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('off-plan-projects.edit', $project->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('off-plan-projects.destroy', $project->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $projects->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

