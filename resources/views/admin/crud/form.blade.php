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
                
                @if($active == 'users' || $active == 'products' || $active == 'packages')
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
    @if($active == 'packages')
        <script>
            function addProduct(){
                var product_id = $("#nd_products_id").val();

                if(product_id != ""){
                    $.get(direction+"/packages/products/"+product_id, function(product, value){
                        var price = product[0].price;
                        var quantity = $("#quantity").val();

                        if((parseFloat(quantity) == parseInt(quantity)) && !isNaN(quantity)){
                            $("#nd_products_id").val('{{ ucfirst(trans('validation.attributes.nd_products_id')) }} *');
                            $("#quantity").val('');

                            var productsTable = $('#products_table').val();

                            if(productsTable == ''){
                                $('#products_table').val(product[0].id);

                                $('#productsTable tr:last').after('<tr><td><input type="hidden" name="products[]" value="'+ product[0].id +'">'+ product[0].product_name +'</td><td><input type="hidden" name="prices[]" value="'+ product[0].price +'">'+ product[0].price +'</td><td><input type="hidden" name="quantities[]" value="'+ quantity +'">'+ quantity +'</td><td><input type="hidden" name="costs[]" value="'+ (product[0].price * quantity) +'"><button type="button" class="btn btn-danger" onclick="deleteProduct(' + product[0].id +', this, '+ product[0].price +', '+ quantity +')">{{ trans('module_products.controller.delete_word') }}</button></td></tr>');
                            }else{
                                var array = productsTable.split(",");

                                var control = 0;
                                for(i=0; i<array.length; i++){
                                    if(array[i] == product[0].id){
                                        control = 1;
                                    }
                                }

                                if(control == 0){
                                    var value = "";

                                    for(i=0; i<array.length; i++){
                                        if(value==""){
                                            value = array[i];
                                        }else{
                                            value = value + "," + array[i];
                                        }
                                    }

                                    value = value + "," + product[0].id;

                                    $('#products_table').val(value);

                                    $('#productsTable tr:last').after('<tr><td><input type="hidden" name="products[]" value="'+ product[0].id +'">'+ product[0].product_name +'</td><td><input type="hidden" name="prices[]" value="'+ product[0].price +'">'+ product[0].price +'</td><td><input type="hidden" name="quantities[]" value="'+ quantity +'">'+ quantity +'</td><td><input type="hidden" name="costs[]" value="'+ (product[0].price * quantity) +'"><button type="button" class="btn btn-danger" onclick="deleteProduct(' + product[0].id +', this, '+ product[0].price +', '+ quantity +')">{{ trans('module_products.controller.delete_word') }}</button></td></tr>');
                                }else{
                                    alert("product exists");
                                }
                            }

                            var total = $("#amount").val();
                            total = parseFloat(total) + (parseFloat(product[0].price) * parseFloat(quantity));
                            $("#visible_amount").val(total.toFixed(2));
                            $("#amount").val(total.toFixed(2));
                        }else{
                            alert("data is not an integer");
                        }
                    });
                }else{
                    alert("select a product");
                }
            }

            function deleteProduct(id, button, price, quantity){
                $(button).parents("tr").remove();

                var productsTable = $('#products_table').val();
                var array = productsTable.split(",");
                var value = "";

                for(i=0; i<array.length; i++){
                    if(array[i] != id){
                        if(value==""){
                            value = array[i];
                        }else{
                            value = value + "," + array[i];
                        }
                    }
                }
                $('#products_table').val(value);

                var total = $("#amount").val();
                total = parseFloat(total) - (parseFloat(price) * parseFloat(quantity));
                $("#visible_amount").val(total.toFixed(2));
                $("#amount").val(total.toFixed(2));
            }
        </script>
    @endif
@endsection