@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-opaque">
                    <div class="card-header" style="background-color: #272727;">
                        <h5 class="card-title" style="color: white;">Edit Store</h5>

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
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('departments.update', $department->id) }}">
                            @method('PUT')
                            @csrf

                            <div class="row justify-content-between">
                                <div class="mb-3 col-md-4">
                                    <label for="name">Name</label>
                                    <input name="name" value="{{ $department->name }}" type="text" class="form-control" id="name" required placeholder="">
                                </div>
                            <div class="mb-3 col-md-4">
                                <label for="director">Store manager</label>
                                <select class="form-control select2" name="store_manger" id="store_manger" data-placeholder=" select Head of Department">
                                    <option value="" selected>select</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if($store->store_manger->id === $user->id) selected='selected' @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="mb-3 col-md-4">
                                    <label for="name">Color</label>
                                    <input type="color" id="color" name="color" value="{{$store->color}}"><br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="mail_group">Group Email</label>
                                    <input value="{{ $store->mail_group }}" name="mail_group" type="text" class="form-control" id="mail_group"  placeholder="">
                                </div>
                            </div>


                            <div class="row justify-content-around">

                                <div class="mb-3 col-md-4">
                                    <a href="{{ url()->previous() }}" style="background-color: rgb(39, 41, 40) !important;"
                                        class="btn btn-primary">Back</a>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <button form="delete-form" style="background-color: red !important;" type="submit"
                                    class="btn btn-primary">Delete</button>
                            </div>
                            <div class="mb-3 col-md-4">
                                <button style="background-color: rgb(11, 208, 126) !important;" type="submit"
                                    class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('departments.destroy', $department->id) }}" id="delete-form" method="POST">
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
