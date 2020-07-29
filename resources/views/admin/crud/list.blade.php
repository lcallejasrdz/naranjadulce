@extends('admin.layouts.sbadmin')

@section('title', '| '.$word)

@section('styles')
@endsection

@section('page-header', $word)

@section('panel-heading')
    @if($active == 'sales')
        @if($view == 'finished')
            <i class="fa fa-list fa-fw"></i> {{ trans('module_'.$active.'.sidebar.finished') }}
        @else
            <i class="fa fa-list fa-fw"></i> {{ trans('module_'.$active.'.sidebar.title') }}
        @endif
    @else
        <i class="fa fa-list fa-fw"></i> {{ trans('crud.sidebar.list') }}
    @endif
@endsection

@section('content')
    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-body">
            {{ Form::token() }}
            @include('admin.modules.datatable')
        </div>
    </div>
@endsection

@section('modals')
    @if($view == 'users' || $view == 'products')
        @include('admin.layouts.modals.delete_modal')
        @include('admin.layouts.modals.restore_modal')
    @endif
@endsection

@section('scripts')
    {{-- DataTables --}}
    @include('plugins.datatables.dataTables')
@endsection