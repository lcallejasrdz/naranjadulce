@extends('admin.layouts.sbadmin')

@section('title', '| '.$word)

@section('styles')
@endsection

@section('page-header', $word)

@section('panel-heading')
    <i class="fa fa-file-alt fa-fw"></i> {{ trans('crud.read.title') }}
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tbody>
                        @foreach($item as $column => $value)
                            @if($column != 'status_id' && $column != 'slug' && $value != '')
                                @if($column == 'id' && $active != 'products' && $active != 'packages')
                                    <tr>
                                        <th colspan="2" class="text-center">{{ ucfirst(trans('module_buys.sidebar.route_title_singular')) }}</th>
                                    </tr>
                                @elseif($active == 'sales' && $column == 'quantity')
                                    <tr>
                                        <th colspan="2" class="text-center">{{ ucfirst(trans('module_sales.controller.word')) }}</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th>
                                        {{ ucfirst(trans('validation.attributes.'.$column)) }}
                                    </th>
                                    <td>
                                        @if($column == 'proof_of_payment')
                                            <i class="fa fa-download"></i>{!! link_to($value, ' Download File', ['target' => '_blank']) !!}
                                        @elseif($column == 'delivery_date')
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
            </div>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('scripts')
@endsection