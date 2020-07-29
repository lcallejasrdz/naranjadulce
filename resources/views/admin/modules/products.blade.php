<div class="form-group">
	<label for="code">{{ ucfirst(trans('validation.attributes.code')) }} *</label>
	<input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}">
	@error('code')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="category">{{ ucfirst(trans('validation.attributes.category')) }} *</label>
	<input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}">
	@error('category')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="type">{{ ucfirst(trans('validation.attributes.type')) }}</label>
	<input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type') }}">
	@error('type')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="product_name">{{ ucfirst(trans('validation.attributes.product_name')) }} *</label>
	<input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name') }}">
	@error('product_name')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="supplier">{{ ucfirst(trans('validation.attributes.supplier')) }}</label>
	<input type="text" class="form-control @error('supplier') is-invalid @enderror" id="supplier" name="supplier" value="{{ old('supplier') }}">
	@error('supplier')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="brand">{{ ucfirst(trans('validation.attributes.brand')) }}</label>
	<input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand') }}">
	@error('brand')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="price">{{ ucfirst(trans('validation.attributes.price')) }} *</label>
	<input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
	@error('price')
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