<table class="table table-striped">
	<tbody>
		@foreach($buy as $column => $value)
			@if($column != 'last_login' && $column != 'created_at' && $column != 'updated_at' && $column != 'deleted_at' && $column != 'slug' && $column != 'delivery_schedules_id' && $column != 'status_id' && $value != '')
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

@include('admin.modules.sales.confirm')
