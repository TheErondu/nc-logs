@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header" style="margin-bottom: 1.0rem;">
                        <span>Issues </span>
                        {{-- <a href="{{ route('employees.create') }}" style="background-color: rgb(0, 0, 0) !important;"
                            type="submit" class="btn btn-primary create-button">Add New Employee <i
                                class="fas fa-plus"></i></a> --}}
                    </div>
                    @if (count($issues) > 0)

                            <div style="overflow-y: auto; height:400px; ">
                        <table id="datatables-buttons" class="table table-bordered datatable dtr-inline" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th width=30%>Description</th>
                                    <th>Date</th>
                                    <th>Raised By</th>
                                    <th>Store</th>
                                    <th>Status</th>
                                    <th>Fixed by</th>
                                    <th>Action Taken</th>
                                    <th>Cause of Breakdown</th>
                                    <th>Engineers Comment</th>
                                    <th>Resolved Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($issues as $issue)
                                    <tr>
                                        <td><a href="{{ route('issues.edit', $issue->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                        <td>{{ $issue->equipment_name }}</td>
                                        <td>{{ $issue->fault_description }}</td>
                                        <td>{{ $issue->date }}</td>
                                        <td>{{ $issue->user->name }}</td>
                                        <td>{{ $issue->store->name }}</td>
                                        <td>{{ $issue->status }}</td>
                                        <td>{{ $issue->fixed_by }}</td>
                                        <td>{{ $issue->action_taken }}</td>
                                        <td>{{ $issue->cause_of_breakdown }}</td>
                                        <td>{{ $issue->engineers_comment }}</td>
                                        <td>{{ $issue->resolved_date }}</td>
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
                            <p>You Have not Raised any issues yet!, Click <a href="{{ route('issues.create') }}"
                                    data-toggle="tooltip" title="" data-original-title="Add Issues">Here</a> to Raise
                                an Issue
                            <p>
                            <p><a class="btn btn-primary" href="{{ route('issues.create') }}">Report Tech Problem</a>
                            </p>
                        </div>
                    </div>

                    @endif

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
                paginate:true,
                "order": [[ 0, "desc" ]],
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
