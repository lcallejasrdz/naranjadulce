<div class="form-group">
	<label for="email">{{ ucfirst(trans('validation.attributes.email')) }}</label>
	<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="@isset($item) {{ $item->email }} @endisset">
	@error('email')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="password">{{ ucfirst(trans('validation.attributes.password')) }}</label>
	<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
	@isset($item)
		<small id="emailHelp" class="form-text text-muted">{{ trans('crud.update.password_help') }}</small>
	@endisset
	@error('password')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="first_name">{{ ucfirst(trans('validation.attributes.first_name')) }}</label>
	<input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="@isset($item) {{ $item->first_name }} @endisset">
	@error('first_name')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="last_name">{{ ucfirst(trans('validation.attributes.last_name')) }}</label>
	<input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="@isset($item) {{ $item->last_name }} @endisset">
	@error('last_name')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
    <label for="role_id">{{ ucfirst(trans('validation.attributes.role_id')) }}</label>
    <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id">
      	<option selected disabled>{{ ucfirst(trans('validation.attributes.choose')) }}:</option>
      	<option value="1" @isset($item) {!! ($item->role_id == 1) ? 'selected' : '' !!} @endisset>{{ ucfirst(trans('validation.attributes.administrator')) }}</option>
      	<option value="2" @isset($item) {!! ($item->role_id == 2) ? 'selected' : '' !!} @endisset>{{ ucfirst(trans('validation.attributes.selling')) }}</option>
      	<option value="3" @isset($item) {!! ($item->role_id == 3) ? 'selected' : '' !!} @endisset>{{ ucfirst(trans('validation.attributes.finances')) }}</option>
      	<option value="4" @isset($item) {!! ($item->role_id == 4) ? 'selected' : '' !!} @endisset>{{ ucfirst(trans('validation.attributes.production')) }}</option>
      	<option value="5" @isset($item) {!! ($item->role_id == 5) ? 'selected' : '' !!} @endisset>{{ ucfirst(trans('validation.attributes.logistic')) }}</option>
    </select>
  </div>

<input type="hidden" value="slug" id="slug" name="slug">
