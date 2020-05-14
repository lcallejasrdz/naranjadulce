<div class="form-group">
	<label for="username">{{ ucfirst(trans('validation.attributes.username')) }}</label>
	<input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="@isset($item) {{ $item->username }} @endisset">
	@error('username')
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
	<label for="email">{{ ucfirst(trans('validation.attributes.email')) }}</label>
	<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="@isset($item) {{ $item->email }} @endisset">
	@error('email')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<input type="hidden" value="slug" id="slug" name="slug">
<input type="hidden" value="1" id="role_id" name="role_id">
