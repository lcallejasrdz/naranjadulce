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
                
                @if($active == 'users')
                    <input type="submit" class="btn {{ (isset($item) ? 'btn-success' : 'btn-primary') }}" value="{{ (isset($item) ? trans('crud.update.update') : trans('crud.create.add'))  }}">
                @elseif($active == 'sales' && ($buy['status_id'] == 'Por confirmar' || $buy['status_id'] == 'Verificar'))
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.sale.submit') }}">
                @elseif($active == 'finances')
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.finance.submit') }}">
                @elseif($active == 'buildings')
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.building.submit') }}">
                    <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#returnModal">{{ trans('crud.building.return') }}</a>
                @elseif($active == 'shippings' && $item->status_id == 5)
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.shipping.submit') }}">
                @elseif($active == 'deliveries')
                    <input type="submit" class="btn btn-primary" value="{{ trans('crud.delivery.submit') }}">
                @endif
            </form>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('scripts')
@endsection