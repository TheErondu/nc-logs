@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-opaque">
                    <div class="card-header" style="background-color: #272727;">
                        <h5 class="card-title" style="color: white;">Report Tech Problem</h5>

                    </div>
                    <div class="card-body">
                        <form action="{{ route('issues.assign', $issue->id) }}" id="assigned_engineer_form" method="POST">
                            @method('PUT')
                            @csrf
                            @can('assign engineer')
                            <div class="row justify-content-center">
                                <div class="mb-3 col-md-6">
                                        <div>
                                    <label for="assigned_engineer">Assign Engineer to Ticket</label>
                                    <select class="form-control select2" name="assigned_engineer" id="assigned_engineer" data-placeholder=" Choose Engineer...">
                                        <option value="" selected>select</option>
                                        @foreach($engineers as $engineer)
                                            <option value="{{ $engineer->id }}" @if($issue->assigned_engineer === $engineer->id) selected='selected' @endif>{{$engineer->name}}</option>
                                        @endforeach
                                    </select>
                                        </div>
                                    <br>
                                    <div class="mb-3 col-md-6">
                                        <button form="assigned_engineer_form" style="background-color: green !important;" type="submit"
                                        class="btn btn-primary">Submit</button>
                                </div>
                        </div>
                    </div>
                    @endcan
                        </form>
                        <form method="POST" enctype="multipart/form-data" action="{{ route('issues.update',$issue->id) }}">
                            @csrf
                            @method('PUT
                            ')
                            {{-- Engineers only --}}
                            @can('fix-issues')
                            <div class="row justify-content-between">
                                <input name="equipment_name" type="text"value="{{$issue->equipment_name}}" hidden>
                                <input name="fault_description" type="text"value="{{$issue->fault_description}}" hidden>
                                <input name="date" type="text"value="{{$issue->date}}" hidden>
                                <input name="raised_by" type="text"value="{{$issue->raised_by}}" hidden>
                                <input name="store_id" type="text"value="{{$issue->store_id}}" hidden>
                                <div class="mb-3 col-md-4">
                                    <label for="item_name">Equipment / Issue</label>
                                    <h4>{{$issue->equipment_name}}</h4>
                                    <p> (Store: {{$issue->store->location}})</p>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="description">Fault Description</label>
                                    <p>{{$issue->fault_description}}</p>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="fixed_by">Who Fixed it?</label>
                                   <h2>{{$issue->fixed_by}}</h2>
                                </div>

                            </div>
                            <div class="row justify-content-between">
                                <div class="mb-3 col-md-6">
                                    <label for="cause_of_breakdown">Cause of Break Down</label>
                                    <textarea name="cause_of_breakdown" type="text" class="form-control" id="cause_of_breakdown"
                                    value="" required placeholder="">{{$issue->cause_of_breakdown}}</textarea>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="action_taken">Action Taken</label>
                                    <textarea name="action_taken" type="text" class="form-control" id="action_taken"
                                    value="" required placeholder="">{{$issue->action_taken}}</textarea>
                                </div>
                            </div>
                            <div class="row justify-content-left">
                                <div class="mb-3 col-md-12">
                                    <label for="engineers_comment">Engineers Comment</label>
                                    <textarea name="engineers_comment" type="text" class="form-control" id="engineers_comment"
                                    value="" required placeholder="">{{$issue->engineers_comment}}</textarea>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="mb-3 col-md-4">
                                    <label for="status">Status</label>
                                    <select class="form-control select2" name="status" id="status">
                                        @foreach($issue_status as $status)
                                        <option value="{{ $status}}" @if($status === $issue->status) selected='selected' @endif>{{ $status }}</option>
                                    @endforeach
                                        </select>
                                </div>

                            </div>

                            @else

                            {{-- Normal Users --}}
                            <div class="row justify-content-between">
                                <div class="mb-3 col-md-4">
                                    <label for="equipment_name">Equipment</label>
                                    <input name="item_name" type="text" class="form-control" id="equipment_name"
                                    value="{{$issue->equipment_name}}" required placeholder="">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="department">Store</label>
                                    <select class="form-control select2" name="department_id" id="department_id" data-placeholder=" Select Department">
                                        <option value="" selected>select</option>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->name}}" @if($issue->store->name === $store->name) selected='selected' @endif>{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-left">
                                <div class="mb-3 col-md-12">
                                    <label for="fault_description">Fault Description</label>
                                    <textarea name="fault_description" type="text" class="form-control" id="fault_description"
                                    value="" required placeholder="">{{$issue->fault_description}}</textarea>
                                </div>
                            </div>
                            @endcan

                            <div class="row justify-content-around">

                                <div class="mb-3 col-md-4">
                                    <a href="{{ route('issues.index') }}"
                                        style="background-color: rgb(53, 54, 55) !important;"
                                        class="btn btn-primary">Cancel</a>
                                </div>
                                @can('delete-data')
                                <div class="mb-3 col-md-4">

                                    <button form="delete-form" type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </div>
                                @endcan
                                <div class="mb-3 col-md-4">
                                    <button style="background-color: rgb(37, 38, 38) !important;" type="submit"
                                        class="btn btn-primary">Submit</button>
                                </div>

                            </div>
                    </form>
                    <form action="{{ route('issues.destroy', $issue->id) }}" id="delete-form" method="POST">
                        @method('DELETE')
                        @csrf

                    </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('javascript')

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Select2
            $(".select2").each(function() {
                $(this)
                    .wrap("<div class=\"position-relative\"></div>")
                    .select2({
                        placeholder: "Select value",
                        dropdownParent: $(this).parent()
                    });
            })
            // Datetimepicker
            $('#datetimepicker-minimum').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });
            $('#datetimepicker-minimum2').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });
            $('#datetimepicker-view-mode').datetimepicker({
                viewMode: 'years'
            });
            $('#datetimepicker-time').datetimepicker({
                format: 'LT'
            });
            $('#datetimepicker-date').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });
    </script>

@endsection
