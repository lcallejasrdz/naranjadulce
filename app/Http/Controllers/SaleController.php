<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest as MasterRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use App\ViewBuy;
use App\ViewSale;
use App\Sale;

use Redirect;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('moduleSales');
        
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
        $view = 'sales';

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
        $item = ViewBuy::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'first_name',
                    'last_name',
                    'package',
                    'modifications',
                    'buy_message',
                    'delivery_date',
                    'delivery_schedule',
                    'who_sends',
                    'who_receives',
                    'postal_code',
                    'state',
                    'municipality',
                    'colony',
                    'street',
                    'no_ext',
                    'no_int',
                    'how_know_us',
                    'how_know_us_other'
                )
                ->first();
        $buy = $item ? $item->toArray() : array();
        $item = null;

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
        $path = Storage::putFileAs(
            'receipts',
            $request->file('proof_of_payment'),
            $request->slug.'.'.$request->file('proof_of_payment')->extension()
        );

        $item = $this->full_model::create($request->only($this->create_fields));

        $item->proof_of_payment = $path;

        if($item->save()){
            return Redirect::route($this->active)->with('success', trans('crud.create.message.success'));
        }else{
            $item->forceDelete();
            Storage::delete($path);
            return Redirect::back()->with('error', trans('crud.create.message.error'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finished()
    {
        $view = 'finished';

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
        
        $item = ViewBuy::where('slug', $slug)
                ->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'postal_code',
                    'state',
                    'municipality',
                    'colony',
                    'street',
                    'no_ext',
                    'no_int',
                    'address_type',
                    'address_references',
                    'parking',
                    'who_sends',
                    'who_receives',
                    'package',
                    'modifications',
                    'buy_message',
                    'delivery_date',
                    'delivery_schedule',
                    'observations',
                    'how_know_us',
                    'how_know_us_other',
                    'created_at'
                )
                ->first();
        $item = $item ? $item->toArray() : array();
        
        $sale = Sale::where('slug', $slug)
                ->select(
                    'user_id',
                    'quantity',
                    'seller_package',
                    'seller_modifications',
                    'delivery_type',
                    'preferential_schedule',
                    'seller_observations',
                    'shipping_cost',
                    'proof_of_payment',
                    'created_at'
                )
                ->first();
        $sale = $sale ? $sale->toArray() : array();

        return view('admin.crud.show', compact($this->compact, 'sale'));
    }
}

