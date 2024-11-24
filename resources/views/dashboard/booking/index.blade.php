@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Leads</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Leads</li>
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
                            <div class="card-title">Leads</div>
                            <a href="{{ route('bookings.export') }}" class="btn btn-success ms-auto">Download to CSV</a>

                        </div>
                        <div class="card-body">
                            <table id="datatable-merged" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Inquiry/Subject</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Message</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>Booking</td>
                                        <td>
                                            @if($booking->project)
                                                <a href="{{ url('projects/' . $booking->project->id) }}" target="_blank">
                                                    {{ $booking->project->title }}
                                                </a>
                                            @else
                                                N/A
                                        @endif
                                        <td>{{ $booking->name }}</td>
                                        <td>{{ $booking->email }}</td>
                                        <td>{{ $booking->phone_number }}</td>
                                        <td>{{ $booking->message }}</td>
                                    </tr>
                                @endforeach
                                @foreach($contacts as $contact)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>Contact</td>
                                        <td>{{ $contact->subject }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>N/A</td>
                                        <td>{{ $contact->message }}</td>
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

@endsection
