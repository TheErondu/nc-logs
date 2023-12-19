@push('scripts')
    <script src="{{ asset('js/select2-custom.js') }}"></script>
@endpush
<div class="modal fade" id="newIssue" tabindex="-1" role="dialog" aria-labelledby="newIssue" aria-hidden="true">
    <div class="modal-wrapper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue center">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Report a Tech problem</h4>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('issues.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control select2" name="store_id" id="store_id"
                                data-placeholder=" Select Store location">
                                <option value="" selected>select</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input name="equipment_name" type="text" class="form-control" id="equipment_name"
                                required placeholder="Name of the faulty equipment or device">
                        </div>
                        <div class="form-group">
                            <textarea name="fault_description" class="form-control" placeholder="Please detail your issue or question" style="height: 120px;"></textarea>
                        </div>
                        {{-- <div class="form-group">
                            <input type="file" name="attachment">
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                            Discard</button>
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i>
                            Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

