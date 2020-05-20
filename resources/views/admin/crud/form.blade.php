@extends('admin.layouts.sbadmin')

@section('title', '| '.$word)

@section('styles')
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
                <input type="submit" class="btn {{ (isset($item) ? 'btn-success' : 'btn-primary') }}" value="{{ (isset($item) ? trans('crud.update.update') : trans('crud.create.add'))  }}">
            </form>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('scripts')
@endsection