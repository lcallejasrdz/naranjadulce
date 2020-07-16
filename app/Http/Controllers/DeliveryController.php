<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\NDBuy;
use App\NDDelivery;
use App\NDDeliveryConfirmView;
use App\NDDeliveryDetailView;

use Redirect;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('moduleDeliveries');
        
        // General
        $this->active = explode('.',\Request::route()->getName())[0];
        $this->word = trans('module_'.$this->active.'.controller.word');
        $this->model = trans('module_'.$this->active.'.controller.model');
        $this->create_fields = trans('module_'.$this->active.'.controller.create_fields');
        $this->full_model = 'App\\'.$this->model;

        // Index
        $this->select = trans('module_'.$this->active.'.controller.select');
        $this->columns = Arr::add($this->select, count($this->select), 'actions');
        // 1 = (show, edit, delete)
        // 2 = (show, edit)
        // 3 = (show, delete)
        // 4 = (edit, delete)
        // 5 = (show)
        // 6 = (edit)
        // 7 = (delete)
        $this->actions = 1;

        // Create
        $this->create_word = trans('module_'.$this->active.'.controller.create_word');

        // Final compact
        $this->compact = ['view', 'active', 'word', 'model', 'select', 'columns', 'actions', 'item'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'deliveries';

        $active = $this->active;
        $word = $this->word;
        $model = trans('module_buys.controller.model');
        $select = $this->select;
        $columns = $this->columns;
        $actions = $this->actions;
        $item = null;

        return view('admin.crud.list', compact($this->compact));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $view = 'create';

        $active = $this->active;
        $word = $this->create_word;
        $model = null;
        $select = null;
        $columns = null;
        $actions = null;
        $item = NDDeliveryConfirmView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'first_name',
                    'last_name',
                    'phone',
                    'nd_delivery_types_id',
                    'delivery_date',
                    'nd_delivery_schedules_id',
                    'preferential_schedule',
                    'delivery_man',
                    'status_id',
                    'nd_status_id',
                )
                ->first();
        if($item->preferential_schedule != '' && $item->preferential_schedule != null){
            $item->nd_delivery_schedules_id = '';
        }
        $buy = $item ? $item->toArray() : array();

        return view('admin.crud.form', compact($this->compact, 'buy'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterRequest $request)
    {
        $buy = NDBuy::find($request->nd_buys_id);
        $status_back = $buy->nd_status_id;

        NDDelivery::create([
            'nd_buys_id' => $request->nd_buys_id,
        ]);

        $buy->nd_status_id = 7;

        if(NDDelivery::where('nd_buys_id', $request->nd_buys_id)->count() > 0 && $buy->save()){
            return Redirect::route($this->active)->with('success', trans('crud.delivery.message.success'));
        }else{
            NDDelivery::destroy(NDDelivery::where('nd_buys_id', $request->nd_buys_id)->first()->id);

            $buy->status_id = $status_back;
            $buy->save();

            return Redirect::back()->with('error', trans('crud.delivery.message.error'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finished()
    {
        $view = 'deliveryfinished';

        $active = $this->active;
        $word = $this->word;
        $model = trans('module_buys.controller.model');
        $select = $this->select;
        $columns = $this->columns;
        $actions = $this->actions;
        $item = null;

        return view('admin.crud.list', compact($this->compact));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $view = 'show';

        $active = $this->active;
        $word = $this->word;
        $model = null;
        $select = null;
        $columns = null;
        $actions = null;
        $item = NDDeliveryDetailView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'first_name',
                    'last_name',
                    'phone',
                    'nd_delivery_types_id',
                    'delivery_date',
                    'nd_delivery_schedules_id',
                    'preferential_schedule',
                    'delivery_man',
                    'status_id',
                    'nd_status_id',
                )
                ->first();
        if($item->preferential_schedule != '' && $item->preferential_schedule != null){
            $item->nd_delivery_schedules_id = '';
        }
        $item = $item ? $item->toArray() : array();

        return view('admin.crud.show', compact($this->compact));
    }
}

