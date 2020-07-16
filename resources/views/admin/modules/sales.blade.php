<table class="table table-striped">
	<tbody>
		@foreach($buy as $column => $value)
			@if($column != 'last_login' && $column != 'created_at' && $column != 'updated_at' && $column != 'deleted_at' && $column != 'slug' && $column != 'delivery_schedules_id' && $column != 'status_id' && $value != '')
	            <tr>
	                <th>
	                    {{ ucfirst(trans('validation.attributes.'.$column)) }}
	                </th>
	                <td>
	                    {{ $value }}
	                </td>
	            </tr>
	        @endif
        @endforeach
	</tbody>
</table>

@if($item->status_id == 1 || $item->status_id == 8)
	<hr>
	
	<input type="hidden" value="{{ $item->id }}" id="nd_buys_id" name="nd_buys_id">
	<input type="hidden" value="{{ $item->delivery_schedules_id }}" id="delivery_schedules_id" name="delivery_schedules_id">

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
	    <label for="nd_delivery_types_id">{{ ucfirst(trans('validation.attributes.nd_delivery_types_id')) }} *</label>
	    <select class="form-control @error('nd_delivery_types_id') is-invalid @enderror" id="nd_delivery_types_id" name="nd_delivery_types_id">
	      	<option selected disabled>{{ ucfirst(trans('validation.attributes.choose')) }}:</option>
            @foreach($nd_delivery_types_id as $key => $value)
                <option value="{{ $key }}" {{ old('nd_delivery_types_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
	    </select>
	</div>

	{{-- @if(isset($sale) && $sale['delivery_type'] != '')
	 	<div class="form-group">
			<label for="delivery_type">{{ ucfirst(trans('validation.attributes.delivery_type')) }} *</label>
			<input type="text" class="form-control @error('delivery_type') is-invalid @enderror" id="delivery_type" name="delivery_type" value="@if(isset($sale)){{ $sale['delivery_type'] }}@else{{ old('delivery_type') }}@endif" @if(isset($sale) && $sale['delivery_type'] != ''){{ 'readonly' }}@endif>
			@error('delivery_type')
			    <div class="alert alert-danger">{{ $message }}</div>
			@enderror
		</div>
	@else
		<div class="form-group">
		    <label for="delivery_type">{{ ucfirst(trans('validation.attributes.delivery_type')) }} *</label>
		    <select class="form-control @error('delivery_type') is-invalid @enderror" id="delivery_type" name="delivery_type">
		      	<option selected disabled>{{ ucfirst(trans('validation.attributes.choose')) }}:</option>
		      	<option value="{{ ucfirst(trans('module_sales.delivery_type.normal')) }}" @if(isset($sale)){!! ($sale['delivery_type'] == ucfirst(trans('module_sales.delivery_type.normal'))) ? 'selected' : '' !!}@else{{ old('delivery_type') == ucfirst(trans('module_sales.delivery_type.normal')) ? 'selected' : '' }}@endif>{{ ucfirst(trans('module_sales.delivery_type.normal')) }}</option>
		      	<option value="{{ ucfirst(trans('module_sales.delivery_type.special')) }}" @if(isset($sale)){!! ($sale['delivery_type'] == ucfirst(trans('module_sales.delivery_type.special'))) ? 'selected' : '' !!}@else{{ old('delivery_type') == ucfirst(trans('module_sales.delivery_type.special')) ? 'selected' : '' }}@endif>{{ ucfirst(trans('module_sales.delivery_type.special')) }}</option>
		    </select>
		</div>
	@endif --}}

	<div class="form-group">
		<label for="preferential_schedule">{{ ucfirst(trans('validation.attributes.preferential_schedule')) }} @if($item->delivery_schedules_id == 3)*@endif</label>
		<input type="text" class="form-control @error('preferential_schedule') is-invalid @enderror" id="preferential_schedule" name="preferential_schedule" value="{{ old('preferential_schedule') }}" @if($item->delivery_schedules_id != 3){{ 'readonly' }}@endif>
		@error('preferential_schedule')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="observations_finances">{{ ucfirst(trans('validation.attributes.observations_finances')) }} *</label>
		<textarea class="form-control form-control-user @error('observations_finances') is-invalid @enderror" id="observations_finances" name="observations_finances" placeholder="{{ ucfirst(trans('validation.attributes.observations_finances')) }}">{{ old('observations_finances') }}</textarea>
		@error('observations_finances')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="observations_buildings">{{ ucfirst(trans('validation.attributes.observations_buildings')) }} *</label>
		<textarea class="form-control form-control-user @error('observations_buildings') is-invalid @enderror" id="observations_buildings" name="observations_buildings" placeholder="{{ ucfirst(trans('validation.attributes.observations_buildings')) }}">{{ old('observations_buildings') }}</textarea>
		@error('observations_buildings')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="observations_shippings">{{ ucfirst(trans('validation.attributes.observations_shippings')) }} *</label>
		<textarea class="form-control form-control-user @error('observations_shippings') is-invalid @enderror" id="observations_shippings" name="observations_shippings" placeholder="{{ ucfirst(trans('validation.attributes.observations_shippings')) }}">{{ old('observations_shippings') }}</textarea>
		@error('observations_shippings')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="delivery_price">{{ ucfirst(trans('validation.attributes.delivery_price')) }} *</label>
		<input type="text" class="form-control @error('delivery_price') is-invalid @enderror" id="delivery_price" name="delivery_price" value="{{ old('delivery_price') }}">
		@error('delivery_price')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<input type="hidden" value="0" id="proof_verified" name="proof_verified">
	<div class="form-group">
	    <label for="proof_of_payment">{{ ucfirst(trans('validation.attributes.proof_of_payment')) }} *</label>
	    <input type="file" class="form-control-file @error('proof_of_payment') is-invalid @enderror" id="proof_of_payment" name="proof_of_payment">
		@error('proof_of_payment')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	{{-- @if(isset($sale) && $sale['proof_of_payment'] != '')
		<input type="hidden" value="1" id="proof_verified" name="proof_verified">
	@else
		<input type="hidden" value="0" id="proof_verified" name="proof_verified">

		<div class="form-group">
		    <label for="proof_of_payment">{{ ucfirst(trans('validation.attributes.proof_of_payment')) }} *</label>
		    <input type="file" class="form-control-file @error('proof_of_payment') is-invalid @enderror" id="proof_of_payment" name="proof_of_payment">
			@error('proof_of_payment')
			    <div class="alert alert-danger">{{ $message }}</div>
			@enderror
		</div>
	@endif --}}
@else
	<hr>
	
	<table class="table table-striped">
		<tbody>
			@foreach($sale as $column => $value)
				@if($column != 'last_login' && $column != 'created_at' && $column != 'updated_at' && $column != 'deleted_at' && $column != 'slug' && $value != '')
		            <tr>
		                <th>
		                    {{ ucfirst(trans('validation.attributes.'.$column)) }}
		                </th>
		                <td>
		                    @if(($column == 'last_login' && $value != "") || ($column == 'created_at' && $value != "") || ($column == 'updated_at' && $value != "") || ($column == 'deleted_at' && $value != ""))
		                        {{ \Carbon\Carbon::parse($value)->diffForHumans() }}
		                    @else
		                        {{ $value }}
		                    @endif
		                </td>
		            </tr>
		        @endif
	        @endforeach
		</tbody>
	</table>
@endif
