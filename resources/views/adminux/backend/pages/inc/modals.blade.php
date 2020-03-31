<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalCenterTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('adminux.cancel') }}</button>
                <form method="post" id="deleteForm" action="" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="name" id="deleteName" value="">
                    <button type="submit" class="btn btn-danger my-n1"><span class="feather-adminux" data-feather="trash-2"></span> {{ __('adminux.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
