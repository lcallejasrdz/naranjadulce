@extends('admin.layouts.sbadmin')

@section('title', '| '.$word)

@section('styles')
    @if($active == 'canastarosa')
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    @endif
@endsection

@section('page-header', $word)

@section('panel-heading')
    @if($view == 'create')
        <i class="fa fa-plus fa-fw"></i> {{ trans('crud.sidebar.add') }}
    @else
        <i class="fa fa-pen fa-fw"></i> {{ trans('crud.sidebar.edit') }}
    @endif
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
        	@if($view == 'create')
            	<form method="POST" action="{{ route($active.'.store') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @else
            	<form method="POST" action="{{ route($active.'.update', ['id' => $item->id]) }}" enctype="multipart/form-data">
	            	<input type="hidden" name="_method" value="PUT">
	            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            @endif
                @include('admin.modules.'.$active)
                
                @if($active == 'users' || $active == 'products')
                    <input type="submit" class="btn {{ (isset($item) ? 'btn-success' : 'btn-primary') }}" value="{{ (isset($item) ? trans('crud.update.update') : trans('crud.create.add'))  }}">
                @elseif($active == 'sales' && ($item->status_id == 1 || $item->status_id == 8))
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.sale.submit') }}">
                @elseif($active == 'finances' && $item->status_id == 4)
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.finance.submit') }}">
                    <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#returnModal">{{ trans('crud.building.return') }}</a>
                @elseif($active == 'buildings' && $item->status_id == 3)
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.building.submit') }}">
                    <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#returnModal">{{ trans('crud.building.return') }}</a>
                @elseif($active == 'shippings' && $item->status_id == 5)
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.shipping.submit') }}">
                    <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#returnModal">{{ trans('crud.building.return') }}</a>
                @elseif($active == 'deliveries')
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.delivery.submit') }}">
                @elseif($active == 'canastarosa')
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.canastarosa.submit') }}">
                @endif
            </form>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('scripts')
    @if($active == 'sales')
        <script>
            $(document).ready(function() {
                changeFieldSchedule($( "#nd_delivery_types_id" ).val());
            });
            $( "#nd_delivery_types_id" ).change(function(event){
                changeFieldSchedule(event.target.value)
            });
            function changeFieldSchedule(value){
                if(value == 1){
                    $("#preferential_schedule").attr("readonly", true);
                    $("#preferential_schedule").val("");
                }else if(value == 2){
                    $("#preferential_schedule").attr("readonly", false);
                }else{
                }
            }
        </script>
    @endif
    @if($active == 'canastarosa')
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            var currentDate = "{{ $current_date }}";
            var currentDay = "{{ $current_day }}";
            var currentTime = "{{ $current_time }}";

            $(function(){
                if(currentTime >= '12:00:00'){
                    $("#datepicker").datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        dateFormat: "dd/mm/yy",
                        minDate: 1,
                        beforeShowDay: noSundays,
                        onSelect: function(dateText) {
                            getSchedules(dateText);
                        }
                    });
                }else{
                    $("#datepicker").datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        dateFormat: "dd/mm/yy",
                        minDate: 0,
                        beforeShowDay: noSundays,
                        onSelect: function(dateText) {
                            getSchedules(dateText);
                        }
                    });
                }
            });

            function noSundays(date){
                if (date.getDay() === 0)  /* Monday */
                    return [ false, "closed", "Closed on Monday" ]
                else
                    return [ true, "", "" ]
            }

            function getSchedules(value){
                if(value == '' || value == null)
                {
                    $( "#nd_delivery_schedules_id" ).find("option:gt(0)").remove();
                }
                else
                {
                    $.get(direction+"/canastarosa/datepicker/"+value, function(response, value){
                        $( "#nd_delivery_schedules_id" ).find("option:gt(0)").remove();
                        for(i=0; i<response.length; i++){
                            $( "#nd_delivery_schedules_id" ).append("<option value='"+ response[i].id +"'>"+ response[i].name +"</option>");
                        }
                    });
                }
            }

            @if(!isset($item))
                $(document).ready(function() {
                    getSchedules($( "#datepicker" ).val());
                });
            @endif
        </script>
    @endif
@endsection