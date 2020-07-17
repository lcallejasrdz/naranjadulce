<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\NDBuy;
use App\NDShipping;
use App\NDShippingConfirmView;
use App\NDShippingDetailView;
use App\NDReturnReason;

use Redirect;

class ShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('moduleShippings');
        
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
        $view = 'shippings';

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
        $item = NDShippingConfirmView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'first_name',
                    'last_name',
                    'phone',
                    'quantity',
                    'package',
                    'nd_themathics_id',
                    'modifications',
                    'dedication',
                    'who_sends',
                    'who_receives',
                    'nd_delivery_types_id',
                    'delivery_date',
                    'nd_delivery_schedules_id',
                    'preferential_schedule',
                    'postal_code',
                    'state',
                    'municipality',
                    'colony',
                    'street',
                    'no_ext',
                    'no_int',
                    'address_references',
                    'nd_address_types_id',
                    'nd_parkings_id',
                    'observations_shippings',
                    'delivery_price',
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

        NDShipping::create([
            'nd_buys_id' => $request->nd_buys_id,
            'delivery_man' => $request->delivery_man,
        ]);

        $buy->nd_status_id = 6;

        if(NDShipping::where('nd_buys_id', $request->nd_buys_id)->count() > 0 && $buy->save()){
            return Redirect::route($this->active)->with('success', trans('crud.shipping.message.success'));
        }else{
            NDShipping::destroy(NDShipping::where('nd_buys_id', $request->nd_buys_id)->first()->id);

            $buy->status_id = $status_back;
            $buy->save();

            return Redirect::back()->with('error', trans('crud.shipping.message.error'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function return(MasterRequest $request)
    {
        $buy = NDBuy::find($request->nd_buys_id);
        $status_back = $buy->nd_status_id;

        NDReturnReason::create([
            'nd_buys_id' => $request->nd_buys_id,
            'module' => 'shippings',
            'reason' => $request->return_reason,
        ]);

        $buy->nd_status_id = 8;

        if(NDReturnReason::where('nd_buys_id', $request->nd_buys_id)->count() > 0 && $buy->save()){
            return Redirect::route($this->active)->with('success', trans('crud.building.message.returned'));
        }else{
            return Redirect::back()->with('error', trans('crud.building.message.error_returned'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finished()
    {
        $view = 'shippingfinished';

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
        $item = NDShippingDetailView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'first_name',
                    'last_name',
                    'phone',
                    'quantity',
                    'package',
                    'nd_themathics_id',
                    'modifications',
                    'dedication',
                    'who_sends',
                    'who_receives',
                    'nd_delivery_types_id',
                    'delivery_date',
                    'nd_delivery_schedules_id',
                    'preferential_schedule',
                    'postal_code',
                    'state',
                    'municipality',
                    'colony',
                    'street',
                    'no_ext',
                    'no_int',
                    'address_references',
                    'nd_address_types_id',
                    'nd_parkings_id',
                    'observations_shippings',
                    'delivery_price',
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

