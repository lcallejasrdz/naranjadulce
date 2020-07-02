<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest as MasterRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use App\ViewBuy;
use App\ViewSale;
use App\Building;
use App\Finance;
use App\Sale;
use App\Buy;

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
                    'phone',
                    'package',
                    'thematic',
                    'modifications',
                    'buy_message',
                    'delivery_date',
                    'delivery_schedule',
                    'schedule_id',
                    'observations',
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
                    'how_know_us_other',
                    'return_reason',
                    'status_id'
                )
                ->first();
        $buy = $item ? $item->toArray() : array();
        $item = null;
        
        if($buy['status_id'] == 'Verificar'){
            $sale = Sale::where('slug', $slug)
                    ->first(); 
        }else{
            $sale = Sale::where('slug', $slug)
                    ->select(
                        'quantity'
                    )
                    ->first();
        }
        $sale = $sale ? $sale->toArray() : array();

        return view('admin.crud.form', compact($this->compact, 'buy', 'sale'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterRequest $request)
    {
        if(Sale::where('slug', $request->slug)->count() == 0){
            $path = Storage::putFileAs(
                'receipts',
                $request->file('proof_of_payment'),
                $request->slug.'.'.$request->file('proof_of_payment')->extension()
            );

            $item = $this->full_model::create($request->only($this->create_fields));

            $item->proof_of_payment = $path;
        }else{
            $item = Sale::where('slug', $request->slug)->first();

            if($item->proof_of_payment == '' || $item->proof_of_payment == null){
                $path = Storage::putFileAs(
                    'receipts',
                    $request->file('proof_of_payment'),
                    $request->slug.'.'.$request->file('proof_of_payment')->extension()
                );

                $item->proof_of_payment = $path;
            }

            $item->user_id = $request->user_id;
            $item->quantity = $request->quantity;
            $item->seller_package = $request->seller_package;
            $item->seller_modifications = $request->seller_modifications;
            $item->delivery_type = $request->delivery_type;
            $item->preferential_schedule = $request->preferential_schedule;
            $item->observations_finances = $request->observations_finances;
            $item->observations_buildings = $request->observations_buildings;
            $item->observations_shippings = $request->observations_shippings;
            $item->shipping_cost = $request->shipping_cost;
        }

        $buy = Buy::where('slug', $item->slug)->first();

        if(Finance::where('slug', $request->slug)->count() == 0){
            $buy->status_id = 4;
        }else if(Building::where('slug', $request->slug)->count() == 0){
            $buy->status_id = 3;
        }else{
            $buy->status_id = 5;
        }

        if($item->save() && $buy->save()){
            return Redirect::route($this->active)->with('success', trans('crud.sale.message.success'));
        }else{
            $item->forceDelete();
            Storage::delete($path);

            $buy->status_id = 1;
            $buy->save();

            return Redirect::back()->with('error', trans('crud.sale.message.error'));
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
                    'thematic',
                    'modifications',
                    'buy_message',
                    'delivery_date',
                    'schedule_id',
                    'observations',
                    'how_know_us',
                    'how_know_us_other',
                    'return_reason',
                    'delivery_man',
                    'status_id',
                    'created_at'
                )
                ->first();
        $item = $item ? $item->toArray() : array();
        
        $sale = Sale::where('slug', $slug)
                ->select(
                    'quantity',
                    'seller_package',
                    'seller_modifications',
                    'delivery_type',
                    'preferential_schedule',
                    'seller_observations',
                    'observations_finances',
                    'observations_buildings',
                    'observations_shippings',
                    'shipping_cost',
                    'proof_of_payment',
                    'created_at'
                )
                ->first();
        $sale = $sale ? $sale->toArray() : array();

        return view('admin.crud.show', compact($this->compact, 'sale'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Buy::destroy($request->id)){
            return Redirect::route($this->active)->with('success', trans('crud.delete.message.success'));
        }else{
            return Redirect::back()->with('danger', trans('crud.delete.message.error'));
        }
    }
}

