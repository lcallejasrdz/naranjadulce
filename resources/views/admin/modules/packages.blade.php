<div class="form-group">
	<label for="name">{{ ucfirst(trans('validation.attributes.name')) }} *</label>
	<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="@if(isset($item)){{ $item->name }}@else{{ old('name') }}@endif">
	@error('name')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

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
	<a class="btn btn-warning" href="#" data-toggle="modal" data-target="#returnModal">{{ trans('module_products.controller.create_word') }}</a>
</div>

<div class="form-group">
	<div class="table">
		<table class="table">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Precio</th>
					<th>Cantidad</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
