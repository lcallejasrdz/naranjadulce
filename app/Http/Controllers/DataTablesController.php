<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use DB;
use Sentinel;

class DataTablesController extends Controller
{
    public function data(Request $request){
        if(\App::getLocale() == 'es'){
            $language = 'es';
        }else{
            $language = 'en';
        }
        Carbon::setLocale($language);
        $active = $request->active;
        $model = $request->model;
        $view = $request->view;
        $actions_value = $request->actions;
        if($view == 'index'){
            $full_model = 'App\\View'.$request->model;
            $rows = $full_model::data();
        }else if($view == 'sales'){
            $full_model = 'App\\NDSaleListView';
            $rows = $full_model::get();
        }else if($view == 'finances'){
            $full_model = 'App\\NDFinanceListView';
            $rows = $full_model::get();
        }else if($view == 'financefinished'){
            $full_model = 'App\\View'.$request->model;
            $rows = $full_model::where('status_id', 'En producción')
                                    ->orWhere('status_id', 'Pendiente de envío')
                                    ->orWhere('status_id', 'En ruta')
                                    ->orWhere('status_id', 'Entregado')
                                    ->data();
        }else if($view == 'buildings'){
            $full_model = 'App\\NDBuildingListView';
            $rows = $full_model::get();
        }else if($view == 'buildingfinished'){
            $full_model = 'App\\View'.$request->model;
            $rows = $full_model::where('status_id', 'Pendiente de pago')
                                    ->orWhere('status_id', 'Pendiente de envío')
                                    ->orWhere('status_id', 'En ruta')
                                    ->orWhere('status_id', 'Entregado')
                                    ->data();
        }else if($view == 'shippings'){
            $full_model = 'App\\NDShippingListView';
            $rows = $full_model::get();
        }else if($view == 'shippingfinished'){
            $full_model = 'App\\View'.$request->model;
            $rows = $full_model::where('status_id', 'En ruta')
                                    ->orWhere('status_id', 'Entregado')
                                    ->data();
        }else if($view == 'deliveries'){
            $full_model = 'App\\NDDeliveryListView';
            $rows = $full_model::get();
        }else if($view == 'deliveryfinished'){
            $full_model = 'App\\View'.$request->model;
            $rows = $full_model::where('status_id', 'Entregado')
                                    ->data();
        }else if($view == 'finished'){
            $full_model = 'App\\View'.$request->model;
            $rows = $full_model::where('status_id', 'Entregado')
                                    ->data();
        }else{
            $full_model = 'App\\ViewDeleted'.$request->model;
            $rows = $full_model::data();
        }

        return Datatables::of($rows)
            ->editColumn('created_at', '{!! \Carbon\Carbon::parse($created_at)->diffForHumans() !!}')
            ->addColumn('actions', function($row) use ($active, $view, $actions_value){
                if($view == 'index'){
                    // 1 = (show, edit, delete)
                    // 2 = (show, edit)
                    // 3 = (show, delete)
                    // 4 = (edit, delete)
                    // 5 = (show)
                    // 6 = (edit)
                    // 7 = (delete)
                    $actions = '';
                    if($actions_value == 1){
                        $actions .= ' <a href="'. route($active.'.show', $row->slug) .'" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-info-circle"></i></a>';
                    }
                    if($actions_value == 1){
                        $actions .= ' <a href="'. route($active.'.edit', $row->id) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                    }
                    if($actions_value == 1){
                        $actions .= ' <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#deleteModal" onClick="deleteModal('.$row->id.')"><i class="fas fa-trash"></i></a>';
                    }
                }else if($view == 'sales'){
                    $actions = '';
                    if($row->status_id != 1 && $row->status_id != 8){
                        $actions .= ' <a href="'. route($active.'.show', $row->slug) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                    }else{
                        $actions .= ' <a href="'. route($active.'.create', $row->slug) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                    }
                    if(Sentinel::getUser()->role_id == 1 && ($row->status_id == 1 || $row->status_id == 8)){
                        $actions .= ' <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#deleteModal" onClick="deleteModal('.$row->id.')"><i class="fas fa-minus-circle"></i></a>';
                    }
                }else if($view == 'finances'){
                    $actions = '';
                    $actions .= ' <a href="'. route($active.'.create', $row->slug) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                }else if($view == 'buildings'){
                    $actions = '';
                    if($row->status_id != 3){
                        $actions .= ' <a href="'. route($active.'.show', $row->slug) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                    }else{
                        $actions .= ' <a href="'. route($active.'.create', $row->slug) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                    }
                }else if($view == 'shippings'){
                    $actions = '';
                    if($row->status_id == 5){
                        $actions .= ' <a href="'. route($active.'.create', $row->slug) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                    }
                }else if($view == 'deliveries'){
                    $actions = '';
                    $actions .= ' <a href="'. route($active.'.create', $row->slug) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                }else if($view == 'finished' || $view == 'financefinished' || $view == 'buildingfinished' || $view == 'shippingfinished' || $view == 'deliveryfinished'){
                    $actions = '';
                    if($actions_value == 1 || $actions_value == 2){
                        $actions .= ' <a href="'. route($active.'.show', $row->slug) .'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                    }
                }else{
                	$actions = '';
                    $actions .= ' <a href="#" class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#restoreModal" onClick="restoreModal('.$row->id.')"><i class="fas fa-exclamation-triangle"></i></a>';
                }

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
