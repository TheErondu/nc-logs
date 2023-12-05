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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('issues.store') }}">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="mb-3 col-md-4">
                                    <label for="department">Store</label>
                                    <select class="form-control select2" name="store_id" id="store_id" data-placeholder=" Select Store location">
                                        <option value="" selected>select</option>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="equipment_name">Equipment</label>
                                    <input name="equipment_name" type="text" class="form-control" id="equipment_name"
                                    value="" required placeholder="">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="mb-3 col-md-8">
                                    <label for="fault_description">Fault Description</label>
                                    <textarea name="fault_description" type="text" class="form-control" id="fault_description"
                                    value="" required placeholder="">{{ old('fault_description') }}</textarea>
                                </div>
                            </div>


                            <div class="row justify-content-around">
                                    <div class="mb-3 col-md-6">
                                        <a href="{{ route('issues.index') }}"
                                            style="background-color: rgb(53, 54, 55) !important;"
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
        });
    </script>

@endsection
