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
                <select class="form-control @error('address_type') is-invalid @enderror" id="address_type" name="address_type">
                    <option selected disabled>{{ ucfirst(trans('validation.attributes.address_type')) }} *</option>
                    <option value="{{ ucfirst(trans('module_buys.address_type.private')) }}" {{ old('address_type') == ucfirst(trans('module_buys.address_type.private')) ? 'selected' : '' }}>{{ ucfirst(trans('module_buys.address_type.private')) }}</option>
                    <option value="{{ ucfirst(trans('module_buys.address_type.business')) }}" {{ old('address_type') == ucfirst(trans('module_buys.address_type.business')) ? 'selected' : '' }}>{{ ucfirst(trans('module_buys.address_type.business')) }}</option>
                    <option value="{{ ucfirst(trans('module_buys.address_type.company')) }}" {{ old('address_type') == ucfirst(trans('module_buys.address_type.company')) ? 'selected' : '' }}>{{ ucfirst(trans('module_buys.address_type.company')) }}</option>
                </select>
                @error('address_type')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <textarea class="form-control form-control-user @error('address_references') is-invalid @enderror" id="address_references" name="address_references" placeholder="{{ ucfirst(trans('validation.attributes.address_references')) }} *">{{ old('address_references') }}</textarea>
            @error('address_references')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <select class="form-control @error('parking') is-invalid @enderror" id="parking" name="parking">
                <option selected disabled>{{ ucfirst(trans('validation.attributes.parking')) }} *</option>
                <option value="{{ ucfirst(trans('module_buys.parking.yes')) }}" {{ old('parking') == ucfirst(trans('module_buys.parking.yes')) ? 'selected' : '' }}>{{ ucfirst(trans('module_buys.parking.yes')) }}</option>
                <option value="{{ ucfirst(trans('module_buys.parking.no')) }}" {{ old('parking') == ucfirst(trans('module_buys.parking.no')) ? 'selected' : '' }}>{{ ucfirst(trans('module_buys.parking.no')) }}</option>
                <option value="{{ ucfirst(trans('module_buys.parking.unknow')) }}" {{ old('parking') == ucfirst(trans('module_buys.parking.unknow')) ? 'selected' : '' }}>{{ ucfirst(trans('module_buys.parking.unknow')) }}</option>
            </select>
            @error('parking')
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
            <textarea class="form-control form-control-user @error('modifications') is-invalid @enderror" id="modifications" name="modifications" placeholder="{{ ucfirst(trans('validation.attributes.modifications')) }}">{{ old('modifications') }}</textarea>
            @error('modifications')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <textarea class="form-control form-control-user @error('buy_message') is-invalid @enderror" id="buy_message" name="buy_message" placeholder="{{ ucfirst(trans('validation.attributes.buy_message')) }}">{{ old('buy_message') }}</textarea>
            @error('buy_message')
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
                <select class="form-control @error('delivery_schedule') is-invalid @enderror" id="delivery_schedule" name="delivery_schedule">
                    <option selected disabled>{{ ucfirst(trans('validation.attributes.delivery_schedule')) }} *</option>
                    <option value="{{ ucfirst(trans('module_buys.delivery_schedule.early')) }}" {{ old('delivery_schedule') == ucfirst(trans('module_buys.delivery_schedule.early')) ? 'selected' : '' }}>{{ ucfirst(trans('module_buys.delivery_schedule.early')) }}</option>
                    <option value="{{ ucfirst(trans('module_buys.delivery_schedule.late')) }}" {{ old('delivery_schedule') == ucfirst(trans('module_buys.delivery_schedule.late')) ? 'selected' : '' }}>{{ ucfirst(trans('module_buys.delivery_schedule.late')) }}</option>
                    <option value="{{ ucfirst(trans('module_buys.delivery_schedule.preferential')) }}" {{ old('delivery_schedule') == ucfirst(trans('module_buys.delivery_schedule.preferential')) ? 'selected' : '' }}>{{ ucfirst(trans('module_buys.delivery_schedule.preferential')) }}</option>
                </select>
                @error('delivery_schedule')
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
            <legend class="col-form-label">{{ ucfirst(trans('validation.attributes.how_know_us')) }} *</legend>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios1" value="{{ ucfirst(trans('module_buys.how_know_us.facebook')) }}" checked>
                    <label class="form-check-label" for="gridRadios1">
                        {{ ucfirst(trans('module_buys.how_know_us.facebook')) }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios2" value="{{ ucfirst(trans('module_buys.how_know_us.instagram')) }}" {{ old('how_know_us') == ucfirst(trans('module_buys.how_know_us.instagram')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="gridRadios2">
                        {{ ucfirst(trans('module_buys.how_know_us.instagram')) }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios3" value="{{ ucfirst(trans('module_buys.how_know_us.recommendation')) }}" {{ old('how_know_us') == ucfirst(trans('module_buys.how_know_us.recommendation')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="gridRadios3">
                        {{ ucfirst(trans('module_buys.how_know_us.recommendation')) }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios4" value="{{ ucfirst(trans('module_buys.how_know_us.site_web')) }}" {{ old('how_know_us') == ucfirst(trans('module_buys.how_know_us.site_web')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="gridRadios4">
                        {{ ucfirst(trans('module_buys.how_know_us.site_web')) }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios5" value="{{ ucfirst(trans('module_buys.how_know_us.other')) }}" {{ old('how_know_us') == ucfirst(trans('module_buys.how_know_us.other')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="gridRadios5">
                        {{ ucfirst(trans('module_buys.how_know_us.other')) }}
                    </label>
                </div>
            </div>
            @error('how_know_us')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('how_know_us_other') is-invalid @enderror" id="how_know_us_other" name="how_know_us_other" placeholder="{{ ucfirst(trans('validation.attributes.how_know_us_other')) }}" value="{{ old('how_know_us_other') }}">
            @error('how_know_us_other')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <hr>
        <input type="hidden" value="slug" id="slug" name="slug">
        <input type="hidden" value="1" id="status_id" name="status_id">
        <input type="submit" class="btn btn-primary btn-user btn-block" value="{{ ucfirst(trans('crud.buy.submit')) }}">
    </form>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function(){
            $("#datepicker").datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: "dd/mm/yy",
                minDate: 0
            });
        });
    </script>
@endsection