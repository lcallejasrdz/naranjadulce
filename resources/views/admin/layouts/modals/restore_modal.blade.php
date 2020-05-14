<div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalLabel">{{ trans('crud.restore.modal.title') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ trans('crud.restore.modal.question') }} <span id="show_id_restore"></span>?</div>
            <div class="modal-footer">
                <form method="post" action="{{ route('users.restore') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="id_restore" name="id">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ trans('crud.restore.modal.cancel') }}</button>
                    <input type="submit" class="btn btn-warning" value="{{ trans('crud.restore.modal.restore') }}">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function restoreModal(id){
        $('#id_restore').val(id);
        $('#show_id_restore').text(id);
    }
</script>