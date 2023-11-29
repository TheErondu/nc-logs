@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div>
                        <form method="POST" enctype="multipart/form-data" action="{{ route('logs.update', $log->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row justify-content-center">
                                <div class="mb-3 col-md-4">
                                    <label for="log_date">Date </label>
                                        <input required value="{{ $log->date}}" name="date" type="text" class="form-control datepicker">
                                </div>

                            </div>
                                <div class="row justify-content-around">
                                <div class="mb-3 col-md-12">
                                    <label for="problems">Problems Encountered ( Numbered: Problem .1 should match Resolution .1)</label>
                                    <textarea placeholder="What techincal issues occured today?" name="problems" type="text" class="form-control" required id="problems">{{ $log->problems}}</textarea>
                                </div>
                            </div>
                            <div class="row justify-content-around">
                                <div class="mb-3 col-md-12">
                                    <label for="resolutions">Resolutions</label>
                                    <textarea placeholder="How were the Problems Solved?" name="resolutions" type="text" required class="form-control" id="resolutions">{{ $log->resolutions}}</textarea>
                                </div>
                            </div>
                            <div class="row justify-content-around">
                                <div class="mb-3 col-md-12">
                                    <label for="new_development">New Development</label>
                                    <textarea placeholder="What new Development happened Today? " name="new_development" required type="text" class="form-control" id="new_development">{{ $log->new_development}}</textarea>
                                </div>
                            </div>
                            <div class="row justify-content-around">
                                <div class="mb-3 col-md-12">
                                    <label for="comments">Comments/Recommendations</label>
                                    <textarea placeholder="Remarks About the shift in general.." name="comments" type="text" required class="form-control" id="comments">{{ $log->comments}}</textarea>
                                </div>
                                <button class="btn btn-primary" type="submit" style="width: 55%;" onclick="return confirm('Confirm you want to Submit ?')">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
   $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
});
    </script>
@endsection
