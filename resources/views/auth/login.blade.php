@extends('admin.layouts.sbadmin_front')

@section('title', '| '.$word)

@section('styles')
@endsection

@section('page-image')
    <div class="col-lg-5 d-none d-lg-block bg-login-image"></div>
@endsection

@section('panel-heading')
    <h1 class="h4 text-gray-900 mb-4">{{ trans('auth.title') }}</h1>
@endsection

@section('content')
    <form class="user" method="POST" action="{{ route('auth.store') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ ucfirst(trans('validation.attributes.email')) }}">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password" placeholder="{{ ucfirst(trans('validation.attributes.password')) }}">
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <input type="submit" class="btn btn-primary btn-user btn-block" value="{{ ucfirst(trans('auth.submit')) }}">
    </form>
@endsection

@section('scripts')
@endsection