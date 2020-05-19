<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ trans('auth.logout.question') }}</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">{{ trans('auth.logout.message') }}</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">{{ trans('auth.logout.cancel') }}</button>
				<a class="btn btn-primary" href="{{ URL::route('logout') }}">{{ trans('auth.logout.title') }}</a>
			</div>
		</div>
	</div>
</div>