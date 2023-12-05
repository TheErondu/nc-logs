@extends('layouts.app')
@push('styles')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
<script src="{{ asset('js/datatables.min.js') }}" defer></script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header" style="margin-bottom: 1.0rem;">
                        <span>Employee </span>
                        <a href="{{ route('employees.create') }}"
                            type="submit" class="btn btn-primary create-button">Add an employee &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    @if (count($employees) > 0)

                    <div style="overflow-y: auto; height:400px; ">
                      <table id="datatables-buttons" class="table table-bordered datatable dtr-inline" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td><a href="{{ route('employees.edit', $employee->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->role }}</td>
                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $employee->created_at)->format('d-M-Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                        <div class="modal fade" id="smallModal" role="dialog" aria-labelledby="smallModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="smallBody">
                                        <div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="card">
                            <div class="card-body card-black">
                                <p>No Managers Have Been Added yet, Click <a href="{{ route('employees.create') }}"
                                        data-toggle="tooltip" title="" data-original-title="Add Vehicles">Here</a> to add
                                    employees
                                <p>
                                <p><a class="btn btn-primary" href="{{ route('employees.create') }}">Add Manager</a>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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
			});

            /* =========================================================================================== */
            /* ============================ BOOTSTRAP 3/4 EVENT ========================================== */
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
            });
        });
    </script>


@endsection
