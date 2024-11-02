@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Utilities</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Utilities</li>
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
                            <div class="card-title">Utilities</div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-basic" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Bedrooms</th>
                                    <th>Bathrooms</th>
                                    <th>Parking Spaces</th>
                                    <th>Swimming Pool</th>
                                    <th>Gym</th>
                                    <th>Garden</th>
                                    <th>Air Conditioning</th>
                                    <th>Furnished</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($utilities as $utility)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $utility->bedrooms }}</td>
                                        <td>{{ $utility->bathrooms }}</td>
                                        <td>{{ $utility->parking_spaces }}</td>
                                        <td><span class="{{ $utility->swimming_pool ? 'text-success' : 'text-danger' }}">{{ $utility->swimming_pool ? 'Yes' : 'No' }}</span></td>
                                        <td><span class="{{ $utility->gym ? 'text-success' : 'text-danger' }}">{{ $utility->gym ? 'Yes' : 'No' }}</span></td>
                                        <td><span class="{{ $utility->garden ? 'text-success' : 'text-danger' }}">{{ $utility->garden ? 'Yes' : 'No' }}</span></td>
                                        <td><span class="{{ $utility->air_conditioning ? 'text-success' : 'text-danger' }}">{{ $utility->air_conditioning ? 'Yes' : 'No' }}</span></td>
                                        <td><span class="{{ $utility->furnished ? 'text-success' : 'text-danger' }}">{{ $utility->furnished ? 'Yes' : 'No' }}</span></td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('utilities.edit', $utility->id) }}" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Edit Utility">
                                                    <i class="far fa-edit text-success"></i>
                                                </a>
                                                <a href="#" class="btn btn-outline-secondary delete-utility-btn" data-utility_id="{{ $utility->id }}" data-bs-toggle="modal" data-bs-target="#delete_utility_modal" data-toggle="tooltip" data-placement="top" title="Delete Utility">
                                                    <i class="far fa-trash-alt text-danger"></i>
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

        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_utility_modal" tabindex="-1" aria-labelledby="delete_utility_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_utility_modal_label">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this utility?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete_utility_form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-utility-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const utilityId = this.getAttribute('data-utility_id');
                const deleteForm = document.getElementById('delete_utility_form');
                deleteForm.action = "{{ route('utilities.destroy', ':id') }}".replace(':id', utilityId);
            });
        });
    </script>
@endsection
