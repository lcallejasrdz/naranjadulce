<div class="form-group">
	<label for="name">{{ ucfirst(trans('validation.attributes.name')) }} *</label>
	<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="@if(isset($item)){{ $item->name }}@else{{ old('name') }}@endif">
	@error('name')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<hr>

<div class="form-group">
	<label for="price">{{ ucfirst(trans('validation.attributes.nd_products_id')) }} *</label>
	<select class="form-control @error('nd_products_id') is-invalid @enderror" id="nd_products_id" name="nd_products_id">
        <option selected disabled>{{ ucfirst(trans('validation.attributes.nd_products_id')) }} *</option>
        @foreach($nd_products_id as $key => $value)
            <option value="{{ $key }}" {{ old('nd_products_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
    @error('nd_products_id')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
	<label for="quantity">{{ ucfirst(trans('validation.attributes.quantity')) }} *</label>
	<input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="@if(isset($item)){{ $item->quantity }}@else{{ old('quantity') }}@endif">
	@error('quantity')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<button type="button" class="btn btn-warning" onclick="addProduct()">{{ trans('module_products.controller.create_word') }}</button>
</div>

<hr>

<div class="form-group">
	<div class="table">
		<table class="table" id="productsTable">
			<thead>
				<tr>
					<th>Producto</th>
					<th>Precio</th>
					<th>Cantidad</th>
					<th>Eliminar</th>
				</tr>
			</thead>
		</table>

		<input type="hidden" id="products_table" name="products_table" value="">
	</div>
</div>

<div class="form-group">
	<label for="amount">{{ ucfirst(trans('validation.attributes.amount')) }}</label>
	<input type="text" class="form-control @error('visible_amount') is-invalid @enderror" id="visible_amount" name="visible_amount" value="@if(isset($item)){{ $item->visible_amount }}@else{{ 0 }}@endif" disabled>
	<input type="hidden" id="amount" name="amount" value="@if(isset($item)){{ $item->amount }}@else{{ 0 }}@endif">
	@error('amount')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>