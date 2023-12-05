@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header" style="margin-bottom: 1.0rem;">
                        <span>My Profile </span>
                    </div>
                    <div class="row">
                        @if (Session::has('message'))
                            <div class="container">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <div class="alert-icon">
                                        <i class="far fa-fw fa-bell"></i>
                                    </div>
                                    <div class="alert-message">
                                        <strong> {{ session('message') }}</strong>
                                    </div>

                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="container">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <div class="alert-icon">
                                            <i class="far fa-fw fa-bell"></i>
                                        </div>
                                        <div class="alert-message">
                                            <strong> {{ $error }}</strong>
                                        </div>

                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card">
								<div class="card-header">
									<div class="card-actions float-end">
										<a href="" class="me-1">
											<i class="align-middle" data-feather="refresh-cw"></i>
										</a>
									</div>
									<h5 class="card-title mb-0">{{$employee->name}}</h5>
								</div>
								<div class="card-body">
									<div class="row g-0">
										<div class="col-sm-3 col-xl-12 col-xxl-4 text-center">
											<img src="{{asset('img/avatars/user.png')}}" width="64" height="64" class="rounded-circle mt-2" alt="Angelica Ramos">
										</div>
										<div class="col-sm-9 col-xl-12 col-xxl-8">
											<strong>About me</strong>
											<p>Company Staff</p>
										</div>
									</div>

									<table class="table table-sm my-2">
										<tbody>
											<tr>
												<th>Name</th>
												<td>{{$employee->name}}</td>
											</tr>
											<tr>
												<th>Department</th>
												<td>{{$employee->department->name}}</td>
											</tr>
											<tr>
												<th>Email</th>
												<td>{{$employee->email}}</td>
											</tr>
											<tr>
												<th>Phone</th>
												<td>{{$employee->number}}</td>
											</tr>
											<tr>
                                                <th>Role</th>
												<td>{{$employee->role}}</td>
											</tr>
											<tr>
												<th>Status</th>
                                                @if ($employee->status === 'Active')
                                                <td><span class="badge bg-success">{{$employee->status}}</span></td>
                                                @else
                                                <td><span class="badge bg-danger">{{$employee->status}}</span></td>
                                                @endif

											</tr>
										</tbody>
									</table>
								</div>



    </div>
@endsection
@section('javascript')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
			// Datatables with Buttons
			var datatablesButtons = $("#datatables-buttons").DataTable({
				responsive: true,
                fixedHeader:true,
                paginate:false,
				buttons: ["copy", "print"]
			});
            datatablesButtons.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)");
            /* =========================================================================================== */
            /* ============================ BOOTSTRAP 3/4 EVENT ========================================== */
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
            });
        });
    </script>


@endsection
