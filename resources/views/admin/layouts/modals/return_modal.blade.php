<div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ trans('crud.building.modal.question') }}</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form method="POST" action="{{ route($active.'.return') }}" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PATCH">
				<input type="hidden" value="{{ $item->slug }}" id="slug" name="slug">
				<div class="modal-body">
					<div class="form-group">
						<textarea class="form-control form-control-user @error('return_reason') is-invalid @enderror" id="return_reason" name="return_reason" placeholder="{{ trans('crud.building.modal.message') }}">{{ old('return_reason') }}</textarea>
						@error('return_reason')
						    <div class="alert alert-danger">{{ $message }}</div>
						@enderror
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">{{ trans('auth.logout.cancel') }}</button>
					<input type="submit" class="btn btn-warning" value="{{ trans('crud.building.return') }}">
				</div>
			</form>
		</div>
	</div>
</div>