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
                        <span>Roles </span> &nbsp; &nbsp;
                        <a href="{{ route('roles.create') }}" style="background-color: rgb(0, 0, 0) !important;"
                            type="submit" class="btn btn-primary">Add New &nbsp;<i class="fas fa-plus"></i></a>
                    </div>

                    @if (count($roles) > 0)
                    <div style="overflow-y: auto; height:400px; ">
                            <table id="datatables-buttons" class="table table-bordered datatable dtr-inline" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $role)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                {{-- <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a> --}}
                                                @can('manage roles')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-6">
                                {!! $roles->render('roles.paginate') !!}
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body card-black">
                                <p>No Roles Have Been Added yet, Click <a href="{{ route('roles.create') }}"
                                        data-toggle="tooltip" title="" data-original-title="Add Roles">Here</a> to add
                                    Roles
                                <p>
                                <p><a class="btn btn-primary" href="{{ route('roles.create') }}">Add Roles</a>
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
        // display a modal (small modal)
        $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function() {
                    $('#modal-body').trigger('click');
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').remove();
                },
                timeout: 8000
            })
        });
    </script>
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
