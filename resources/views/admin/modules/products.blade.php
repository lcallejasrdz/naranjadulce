<div class="form-group">
	<label for="code">{{ ucfirst(trans('validation.attributes.code')) }} *</label>
	<input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="@if(isset($item)){{ $item->code }}@else{{ old('code') }}@endif">
	@error('code')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="category">{{ ucfirst(trans('validation.attributes.category')) }} *</label>
	<input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="@if(isset($item)){{ $item->category }}@else{{ old('category') }}@endif">
	@error('category')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="type">{{ ucfirst(trans('validation.attributes.type')) }}</label>
	<input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="@if(isset($item)){{ $item->type }}@else{{ old('code') }}@endif">
	@error('type')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="product_name">{{ ucfirst(trans('validation.attributes.product_name')) }} *</label>
	<input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="@if(isset($item)){{ $item->product_name }}@else{{ old('product_name') }}@endif">
	@error('product_name')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="supplier">{{ ucfirst(trans('validation.attributes.supplier')) }}</label>
	<input type="text" class="form-control @error('supplier') is-invalid @enderror" id="supplier" name="supplier" value="@if(isset($item)){{ $item->supplier }}@else{{ old('supplier') }}@endif">
	@error('supplier')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="brand">{{ ucfirst(trans('validation.attributes.brand')) }}</label>
	<input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="@if(isset($item)){{ $item->brand }}@else{{ old('brand') }}@endif">
	@error('brand')
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

<div class="form-group">
	<label for="quantity">{{ ucfirst(trans('validation.attributes.quantity')) }} *</label>
	<input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="@if(isset($item)){{ $item->quantity }}@else{{ old('quantity') }}@endif" @if(isset($item)){{ 'readonly' }}@endif>
	@error('quantity')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

@if(isset($item))
	<div class="form-group">
		<label for="income">{{ ucfirst(trans('validation.attributes.income')) }}</label>
		<input type="text" class="form-control @error('income') is-invalid @enderror" id="income" name="income" value="{{ old('income') }}">
		@error('income')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="outcome">{{ ucfirst(trans('validation.attributes.outcome')) }}</label>
		<input type="text" class="form-control @error('outcome') is-invalid @enderror" id="outcome" name="outcome" value="{{ old('outcome') }}">
		@error('outcome')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>
@endif