@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-opaque">
                    <div class="card-header" style="background-color: #272727;">
                        <h5 class="card-title" style="color: white;">Add  Manager</h5>

                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('employees.store') }}">
                            @csrf
                            <div class="row justify-content-between">
                                <div class="mb-3 col-md-4">
                                    <label for="name">Name</label>
                                    <input name="name" type="text" class="form-control" id="name" value="{{old ('name') }}"  required placeholder="">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="email">Email</label>
                                    <input name="email" type="email" class="form-control" id="email" value="{{old ('email') }}"  required placeholder="">
                                </div>

                            </div>
                            <div class="row justify-content-between">
                                <div class="mb-3 col-md-4">
                                    <label for="show_title">Status</label>
                                    <select class="form-control select2" name="status" id="status">
                                            @foreach($status as $status)
                                                <option value="{{ $status}}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="show_title">Role</label>
                                    <select class="form-control select2" name="roles" id="roles">
                                            @foreach($roles as $role)
                                                <option value="{{ $role}}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="password">Password</label>
                                    <input name="password" type="password" class="form-control" id="password" required placeholder="">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input name="password_confirmation" type="password" class="form-control" id="password" required placeholder="">
                                </div>

                            </div>


                            <div class="row justify-content-between">
                                <div class="mb-3 col-md-6">
                                    <a href="{{ route('employees.index') }}" style="background-color: rgb(53, 54, 55) !important;"
                                        class="btn btn-primary">Cancel</a>
                                </div>
                                <div class="mb-3 col-md-1">
                                    <button style="background-color: rgb(37, 38, 38) !important;" type="submit"
                                        class="btn btn-primary">Submit</button>
                                </div>
                            </div>
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
                format:'YYYY-MM-DD HH:mm:ss'
            });
            $('#datetimepicker-minimum2').datetimepicker({
                format:'YYYY-MM-DD HH:mm:ss'
            });
            $('#datetimepicker-view-mode').datetimepicker({
                viewMode: 'years'
            });
            $('#datetimepicker-time').datetimepicker({
                format: 'LT'
            });
            $('#datetimepicker-date').datetimepicker({
                format: 'LT'
            });
        });
    </script>
@endsection
