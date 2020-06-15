<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinanceRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use App\Buy;
use App\ViewBuy;
use App\Sale;
use DB;

use Redirect;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('moduleFinances');
        
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
        $view = 'finances';

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
                        'view_sales.quantity',
                        'view_sales.seller_package',
                        'view_sales.seller_modifications',
                        'view_sales.observations_finances',
                        'view_sales.shipping_cost',
                        'view_sales.proof_of_payment',
                        'view_buys.delivery_date',
                        'view_buys.schedule_id',
                        'view_sales.preferential_schedule'
                    )
                    ->first();
        $proof_of_payment = $item->proof_of_payment;

        return view('admin.crud.form', compact($this->compact, 'proof_of_payment'));
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
        $status_back = $buy->status_id;
        if($status_back == 2){
            $buy->status_id = 3;
        }else{
            $buy->status_id = 5;
        }

        if($item->save() && $buy->save()){
            return Redirect::route($this->active)->with('success', trans('crud.finance.message.success'));
        }else{
            $item->forceDelete();
            $buy->status_id = $status_back;
            $buy->save();
            return Redirect::back()->with('error', trans('crud.finance.message.error'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finished()
    {
        $view = 'financefinished';

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
                        'view_sales.quantity',
                        'view_sales.seller_package',
                        'view_sales.seller_modifications',
                        'view_sales.observations_finances',
                        'view_sales.shipping_cost',
                        'view_sales.proof_of_payment',
                        'view_buys.delivery_date',
                        'view_buys.schedule_id',
                        'view_sales.preferential_schedule'
                    )
                    ->first();

        return view('admin.crud.show', compact($this->compact));
    }
}

