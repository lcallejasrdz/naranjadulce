<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ trans('crud.delete.modal.title') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ trans('crud.delete.modal.question') }} <span id="show_id_delete"></span>?</div>
            <div class="modal-footer">
                <form method="post" action="{{ route($active.'.delete') }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="id_delete" name="nd_status_id">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ trans('crud.delete.modal.cancel') }}</button>
                    <input type="submit" class="btn btn-danger" value="{{ trans('crud.delete.modal.delete') }}">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function deleteModal(id){
        $('#id_delete').val(id);
        $('#show_id_delete').text(id);
    }
</script>