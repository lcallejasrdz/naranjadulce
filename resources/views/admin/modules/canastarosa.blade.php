<div class="form-group">
	<label for="origins_code">{{ ucfirst(trans('validation.attributes.origins_code')) }} *</label>
	<input type="text" class="form-control @error('origins_code') is-invalid @enderror" id="origins_code" name="origins_code" value="{{ old('origins_code') }}">
	@error('origins_code')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="quantity">{{ ucfirst(trans('validation.attributes.quantity')) }} *</label>
	<input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}">
	@error('quantity')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="package">{{ ucfirst(trans('validation.attributes.package')) }} *</label>
	<input type="text" class="form-control @error('package') is-invalid @enderror" id="package" name="package" value="{{ old('package') }}">
	@error('package')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="modifications">{{ ucfirst(trans('validation.attributes.modifications')) }} *</label>
	<textarea class="form-control form-control-user @error('modifications') is-invalid @enderror" id="modifications" name="modifications" placeholder="{{ ucfirst(trans('validation.attributes.modifications')) }}">{{ old('modifications') }}</textarea>
	@error('modifications')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="who_sends">{{ ucfirst(trans('validation.attributes.who_sends')) }} *</label>
	<input type="text" class="form-control @error('who_sends') is-invalid @enderror" id="who_sends" name="who_sends" value="{{ old('who_sends') }}">
	@error('who_sends')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="who_receives">{{ ucfirst(trans('validation.attributes.who_receives')) }} *</label>
	<input type="text" class="form-control @error('who_receives') is-invalid @enderror" id="who_receives" name="who_receives" value="{{ old('who_receives') }}">
	@error('who_receives')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="dedication">{{ ucfirst(trans('validation.attributes.dedication')) }} *</label>
	<textarea class="form-control form-control-user @error('dedication') is-invalid @enderror" id="dedication" name="dedication" placeholder="{{ ucfirst(trans('validation.attributes.dedication')) }}">{{ old('dedication') }}</textarea>
	@error('dedication')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="delivery_date">{{ ucfirst(trans('validation.attributes.delivery_date')) }} *</label>
	<input type="text" class="form-control @error('delivery_date') is-invalid @enderror" id="datepicker" name="delivery_date" value="{{ old('delivery_date') }}" readonly>
	@error('delivery_date')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="preferential_schedule">{{ ucfirst(trans('validation.attributes.preferential_schedule')) }} *</label>
	<input type="text" class="form-control @error('preferential_schedule') is-invalid @enderror" id="preferential_schedule" name="preferential_schedule" value="{{ old('preferential_schedule') }}">
	@error('preferential_schedule')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>
