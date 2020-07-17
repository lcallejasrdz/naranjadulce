<table class="table table-striped">
	<tbody>
		@foreach($buy as $column => $value)
			@if($column != 'last_login' && $column != 'created_at' && $column != 'updated_at' && $column != 'deleted_at' && $column != 'slug' && $column != 'status_id' && $value != '')
	            <tr>
	                <th>
	                    {{ ucfirst(trans('validation.attributes.'.$column)) }}
	                </th>
	                <td>
                        @if($column == 'delivery_date')
                            {{ \Carbon\Carbon::parse($value)->format("d/m/Y") }}
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

<input type="hidden" value="{{ $item->id }}" id="nd_buys_id" name="nd_buys_id">

<div class="form-group">
	<label for="delivery_man">{{ ucfirst(trans('validation.attributes.delivery_man')) }} *</label>
	<input type="text" class="form-control @error('delivery_man') is-invalid @enderror" id="delivery_man" name="delivery_man" value="{{ old('delivery_man') }}">
	@error('delivery_man')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
</div>
