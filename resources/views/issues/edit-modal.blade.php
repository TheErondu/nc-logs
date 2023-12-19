@push('scripts')
    <script src="{{ asset('js/select2-custom.js') }}"></script>
@endpush
<div class="modal fade" id="issue_{{ $issue->id }}" tabindex="-1" role="dialog"
    aria-labelledby="issue_{{ $issue->id }}" aria-hidden="true">
    <div class="modal-wrapper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue center">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Report a Tech problem</h4>
                </div>
                @can('assign engineer')
                    <form method="POST" enctype="multipart/form-data" action="{{ route('issues.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="assigned_engineer">Assign Engineer to Ticket</label>
                                <select class="form-control select2" name="assigned_engineer" id="assigned_engineer_{{$issue->id}}"
                                    data-placeholder=" Choose Engineer...">
                                    <option value="" selected>select</option>
                                    @foreach ($engineers as $engineer)
                                        <option value="{{ $engineer->id }}"
                                            @if ($issue->assigned_engineer === $engineer->id) selected='selected' @endif>
                                            {{ $engineer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button form="assigned_engineer_form" style="background-color: green !important;"
                                    type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </form>
                @endcan
                <form method="POST" enctype="multipart/form-data" action="{{ route('issues.update', $issue->id) }}">
                    @csrf
                    @method('PUT
                                            ')
                    {{-- Engineers only --}}
                    @can('fix-issues')

                        <div class="form-group">
                            <input name="equipment_name" type="text"value="{{ $issue->equipment_name }}" hidden>
                            <input name="fault_description" type="text"value="{{ $issue->fault_description }}" hidden>
                            <input name="date" type="text"value="{{ $issue->date }}" hidden>
                            <input name="store_id" type="text"value="{{ $issue->store_id }}" hidden>
                            <input name="equipment_name" type="text" class="form-control" id="equipment_name" required
                                placeholder="Name of the faulty equipment or device">
                        </div>
                        <div class="form-group">
                            <label for="cause_of_breakdown">Cause of Break Down</label>
                            <textarea name="cause_of_breakdown" type="text" class="form-control" id="cause_of_breakdown" value="" required
                                placeholder="">{{ $issue->cause_of_breakdown }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="action_taken">Action Taken</label>
                            <textarea name="action_taken" type="text" class="form-control" id="action_taken" value="" required
                                placeholder="">{{ $issue->action_taken }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="cause_of_breakdown">Cause of Break Down</label>
                            <textarea name="engineers_comment" type="text" class="form-control" id="engineers_comment" value="" required
                                placeholder="">{{ $issue->engineers_comment }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control select2" name="status" id="status_{{$issue->id}}">
                                @foreach ($issueStatuses as $status)
                                    <option value="{{ $status->value }}"
                                        @if ($status->value === $issue->status) selected='selected' @endif>{{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        {{-- Normal Users --}}
                        <div class="form-group">
                            <label for="equipment_name">Equipment</label>
                            <input name="item_name" type="text" class="form-control" id="equipment_name"
                                value="{{ $issue->equipment_name }}" required placeholder="">
                        </div>
                        <div class="form-group">
                            <select class="form-control select2" name="store_id" id="store_id_{{$issue->id}}"
                                data-placeholder=" Select store">
                                <option value="" selected>select</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->name }}"
                                        @if ($issue->store->name === $store->name) selected='selected' @endif>{{ $store->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fault_description">Fault Description</label>
                            <textarea name="fault_description" type="text" class="form-control" id="fault_description" value="" required
                                placeholder="">{{ $issue->fault_description }}</textarea>
                        </div>
                        @endif
                        {{-- <div class="form-group">
                            <input type="file" name="attachment">
                        </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                        Discard</button>
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i>
                        Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
