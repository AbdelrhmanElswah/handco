@extends('dashboard.partials.app')
@section('content')

    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Contacts</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Contacts</li>
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
                                Contacts
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-basic" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Message</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 0 @endphp

                                @foreach($contacts as $contact)
                                    @php $i++ @endphp
                                    <tr>
                                        <td>{{$i}}</td>

                                        <td>{{$contact->name}}</td>
                                        <td>{{$contact->email}}</td>
                                        <td>{{$contact->phone_number}}</td>
                                        <td>{{$contact->message}}</td>

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

    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="input-group">
                        <a href="javascript:void(0);" class="input-group-text" id="Search-Grid"><i
                                class="fe fe-search header-link-icon fs-18"></i></a>
                        <input type="search" class="form-control border-0 px-2" placeholder="Search"
                               aria-label="Username">
                        <a href="javascript:void(0);" class="input-group-text" id="voice-search"><i
                                class="fe fe-mic header-link-icon"></i></a>
                        <a href="javascript:void(0);" class="btn btn-light btn-icon" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fe fe-more-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <p class="font-weight-semibold text-muted mb-2">Are You Looking For...</p>
                        <span class="search-tags"><i class="fe fe-user me-2"></i>People<a href="javascript:void(0)"
                                                                                          class="tag-addon"><i
                                    class="fe fe-x"></i></a></span>
                        <span class="search-tags"><i class="fe fe-file-text me-2"></i>Pages<a href="javascript:void(0)"
                                                                                              class="tag-addon"><i
                                    class="fe fe-x"></i></a></span>
                        <span class="search-tags"><i class="fe fe-align-left me-2"></i>Articles<a
                                href="javascript:void(0)" class="tag-addon"><i class="fe fe-x"></i></a></span>
                        <span class="search-tags"><i class="fe fe-server me-2"></i>Tags<a href="javascript:void(0)"
                                                                                          class="tag-addon"><i
                                    class="fe fe-x"></i></a></span>
                    </div>
                    <div class="my-4">
                        <p class="font-weight-semibold text-muted mb-2">Recent Search :</p>
                        <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                            <a href="notifications.html"><span>Notifications</span></a>
                            <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert"
                               aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                        </div>
                        <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                            <a href="alerts.html"><span>Alerts</span></a>
                            <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert"
                               aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                        </div>
                        <div class="p-2 border br-5 d-flex align-items-center text-muted mb-0 alert">
                            <a href="mail.html"><span>Mail</span></a>
                            <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert"
                               aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group ms-auto">
                        <button class="btn btn-sm btn-primary-light">Search</button>
                        <button class="btn btn-sm btn-primary">Clear Recents</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
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
        $('#delete_contact').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var contact_id = button.data('contact_id')
            var modal = $(this)
            modal.find('#contact_id').val(contact_id);
        })
    </script>
@endsection
