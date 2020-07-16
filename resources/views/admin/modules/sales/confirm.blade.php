<hr>

@if($item->status_id == 8)
	<table class="table table-striped">
		<tbody>
			<tr>
                <th>
                    {{ ucfirst(trans('validation.attributes.reason')) }}
                </th>
                <td>
                    {{ $return_reason }}
                </td>
            </tr>
		</tbody>
	</table>

	<hr>
@endif

<input type="hidden" value="{{ $item->id }}" id="nd_buys_id" name="nd_buys_id">
<input type="hidden" value="{{ $item->delivery_schedules_id }}" id="delivery_schedules_id" name="delivery_schedules_id">

<div class="form-group">
	<label for="quantity">{{ ucfirst(trans('validation.attributes.quantity')) }} *</label>
	<input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="@if($item->status_id == 8){{ $package_detail->quantity }}@else{{ old('quantity') }}@endif" @if($item->status_id == 8){{ 'readonly' }}@endif>
	@error('quantity')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="package">{{ ucfirst(trans('validation.attributes.package')) }} *</label>
	<input type="text" class="form-control @error('package') is-invalid @enderror" id="package" name="package" value="@if($item->status_id == 8){{ $package_detail->package }}@else{{ old('package') }}@endif"@if($item->status_id == 8){{ 'readonly' }}@endif>
	@error('package')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="modifications">{{ ucfirst(trans('validation.attributes.modifications')) }} *</label>
	<textarea class="form-control form-control-user @error('modifications') is-invalid @enderror" id="modifications" name="modifications" placeholder="{{ ucfirst(trans('validation.attributes.modifications')) }}" @if($item->status_id == 8 && $return_module != 'buildings'){{ 'readonly' }}@endif>@if($item->status_id == 8 && $return_module != 'buildings'){{ $package_detail->modifications }}@else{{ old('modifications') }}@endif</textarea>
	@error('modifications')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

@if($item->status_id == 8 && $return_module != 'shippings')
	<div class="form-group">
	    <label for="nd_delivery_types_id">{{ ucfirst(trans('validation.attributes.nd_delivery_types_id')) }} *</label>
	    <select class="form-control @error('nd_delivery_types_id') is-invalid @enderror" id="nd_delivery_types_id" @if($item->status_id == 8 && $return_module != 'shippings'){{ 'disabled' }}@endif>
	      	<option selected disabled>{{ ucfirst(trans('validation.attributes.choose')) }}:</option>
	        @foreach($nd_delivery_types_id as $key => $value)
	            <option value="{{ $key }}" @if($item->status_id == 8 && $return_module != 'shippings'){{ $sale->nd_delivery_types_id == $key ? 'selected' : '' }}@else{{ old('nd_delivery_types_id') == $key ? 'selected' : '' }}@endif>{{ $value }}</option>
	        @endforeach
	    </select>
	    <input type="hidden" value="1" name="nd_delivery_types_id">
	</div>
@else
	<div class="form-group">
	    <label for="nd_delivery_types_id">{{ ucfirst(trans('validation.attributes.nd_delivery_types_id')) }} *</label>
	    <select class="form-control @error('nd_delivery_types_id') is-invalid @enderror" id="nd_delivery_types_id" name="nd_delivery_types_id">
	      	<option selected disabled>{{ ucfirst(trans('validation.attributes.choose')) }}:</option>
	        @foreach($nd_delivery_types_id as $key => $value)
	            <option value="{{ $key }}" {{ old('nd_delivery_types_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
	        @endforeach
	    </select>
	</div>
@endif

<div class="form-group">
	<label for="preferential_schedule">{{ ucfirst(trans('validation.attributes.preferential_schedule')) }} @if($item->delivery_schedules_id == 3)*@endif</label>
	<input type="text" class="form-control @error('preferential_schedule') is-invalid @enderror" id="preferential_schedule" name="preferential_schedule" value="@if($item->status_id == 8 && $return_module != 'buildings'){{ $sale->preferential_schedule }}@else{{ old('preferential_schedule') }}@endif" @if($item->status_id == 8 && $return_module != 'shippings'){{ 'readonly' }}@else @if($item->delivery_schedules_id != 3){{ 'readonly' }}@endif @endif>
	@error('preferential_schedule')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="observations_finances">{{ ucfirst(trans('validation.attributes.observations_finances')) }} *</label>
	<textarea class="form-control form-control-user @error('observations_finances') is-invalid @enderror" id="observations_finances" name="observations_finances" placeholder="{{ ucfirst(trans('validation.attributes.observations_finances')) }}" @if($item->status_id == 8 && $return_module != 'finances'){{ 'readonly' }}@endif>@if($item->status_id == 8 && $return_module != 'finances'){{ $sale->observations_finances }}@else{{ old('observations_finances') }}@endif</textarea>
	@error('observations_finances')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="observations_buildings">{{ ucfirst(trans('validation.attributes.observations_buildings')) }} *</label>
	<textarea class="form-control form-control-user @error('observations_buildings') is-invalid @enderror" id="observations_buildings" name="observations_buildings" placeholder="{{ ucfirst(trans('validation.attributes.observations_buildings')) }}" @if($item->status_id == 8 && $return_module != 'buildings'){{ 'readonly' }}@endif>@if($item->status_id == 8 && $return_module != 'buildings'){{ $sale->observations_buildings }}@else{{ old('observations_buildings') }}@endif</textarea>
	@error('observations_buildings')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="observations_shippings">{{ ucfirst(trans('validation.attributes.observations_shippings')) }} *</label>
	<textarea class="form-control form-control-user @error('observations_shippings') is-invalid @enderror" id="observations_shippings" name="observations_shippings" placeholder="{{ ucfirst(trans('validation.attributes.observations_shippings')) }}" @if($item->status_id == 8 && $return_module != 'shippings'){{ 'readonly' }}@endif>@if($item->status_id == 8 && $return_module != 'shippings'){{ $sale->observations_shippings }}@else{{ old('observations_shippings') }}@endif</textarea>
	@error('observations_shippings')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="delivery_price">{{ ucfirst(trans('validation.attributes.delivery_price')) }} *</label>
	<input type="text" class="form-control @error('delivery_price') is-invalid @enderror" id="delivery_price" name="delivery_price" value="@if($item->status_id == 8 && $return_module != 'finances'){{ $package_detail->delivery_price }}@else{{ old('delivery_price') }}@endif" @if($item->status_id == 8 && $return_module != 'finances'){{ 'readonly' }}@endif>
	@error('delivery_price')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

@if($item->status_id == 8 && $return_module != 'finances')
	<input type="hidden" value="1" id="proof_verified" name="proof_verified">
	<div class="form-group">
	    <label for="proof_of_payment">{{ ucfirst(trans('validation.attributes.proof_of_payment')) }} *</label>
	    <br>
	    <i class="fa fa-download"></i>{!! link_to($sale->proof_of_payment, ' Download File', ['target' => '_blank']) !!}
		@error('proof_of_payment')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>
@else
	<input type="hidden" value="0" id="proof_verified" name="proof_verified">
	<div class="form-group">
	    <label for="proof_of_payment">{{ ucfirst(trans('validation.attributes.proof_of_payment')) }} *</label>
	    <input type="file" class="form-control-file @error('proof_of_payment') is-invalid @enderror" id="proof_of_payment" name="proof_of_payment">
		@error('proof_of_payment')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>
@endif

@if($item->status_id == 8)
	<input type="hidden" value="{{ $return_module }}" id="return_module" name="return_module">
@endif
