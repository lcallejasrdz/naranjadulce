<table class="table table-striped">
	<tbody>
		@foreach($buy as $column => $value)
			@if($column != 'last_login' && $column != 'created_at' && $column != 'updated_at' && $column != 'deleted_at' && $column != 'slug' && $column != 'status_id' && $value != '')
				<tr>
	                <th>
	                    {{ ucfirst(trans('validation.attributes.'.$column)) }}
	                </th>
	                <td>
                        @if($column == 'proof_of_payment')
                            <i class="fa fa-download"></i>{!! link_to($value, ' Download File', ['target' => '_blank']) !!}
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
