<div class="form-group">
	<label for="name">{{ ucfirst(trans('validation.attributes.name')) }} *</label>
	<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="@if(isset($item)){{ $item->name }}@else{{ old('name') }}@endif">
	@error('name')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="price">{{ ucfirst(trans('validation.attributes.price')) }} *</label>
	<input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="@if(isset($item)){{ $item->price }}@else{{ old('price') }}@endif">
	@error('price')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>