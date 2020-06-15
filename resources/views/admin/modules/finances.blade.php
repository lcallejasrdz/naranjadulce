<table class="table table-striped">
	<tbody>
		@if($item->preferential_schedule != '')
			@php $schedule = 1; @endphp
		@else
			@php $schedule = 0; @endphp
		@endif
		@foreach($item as $column => $value)
			@if($column == 'schedule_id')
				@if($schedule == 0)
		            <tr>
		                <th>
		                    {{ ucfirst(trans('validation.attributes.'.$column)) }}
		                </th>
		                <td>
		                    {{ $value }}
		                </td>
		            </tr>
		        @endif
			@elseif($column == 'preferential_schedule')
				@if($schedule == 1)
		            <tr>
		                <th>
		                    {{ ucfirst(trans('validation.attributes.'.$column)) }}
		                </th>
		                <td>
		                    {{ $value }}
		                </td>
		            </tr>
		        @endif
			@elseif($column != 'last_login' && $column != 'created_at' && $column != 'updated_at' && $column != 'deleted_at' && $column != 'slug' && $column != 'proof_of_payment' && $value != '')
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
		<tr>
            <th>
                {{ ucfirst(trans('validation.attributes.proof_of_payment')) }}
            </th>
            <td>
            	<i class="fa fa-download"></i>{!! link_to($proof_of_payment, ' Download File', ['target' => '_blank']) !!}
            </td>
        </tr>
	</tbody>
</table>

<hr>

<input type="hidden" value="{{ $item->slug }}" id="slug" name="slug">
<input type="hidden" value="{{ Sentinel::getUser()->id }}" id="user_id" name="user_id">
<input type="hidden" value="1" id="verified_payment" name="verified_payment">