@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="card-header">
                        <div class="mb-3 col-md-12">
                            <h4>Showing log for the date: {{ $details['date'] }}</h4>
                    </div>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Problems Encountered</th>
                            <th scope="col">Resolutions</th>
                            <th scope="col">New Development</th>
                            <th scope="col">Comments/Recommendations</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{ $details['problems'] }}</td>
                            <td>{{ $details['resolutions'] }}</td>
                            <td>{{ $details['new_development'] }}</td>
                            <td> {{ $details['comments'] }}</td>
                          </tr>

                        </tbody>
                      </table>
                      <div class="row-justify-content-center">
                        <div class="mb-3 col-md-4">
                      @if ($details['user_id'] === Auth::user()->id)
                      <a class="btn btn-primary" href="{{route('logs.edit', $details['id'])}}" > Edit</a>
                      @endif
                      <a class="btn btn-primary" href="{{route('logs.index')}}"> Go Back </a>
                        </div>
                            {{-- <div class="row justify-content-around">
                                <h5 class="field-title">Date</h5>
                                <div class="mb-3 col-md-12">
                                        <Strong>{{ $details['date'] }}</Strong>
                                </div>

                            </div>
                                <div class="row justify-content-center">
                                    <h5 class="field-title">Problems Encountered</h5>
                                <div class="mb-3 col-md-12">
                                    <p>{{ $details['problems'] }}</p>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <h5 class="field-title">Resolutions</h5>
                                <div class="mb-3 col-md-12">
                                    <p>{{ $details['resolutions'] }}</p>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <h5 class="field-title">New Development</h5>
                                <div class="mb-3 col-md-12">

                                    <p>{{ $details['new_development'] }}</p>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <h5 class="field-title">Comments/Recommendations</h5>
                                <div class="mb-3 col-md-12">

                                    <p>{{ $details['comments'] }}</p>
                                </div>
                                @if ($details['user_id'] === Auth::user()->id)
                                <a class="btn btn-primary" href="{{route('logs.edit', $details['id'])}}" > Edit</a>
                                @endif
                            </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
   $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
});
    </script>
@endsection
