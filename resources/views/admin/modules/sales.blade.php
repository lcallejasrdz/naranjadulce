<table class="table table-striped">
	<tbody>
		@foreach($buy as $column => $value)
			@if($column != 'last_login' && $column != 'created_at' && $column != 'updated_at' && $column != 'deleted_at' && $column != 'slug')
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

<hr>

<input type="hidden" value="{{ $buy['slug'] }}" id="slug" name="slug">
<input type="hidden" value="{{ Sentinel::getUser()->id }}" id="user_id" name="user_id">

<div class="form-group">
    <label for="proof_of_payment">{{ ucfirst(trans('validation.attributes.proof_of_payment')) }}</label>
    <input type="file" class="form-control-file @error('proof_of_payment') is-invalid @enderror" id="proof_of_payment" name="proof_of_payment">
	@error('proof_of_payment')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="seller_package">{{ ucfirst(trans('validation.attributes.seller_package')) }}</label>
	<input type="text" class="form-control @error('seller_package') is-invalid @enderror" id="seller_package" name="seller_package" value="@isset($item) {{ $item->seller_package }} @endisset">
	@error('seller_package')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
	<label for="seller_modifications">{{ ucfirst(trans('validation.attributes.seller_modifications')) }}</label>
	<textarea class="form-control form-control-user @error('seller_modifications') is-invalid @enderror" id="seller_modifications" name="seller_modifications" placeholder="{{ ucfirst(trans('validation.attributes.seller_modifications')) }}"></textarea>
	@error('seller_modifications')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>

<div class="form-group">
    <label for="delivery_type">{{ ucfirst(trans('validation.attributes.delivery_type')) }}</label>
    <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="delivery_type">
      	<option selected disabled>{{ ucfirst(trans('validation.attributes.choose')) }}:</option>
      	<option value="{{ ucfirst(trans('module_sales.delivery_type.normal')) }}" @isset($item) {!! ($item->delivery_type == ucfirst(trans('module_sales.delivery_type.normal'))) ? 'selected' : '' !!} @endisset>{{ ucfirst(trans('module_sales.delivery_type.normal')) }}</option>
      	<option value="{{ ucfirst(trans('module_sales.delivery_type.special')) }}" @isset($item) {!! ($item->delivery_type == ucfirst(trans('module_sales.delivery_type.special'))) ? 'selected' : '' !!} @endisset>{{ ucfirst(trans('module_sales.delivery_type.special')) }}</option>
    </select>
</div>
