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
            @isset($sale)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            @foreach($sale as $column => $value)
                                @if($value != '')
                                    <tr>
                                        <th>
                                            {{ ucfirst(trans('validation.attributes.'.$column)) }}
                                        </th>
                                        <td>
                                            @if(($column == 'last_login' && $value != "") || ($column == 'created_at' && $value != "") || ($column == 'updated_at' && $value != "") || ($column == 'deleted_at' && $value != ""))
                                                {{ \Carbon\Carbon::parse($value)->diffForHumans() }}
                                            @elseif($column == 'proof_of_payment')
                                                <i class="fa fa-download"></i>{!! link_to($value, ' Download File', ['target' => '_blank']) !!}
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
                <hr>
            @endisset
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tbody>
                        @if(isset($item->preferential_schedule) && $item->preferential_schedule != '')
                            @php $schedule = 1; @endphp
                        @else
                            @php $schedule = 0; @endphp
                        @endif
                        @foreach($item as $column => $value)
                            @if($column == 'schedule_id')
                                @if($schedule == 0)
                                    <tr>
                                        <th>
                                            {{ ucfirst(trans('validation.attributes.'.$column)) }}
                                        </th>
                                        <td>
                                            {{ $value }}
                                        </td>
                                    </tr>
                                @endif
                            @elseif($column == 'preferential_schedule')
                                @if($schedule == 1)
                                    <tr>
                                        <th>
                                            {{ ucfirst(trans('validation.attributes.'.$column)) }}
                                        </th>
                                        <td>
                                            {{ $value }}
                                        </td>
                                    </tr>
                                @endif
                            @elseif($value != '')
                                <tr>
                                    <th>
                                        {{ ucfirst(trans('validation.attributes.'.$column)) }}
                                    </th>
                                    <td>
                                        @if(($column == 'last_login' && $value != "") || ($column == 'created_at' && $value != "") || ($column == 'updated_at' && $value != "") || ($column == 'deleted_at' && $value != ""))
                                            {{ \Carbon\Carbon::parse($value)->diffForHumans() }}
                                        @elseif($column == 'proof_of_payment')
                                            <i class="fa fa-download"></i>{!! link_to($value, ' Download File', ['target' => '_blank']) !!}
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