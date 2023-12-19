@extends('layouts.app')
@push('styles')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{ asset('js/datatables.min.js') }}" defer></script>
@endpush
@section('content')
    <div class="container">
        <section class="content">
            <div class="row">

                <div class="col-md-3">
                    <div class="grid support">
                        <div class="grid-body">
                            <h2>Browse</h2>
                            <hr>
                            <ul>
                                <li class="active"><a href="#">All Issues<span class="pull-right">142</span></a>
                                </li>
                                <li><a href="#">Created by you<span class="pull-right">52</span></a></li>
                                <li><a href="#">Mentioning you<span class="pull-right">18</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-md-9">
                    <div class="grid support-content">
                        <div class="grid-body">
                            <h2>Issues</h2>
                            <hr>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default issue-waiting">{{ $waitingCount }}
                                    Waiting</button> &nbsp;
                                <button type="button" class="btn btn-default issue-open">{{ $openCount }}
                                    Open</button>&nbsp;
                                <button type="button" class="btn btn-default issue-closed">{{ $closedCount }}
                                    Closed</button>&nbsp;
                                <button type="button" class="btn btn-default issue-contested">{{ $contestedCount }}
                                    Contested</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> Sort:
                                    <strong>Newest</strong> <span class="caret"></span></button>
                                <ul class="dropdown-menu fa-padding" role="menu">
                                    <li><a href="#"><i class="fa fa-check"></i> Newest</a></li>
                                    <li><a href="#"><i class="fa"> </i> Oldest</a></li>
                                </ul>
                            </div>

                            <button type="button" data-toggle="modal" data-target="#newIssue"
                                class="btn btn-success pull-right"style="background-color: #001ddb;">New
                                Issue</button>
                            @include('issues.create-modal', ['stores' => $stores])

                            <div class="padding"></div>
                            <div class="row">

                                <div class="col-md-12">
                                    <ul class="list-group fa-padding">
                                        @foreach ($issues as $issue)
                                        <li class="list-group-item" data-toggle="modal" data-target="#issue_{{ $issue->id }}">
                                                <div class="media">
                                                    <i class="fa fa-cog pull-left"></i>
                                                    <div class="media-body">
                                                        <strong> Equipment: {{ $issue->equipment_name }}</strong> <span
                                                            class="label {{ \App\Models\Issue::mapStatusToLabelClass($issue->status) }}">{{ \App\Enums\IssueStatus::from($issue->status)->name }}</span><span
                                                            class="number pull-right">#{{ $issue->id }}</span>
                                                        <br>
                                                        Fault description:
                                                        {{ Illuminate\Support\Str::limit($issue->fault_description, $limit = 100, $end = '...') }}

                                                        <p class="info">Opened by <a
                                                                href="#">{{ $issue->store->name }} at
                                                                {{ $issue->store->location }}</a>
                                                            {{ \Carbon\Carbon::parse($issue->created_at)->diffForHumans() }}
                                                            <br>
                                                            <i class="fa fa-user"></i>
                                                            <a href="#">Assigned Engineer:
                                                                {{ $issue->assigned_enginner->name ?? 'N/A' }}
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            @include('issues.edit-modal',['issue' => $issue, 'engineers' => $engineers])
                                        @endforeach
                                    </ul>
                                    <hr>
                                    {{ $issues->links('vendor.pagination.bootstrap-4') }}



                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
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
@endsection
