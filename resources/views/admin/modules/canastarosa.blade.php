@if(isset($item))
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
	
	<input type="hidden" value="{{ $item->id }}" id="nd_buys_id" name="nd_buys_id">
@else
	<input type="hidden" value="0" id="nd_buys_id" name="nd_buys_id">
@endif

<div class="form-group">
	<label for="origins_code">{{ ucfirst(trans('validation.attributes.origins_code')) }} *</label>
	<input type="text" class="form-control @error('origins_code') is-invalid @enderror" id="origins_code" name="origins_code" value="@if(isset($item)){{ $item->origins_code }}@else{{ old('origins_code') }}@endif" @if(isset($item)){{ 'readonly' }}@endif>
	@error('origins_code')
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

<div class="form-group">
	<label for="package">{{ ucfirst(trans('validation.attributes.package')) }} *</label>
	<input type="text" class="form-control @error('package') is-invalid @enderror" id="package" name="package" value="@if(isset($item)){{ $item->seller_package }}@else{{ old('package') }}@endif" @if(isset($item)){{ 'readonly' }}@endif>
	@error('package')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

@if(isset($item))
	<div class="form-group">
		<label for="nd_themathics_id">{{ ucfirst(trans('validation.attributes.nd_themathics_id')) }} *</label>
	    <select class="form-control @error('nd_themathics_id') is-invalid @enderror" id="nd_themathics_id" disabled>
	        <option selected disabled>{{ ucfirst(trans('validation.attributes.nd_themathics_id')) }} *</option>
	        @foreach($nd_themathics_id as $key => $value)
	            <option value="{{ $key }}" @if(isset($item)){{ $item->nd_themathics_id == $key ? 'selected' : '' }}@else{{ old('nd_themathics_id') == $key ? 'selected' : '' }}@endif>{{ $value }}</option>
	        @endforeach
	    </select>
	    @error('nd_delivery_schedules_id')
	        <div class="alert alert-danger">{{ $message }}</div>
	    @enderror
	</div>
	<input type="hidden" value="{{ $item->nd_themathics_id }}" name="nd_themathics_id">
@else
	<div class="form-group">
		<label for="nd_themathics_id">{{ ucfirst(trans('validation.attributes.nd_themathics_id')) }} *</label>
	    <select class="form-control @error('nd_themathics_id') is-invalid @enderror" id="nd_themathics_id" name="nd_themathics_id">
	        <option selected disabled>{{ ucfirst(trans('validation.attributes.nd_themathics_id')) }} *</option>
	        @foreach($nd_themathics_id as $key => $value)
	            <option value="{{ $key }}">{{ $value }}</option>
	        @endforeach
	    </select>
	    @error('nd_delivery_schedules_id')
	        <div class="alert alert-danger">{{ $message }}</div>
	    @enderror
	</div>
@endif

<div class="form-group">
	<label for="modifications">{{ ucfirst(trans('validation.attributes.modifications')) }} *</label>
	<textarea class="form-control form-control-user @error('modifications') is-invalid @enderror" id="modifications" name="modifications" placeholder="{{ ucfirst(trans('validation.attributes.modifications')) }}">{{ old('modifications') }}</textarea>
	@error('modifications')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="who_sends">{{ ucfirst(trans('validation.attributes.who_sends')) }} *</label>
	<input type="text" class="form-control @error('who_sends') is-invalid @enderror" id="who_sends" name="who_sends" value="@if(isset($item)){{ $item->who_sends }}@else{{ old('who_sends') }}@endif" @if(isset($item)){{ 'readonly' }}@endif>
	@error('who_sends')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="who_receives">{{ ucfirst(trans('validation.attributes.who_receives')) }} *</label>
	<input type="text" class="form-control @error('who_receives') is-invalid @enderror" id="who_receives" name="who_receives" value="@if(isset($item)){{ $item->who_receives }}@else{{ old('who_receives') }}@endif" @if(isset($item)){{ 'readonly' }}@endif>
	@error('who_receives')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="dedication">{{ ucfirst(trans('validation.attributes.dedication')) }} *</label>
	<textarea class="form-control form-control-user @error('dedication') is-invalid @enderror" id="dedication" name="dedication" placeholder="{{ ucfirst(trans('validation.attributes.dedication')) }}" @if(isset($item)){{ 'readonly' }}@endif>@if(isset($item)){{ $item->dedication }}@else{{ old('dedication') }}@endif</textarea>
	@error('dedication')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="delivery_date">{{ ucfirst(trans('validation.attributes.delivery_date')) }} *</label>
	<input type="text" class="form-control @error('delivery_date') is-invalid @enderror" id="@if(isset($item)){{ 'delivery_date' }}@else{{ 'datepicker' }}@endif" name="delivery_date" value="@if(isset($item)){{ \Carbon\Carbon::parse($item->delivery_date)->format("d/m/Y") }}@else{{ old('delivery_date') }}@endif" readonly>
	@error('delivery_date')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

@if(isset($item))
	<div class="form-group">
		<label for="nd_delivery_schedules_id">{{ ucfirst(trans('validation.attributes.nd_delivery_schedules_id')) }} *</label>
	    <select class="form-control @error('nd_delivery_schedules_id') is-invalid @enderror" id="nd_delivery_schedules_id" disabled>
	        <option selected disabled>{{ ucfirst(trans('validation.attributes.nd_delivery_schedules_id')) }} *</option>
	        @foreach($nd_delivery_schedules_id as $key => $value)
	            <option value="{{ $key }}" @if(isset($item)){{ $item->nd_delivery_schedules_id == $key ? 'selected' : '' }}@else{{ old('nd_delivery_schedules_id') == $key ? 'selected' : '' }}@endif>{{ $value }}</option>
	        @endforeach
	    </select>
	    @error('nd_delivery_schedules_id')
	        <div class="alert alert-danger">{{ $message }}</div>
	    @enderror
	</div>
	<input type="hidden" value="{{ $item->nd_delivery_schedules_id }}" name="nd_delivery_schedules_id">
@else
	<div class="form-group">
		<label for="nd_delivery_schedules_id">{{ ucfirst(trans('validation.attributes.nd_delivery_schedules_id')) }} *</label>
	    <select class="form-control @error('nd_delivery_schedules_id') is-invalid @enderror" id="nd_delivery_schedules_id" name="nd_delivery_schedules_id">
	        <option selected disabled>{{ ucfirst(trans('validation.attributes.nd_delivery_schedules_id')) }} *</option>
	        @foreach($nd_delivery_schedules_id as $key => $value)
	            <option value="{{ $key }}"{{ old('nd_delivery_schedules_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
	        @endforeach
	    </select>
	    @error('nd_delivery_schedules_id')
	        <div class="alert alert-danger">{{ $message }}</div>
	    @enderror
	</div>
@endif

<div class="form-group">
	<label for="observations_buildings">{{ ucfirst(trans('validation.attributes.observations_buildings')) }} *</label>
	<textarea class="form-control form-control-user @error('observations_buildings') is-invalid @enderror" id="observations_buildings" name="observations_buildings" placeholder="{{ ucfirst(trans('validation.attributes.observations_buildings')) }}">{{ old('observations_buildings') }}</textarea>
	@error('observations_buildings')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>
