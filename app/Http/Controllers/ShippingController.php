<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingRequest as MasterRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use App\Buy;
use App\Sale;
use App\Finance;
use App\Building;
use DB;

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
        $item = DB::table('view_buys')
                    ->where('view_buys.slug', $slug)
                    ->join('view_sales', 'view_buys.slug', '=', 'view_sales.slug')
                    ->select(
                        'view_buys.id',
                        'view_buys.slug',
                        'view_buys.first_name',
                        'view_buys.last_name',
                        'view_buys.phone',
                        'view_sales.quantity',
                        'view_sales.seller_package',
                        'view_buys.thematic',
                        'view_sales.seller_modifications',
                        'view_buys.buy_message',
                        'view_buys.who_sends',
                        'view_buys.who_receives',
                        'view_sales.delivery_type',
                        'view_buys.delivery_date',
                        'view_buys.schedule_id',
                        'view_sales.preferential_schedule',
                        'view_buys.postal_code',
                        'view_buys.state',
                        'view_buys.municipality',
                        'view_buys.colony',
                        'view_buys.street',
                        'view_buys.no_ext',
                        'view_buys.no_int',
                        'view_buys.address_references',
                        'view_buys.address_type',
                        'view_buys.parking',
                        'view_sales.observations_shippings',
                        'view_sales.shipping_cost',
                        'view_buys.status_id'
                    )
                    ->first();

        return view('admin.crud.form', compact($this->compact));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterRequest $request)
    {
        $item = $this->full_model::create($request->only($this->create_fields));

        $buy = Buy::where('slug', $item->slug)->first();
        $buy->delivery_man = $request->delivery_man;
        $buy->status_id = 6;

        if($item->save() && $buy->save()){
            return Redirect::route($this->active)->with('success', trans('crud.shipping.message.success'));
        }else{
            $item->forceDelete();
            $buy->status_id = 5;
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
        $buy = Buy::where('slug', $request->slug)->first();
        $status_back = $buy->status_id;

        // Aquí guardaría la información en el campo nuevo.
        $buy->return_reason = $request->return_reason;
        // también agregaría el nuevo estatus. 8 Verificar.
        $buy->status_id = 8;

        if($buy->save()){
            // Aquí eliminaría el registro de venta, incluído el archivo.
            $sale = Sale::where('slug', $request->slug)->first();
            
            $sale->observations_shippings = null;
            $sale->delivery_type = null;
            $sale->preferential_schedule = null;
            
            if($sale->save()){
                return Redirect::route($this->active)->with('success', trans('crud.building.message.returned'));
            }else{
                $buy->return_reason = '';
                $buy->status_id = $status_back;
                $buy->save();
                return Redirect::back()->with('error', trans('crud.building.message.error_returned'));
            }
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

        $item = DB::table('view_buys')
                    ->where('view_buys.slug', $slug)
                    ->join('view_sales', 'view_buys.slug', '=', 'view_sales.slug')
                    ->select(
                        'view_buys.id',
                        'view_buys.first_name',
                        'view_buys.last_name',
                        'view_buys.phone',
                        'view_sales.quantity',
                        'view_sales.seller_package',
                        'view_buys.thematic',
                        'view_sales.seller_modifications',
                        'view_buys.buy_message',
                        'view_buys.who_sends',
                        'view_buys.who_receives',
                        'view_sales.delivery_type',
                        'view_buys.delivery_date',
                        'view_buys.schedule_id',
                        'view_sales.preferential_schedule',
                        'view_buys.postal_code',
                        'view_buys.state',
                        'view_buys.municipality',
                        'view_buys.colony',
                        'view_buys.street',
                        'view_buys.no_ext',
                        'view_buys.no_int',
                        'view_buys.address_references',
                        'view_buys.address_type',
                        'view_buys.parking',
                        'view_sales.observations_shippings',
                        'view_sales.shipping_cost',
                        'view_buys.delivery_man',
                        'view_buys.status_id'
                    )
                    ->first();

        return view('admin.crud.show', compact($this->compact));
    }
}

