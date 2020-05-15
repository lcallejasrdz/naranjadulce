@extends('admin.layouts.sbadmin_front')

@section('title', '| '.$word)

@section('styles')
@endsection

@section('page-image')
    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
@endsection

@section('panel-heading')
    <h1 class="h4 text-gray-900 mb-4">{{ trans('crud.buy.title') }}</h1>
@endsection

@section('content')
    <form class="user" method="post" action="{{ route($active.'.store') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ ucfirst(trans('validation.attributes.email')) }}">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="{{ ucfirst(trans('validation.attributes.first_name')) }}">
                @error('first_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="{{ ucfirst(trans('validation.attributes.last_name')) }}">
                @error('last_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="{{ ucfirst(trans('validation.attributes.phone')) }}">
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" placeholder="{{ ucfirst(trans('validation.attributes.postal_code')) }}">
                @error('postal_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('state') is-invalid @enderror" id="state" name="state" placeholder="{{ ucfirst(trans('validation.attributes.state')) }}">
                @error('state')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('municipality') is-invalid @enderror" id="municipality" name="municipality" placeholder="{{ ucfirst(trans('validation.attributes.municipality')) }}">
                @error('municipality')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('colony') is-invalid @enderror" id="colony" name="colony" placeholder="{{ ucfirst(trans('validation.attributes.colony')) }}">
                @error('colony')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('street') is-invalid @enderror" id="street" name="street" placeholder="{{ ucfirst(trans('validation.attributes.street')) }}">
                @error('street')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('no_ext') is-invalid @enderror" id="no_ext" name="no_ext" placeholder="{{ ucfirst(trans('validation.attributes.no_ext')) }}">
                @error('no_ext')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user @error('no_int') is-invalid @enderror" id="no_int" name="no_int" placeholder="{{ ucfirst(trans('validation.attributes.no_int')) }}">
                @error('no_int')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <hr>
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('package') is-invalid @enderror" id="package" name="package" placeholder="{{ ucfirst(trans('validation.attributes.package')) }}">
            @error('package')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <textarea class="form-control form-control-user @error('modifications') is-invalid @enderror" id="modifications" name="modifications" placeholder="{{ ucfirst(trans('validation.attributes.modifications')) }}"></textarea>
            @error('modifications')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <textarea class="form-control form-control-user @error('buy_message') is-invalid @enderror" id="buy_message" name="buy_message" placeholder="{{ ucfirst(trans('validation.attributes.buy_message')) }}"></textarea>
            @error('buy_message')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" placeholder="{{ ucfirst(trans('validation.attributes.delivery_date')) }}">
                @error('delivery_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <select class="form-control @error('delivery_schedule') is-invalid @enderror" id="delivery_schedule" name="delivery_schedule">
                    <option selected disabled>{{ ucfirst(trans('validation.attributes.delivery_schedule')) }}</option>
                    <option value="{{ ucfirst(trans('module_buys.delivery_schedule.early')) }}">{{ ucfirst(trans('module_buys.delivery_schedule.early')) }}</option>
                    <option value="{{ ucfirst(trans('module_buys.delivery_schedule.late')) }}">{{ ucfirst(trans('module_buys.delivery_schedule.late')) }}</option>
                </select>
                @error('delivery_schedule')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <hr>
        <div class="form-group">
            <legend class="col-form-label">{{ ucfirst(trans('validation.attributes.how_know_us')) }}</legend>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios1" value="{{ ucfirst(trans('module_buys.how_know_us.facebook')) }}" checked>
                    <label class="form-check-label" for="gridRadios1">
                        {{ ucfirst(trans('module_buys.how_know_us.facebook')) }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios2" value="{{ ucfirst(trans('module_buys.how_know_us.instagram')) }}">
                    <label class="form-check-label" for="gridRadios2">
                        {{ ucfirst(trans('module_buys.how_know_us.instagram')) }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios3" value="{{ ucfirst(trans('module_buys.how_know_us.recommendation')) }}">
                    <label class="form-check-label" for="gridRadios3">
                        {{ ucfirst(trans('module_buys.how_know_us.recommendation')) }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios4" value="{{ ucfirst(trans('module_buys.how_know_us.site_web')) }}">
                    <label class="form-check-label" for="gridRadios4">
                        {{ ucfirst(trans('module_buys.how_know_us.site_web')) }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="how_know_us" id="gridRadios5" value="{{ ucfirst(trans('module_buys.how_know_us.other')) }}">
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
            <input type="text" class="form-control form-control-user @error('how_know_us_other') is-invalid @enderror" id="how_know_us_other" name="how_know_us_other" placeholder="{{ ucfirst(trans('validation.attributes.how_know_us_other')) }}">
            @error('how_know_us_other')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <input type="hidden" value="slug" id="slug" name="slug">
        <input type="submit" class="btn btn-primary btn-user btn-block" value="{{ ucfirst(trans('crud.buy.submit')) }}">
    </form>
@endsection

@section('scripts')
@endsection