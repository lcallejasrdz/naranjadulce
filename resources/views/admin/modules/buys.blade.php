@extends('admin.layouts.sbadmin_front')

@section('title', '| '.$word)

@section('styles')
    <style>
        .form-logo img{
            width: 150px;
            max-width: 75%;
        }
        .bg-register-image {
            background-color: #E45C64;
            /*background: url("/img/bannerformcustomer.jpg");*/
            background-image: none;
            background-position: center;
            background-size: cover;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('page-image')
    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
@endsection

@section('panel-heading')
    <div class="form-logo">
        <img src="{{ env('APP_URL') }}/img/logo.png" alt="Naranja Dulce Logo">
    </div>
    <br>
    <h1 class="h4 text-gray-900 mb-4">{{ trans('crud.buy.title') }}</h1>
    <p>Favor de llenar la información solicitada completa para una entrega sin contratiempos.</p>
@endsection

@section('content')
    <form class="user" method="POST" action="{{ route($active.'.store') }}">
        <hr>
        <h2 class="h5 text-gray-900 mb-4 text-center">{{ trans('module_buys.titles.contact_data') }}</h2>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="{{ ucfirst(trans('validation.attributes.first_name')) }} *" value="{{ old('first_name') }}">
                @error('first_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="{{ ucfirst(trans('validation.attributes.last_name')) }} *" value="{{ old('last_name') }}">
                @error('last_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ ucfirst(trans('validation.attributes.email')) }}" value="{{ old('email') }}">
                <small id="emailHelp" class="form-text text-muted">{{ trans('module_buys.publicity_message') }}</small>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="{{ ucfirst(trans('validation.attributes.phone')) }} *" value="{{ old('phone') }}">
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <hr>
        <h2 class="h5 text-gray-900 mb-4 text-center">{{ trans('module_buys.titles.delivery_address') }}</h2>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" placeholder="{{ ucfirst(trans('validation.attributes.postal_code')) }} *" value="{{ old('postal_code') }}">
                @error('postal_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('state') is-invalid @enderror" id="state" name="state" placeholder="{{ ucfirst(trans('validation.attributes.state')) }} *" value="{{ old('state') }}">
                @error('state')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('municipality') is-invalid @enderror" id="municipality" name="municipality" placeholder="{{ ucfirst(trans('validation.attributes.municipality')) }} *" value="{{ old('municipality') }}">
                @error('municipality')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('colony') is-invalid @enderror" id="colony" name="colony" placeholder="{{ ucfirst(trans('validation.attributes.colony')) }} *" value="{{ old('colony') }}">
                @error('colony')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('street') is-invalid @enderror" id="street" name="street" placeholder="{{ ucfirst(trans('validation.attributes.street')) }} *" value="{{ old('street') }}">
                @error('street')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('no_ext') is-invalid @enderror" id="no_ext" name="no_ext" placeholder="{{ ucfirst(trans('validation.attributes.no_ext')) }} *" value="{{ old('no_ext') }}">
                @error('no_ext')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('no_int') is-invalid @enderror" id="no_int" name="no_int" placeholder="{{ ucfirst(trans('validation.attributes.no_int')) }}" value="{{ old('no_int') }}">
                @error('no_int')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <select class="form-control @error('nd_address_types_id') is-invalid @enderror" id="nd_address_types_id" name="nd_address_types_id">
                    <option selected disabled>{{ ucfirst(trans('validation.attributes.nd_address_types_id')) }} *</option>
                    @foreach($nd_address_types_id as $key => $value)
                        <option value="{{ $key }}" {{ old('nd_address_types_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @error('nd_address_types_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <textarea class="form-control form-control-user @error('references') is-invalid @enderror" id="references" name="references" placeholder="{{ ucfirst(trans('validation.attributes.references')) }} *">{{ old('references') }}</textarea>
            @error('references')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <select class="form-control @error('nd_parkings_id') is-invalid @enderror" id="nd_parkings_id" name="nd_parkings_id">
                <option selected disabled>{{ ucfirst(trans('validation.attributes.nd_parkings_id')) }} *</option>
                @foreach($nd_parkings_id as $key => $value)
                    <option value="{{ $key }}" {{ old('nd_parkings_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
            @error('nd_parkings_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <hr>
        <h2 class="h5 text-gray-900 mb-4 text-center">{{ trans('module_buys.titles.delivery_data') }}</h2>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('who_sends') is-invalid @enderror" id="who_sends" name="who_sends" placeholder="{{ ucfirst(trans('validation.attributes.who_sends')) }} *" value="{{ old('who_sends') }}">
                @error('who_sends')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('who_receives') is-invalid @enderror" id="who_receives" name="who_receives" placeholder="{{ ucfirst(trans('validation.attributes.who_receives')) }} *" value="{{ old('who_receives') }}">
                @error('who_receives')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('package') is-invalid @enderror" id="package" name="package" placeholder="{{ ucfirst(trans('validation.attributes.package')) }} *" value="{{ old('package') }}">
            @error('package')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <select class="form-control @error('nd_themathics_id') is-invalid @enderror" id="nd_themathics_id" name="nd_themathics_id">
                <option selected disabled>{{ ucfirst(trans('validation.attributes.nd_themathics_id')) }} *</option>
                @foreach($nd_themathics_id as $key => $value)
                    <option value="{{ $key }}" {{ old('nd_themathics_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
            @error('nd_themathics_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <textarea class="form-control form-control-user @error('modifications') is-invalid @enderror" id="modifications" name="modifications" placeholder="{{ ucfirst(trans('validation.attributes.modifications')) }}">{{ old('modifications') }}</textarea>
            @error('modifications')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <textarea class="form-control form-control-user @error('dedication') is-invalid @enderror" id="dedication" name="dedication" placeholder="{{ ucfirst(trans('validation.attributes.dedication')) }}">{{ old('dedication') }}</textarea>
            @error('dedication')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('delivery_date') is-invalid @enderror" id="datepicker" name="delivery_date" placeholder="{{ ucfirst(trans('validation.attributes.delivery_date')) }} *" value="{{ old('delivery_date') }}" readonly>
                @error('delivery_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <select class="form-control @error('nd_delivery_schedules_id') is-invalid @enderror" id="nd_delivery_schedules_id" name="nd_delivery_schedules_id">
                    <option selected disabled>{{ ucfirst(trans('validation.attributes.nd_delivery_schedules_id')) }} *</option>
                    @foreach($nd_delivery_schedules_id as $key => $value)
                        <option value="{{ $key }}" {{ old('nd_delivery_schedules_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @error('nd_delivery_schedules_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <textarea class="form-control form-control-user @error('observations') is-invalid @enderror" id="observations" name="observations" placeholder="{{ ucfirst(trans('validation.attributes.observations')) }}">{{ old('observations') }}</textarea>
            @error('observations')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <hr>
        <div class="form-group">
            <legend class="col-form-label">{{ ucfirst(trans('validation.attributes.nd_contact_means_id')) }} *</legend>
            <div>
                @foreach($nd_contact_means_id as $key => $value)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="nd_contact_means_id" id="gridRadios2" value="{{ $key }}" {{ old('nd_contact_means_id') == $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="gridRadios2">
                            {{ $value }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('how_know_us')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('contact_mean_other') is-invalid @enderror" id="contact_mean_other" name="contact_mean_other" placeholder="{{ ucfirst(trans('validation.attributes.contact_mean_other')) }}" value="{{ old('contact_mean_other') }}">
            @error('contact_mean_other')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <hr>
        <input type="submit" class="btn btn-primary btn-user btn-block" value="{{ ucfirst(trans('crud.buy.submit')) }}">
    </form>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var currentDate = "{{ $current_date }}";
        var currentDay = "{{ $current_day }}";
        var currentTime = "{{ $current_time }}";

        console.log("Current date:" + currentDate + "; current day:" + currentDay + "; current time:" + currentTime);

        $(function(){
            if(currentTime >= '19:00:00' || currentDay == 'Saturday' || currentDay == 'Sunday'){
                $("#datepicker").datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    dateFormat: "dd/mm/yy",
                    minDate: 1,
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
                    onSelect: function(dateText) {
                        getSchedules(dateText);
                    }
                });
            }
        });

        function getSchedules(value){
            if(value == '' || value == null)
            {
                $( "#nd_delivery_schedules_id" ).find("option:gt(0)").remove();
            }
            else
            {
                $.get(direction+"/buys/datepicker/"+value, function(response, value){
                    $( "#nd_delivery_schedules_id" ).find("option:gt(0)").remove();
                    for(i=0; i<response.length; i++){
                        $( "#nd_delivery_schedules_id" ).append("<option value='"+ response[i].id +"'>"+ response[i].name +"</option>");
                    }
                });
            }
        }

        $(document).ready(function() {
            getSchedules($( "#datepicker" ).val());
        });
    </script>
@endsection