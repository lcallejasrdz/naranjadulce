<table class="table table-striped">
	<tbody>
		@foreach($buy as $column => $value)
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

@if($buy['status_id'] == 'Por confirmar' || $buy['status_id'] == 'Verificar')
	<hr>

	<input type="hidden" value="{{ $buy['slug'] }}" id="slug" name="slug">
	<input type="hidden" value="{{ Sentinel::getUser()->id }}" id="user_id" name="user_id">
	<input type="hidden" value="{{ $buy['delivery_schedule'] }}" id="delivery_schedule" name="delivery_schedule">


	<div class="form-group">
		<label for="quantity">{{ ucfirst(trans('validation.attributes.quantity')) }} *</label>
		<input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="@if(isset($item)){{ $item->quantity }}@else{{ old('quantity') }}@endif">
		@error('quantity')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="seller_package">{{ ucfirst(trans('validation.attributes.seller_package')) }} *</label>
		<input type="text" class="form-control @error('seller_package') is-invalid @enderror" id="seller_package" name="seller_package" value="@if(isset($item)){{ $item->seller_package }}@else{{ old('seller_package') }}@endif">
		@error('seller_package')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="seller_modifications">{{ ucfirst(trans('validation.attributes.seller_modifications')) }} *</label>
		<textarea class="form-control form-control-user @error('seller_modifications') is-invalid @enderror" id="seller_modifications" name="seller_modifications" placeholder="{{ ucfirst(trans('validation.attributes.seller_modifications')) }}">@if(isset($item)){{ $item->seller_modifications }}@else{{ old('seller_modifications') }}@endif</textarea>
		@error('seller_modifications')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
	    <label for="delivery_type">{{ ucfirst(trans('validation.attributes.delivery_type')) }}</label>
	    <select class="form-control @error('delivery_type') is-invalid @enderror" id="delivery_type" name="delivery_type">
	      	<option selected disabled>{{ ucfirst(trans('validation.attributes.choose')) }}:</option>
	      	<option value="{{ ucfirst(trans('module_sales.delivery_type.normal')) }}" @if(isset($item)){!! ($item->delivery_type == ucfirst(trans('module_sales.delivery_type.normal'))) ? 'selected' : '' !!}@else{{ old('delivery_type') == ucfirst(trans('module_sales.delivery_type.normal')) ? 'selected' : '' }}@endif>{{ ucfirst(trans('module_sales.delivery_type.normal')) }}</option>
	      	<option value="{{ ucfirst(trans('module_sales.delivery_type.special')) }}" @if(isset($item)){!! ($item->delivery_type == ucfirst(trans('module_sales.delivery_type.special'))) ? 'selected' : '' !!}@else{{ old('delivery_type') == ucfirst(trans('module_sales.delivery_type.special')) ? 'selected' : '' }}@endif>{{ ucfirst(trans('module_sales.delivery_type.special')) }}</option>
	    </select>
	</div>

	<div class="form-group">
		<label for="preferential_schedule">{{ ucfirst(trans('validation.attributes.preferential_schedule')) }} @if($buy['delivery_schedule'] == ucfirst(trans('module_buys.delivery_schedule.preferential')))*@endif</label>
		<input type="text" class="form-control @error('preferential_schedule') is-invalid @enderror" id="preferential_schedule" name="preferential_schedule" value="@if(isset($item)){{ $item->preferential_schedule }}@else{{ old('preferential_schedule') }}@endif"  @if($buy['schedule_id'] != ucfirst(trans('module_buys.delivery_schedule.preferential'))) {{ 'readonly' }} @endif>
		@error('preferential_schedule')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="observations_finances">{{ ucfirst(trans('validation.attributes.observations_finances')) }}</label>
		<textarea class="form-control form-control-user @error('observations_finances') is-invalid @enderror" id="observations_finances" name="observations_finances" placeholder="{{ ucfirst(trans('validation.attributes.observations_finances')) }}">@if(isset($item)){{ $item->observations_finances }}@else{{ old('observations_finances') }}@endif</textarea>
		@error('observations_finances')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="observations_buildings">{{ ucfirst(trans('validation.attributes.observations_buildings')) }}</label>
		<textarea class="form-control form-control-user @error('observations_buildings') is-invalid @enderror" id="observations_buildings" name="observations_buildings" placeholder="{{ ucfirst(trans('validation.attributes.observations_buildings')) }}">@if(isset($item)){{ $item->observations_buildings }}@else{{ old('observations_buildings') }}@endif</textarea>
		@error('observations_buildings')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="observations_shippings">{{ ucfirst(trans('validation.attributes.observations_shippings')) }}</label>
		<textarea class="form-control form-control-user @error('observations_shippings') is-invalid @enderror" id="observations_shippings" name="observations_shippings" placeholder="{{ ucfirst(trans('validation.attributes.observations_shippings')) }}">@if(isset($item)){{ $item->observations_shippings }}@else{{ old('observations_shippings') }}@endif</textarea>
		@error('observations_shippings')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
		<label for="shipping_cost">{{ ucfirst(trans('validation.attributes.shipping_cost')) }} *</label>
		<input type="text" class="form-control @error('shipping_cost') is-invalid @enderror" id="shipping_cost" name="shipping_cost" value="@if(isset($item)){{ $item->shipping_cost }}@else{{ old('shipping_cost') }}@endif">
		@error('shipping_cost')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>

	<div class="form-group">
	    <label for="proof_of_payment">{{ ucfirst(trans('validation.attributes.proof_of_payment')) }} *</label>
	    <input type="file" class="form-control-file @error('proof_of_payment') is-invalid @enderror" id="proof_of_payment" name="proof_of_payment">
		@error('proof_of_payment')
		    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
	</div>
@endif
