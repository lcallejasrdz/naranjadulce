<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinanceRequest as MasterRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\NDBuy;
use App\NDSale;
use App\NDFinance;
use App\NDFinanceConfirmView;
use App\NDFinanceDetailView;
use App\NDReturnReason;

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
        $item = NDFinanceConfirmView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'first_name',
                    'last_name',
                    'quantity',
                    'package',
                    'nd_themathics_id',
                    'modifications',
                    'observations_finances',
                    'delivery_price',
                    'delivery_date',
                    'nd_delivery_schedules_id',
                    'preferential_schedule',
                    'proof_of_payment',
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

        NDFinance::create([
            'nd_buys_id' => $request->nd_buys_id,
        ]);

        $buy->nd_status_id = 3;

        if(NDFinance::where('nd_buys_id', $request->nd_buys_id)->count() > 0 && $buy->save()){
            return Redirect::route($this->active)->with('success', trans('crud.finance.message.success'));
        }else{
            NDFinance::destroy(NDFinance::where('nd_buys_id', $request->nd_buys_id)->first()->id);

            $buy->nd_status_id = $status_back;
            $buy->save();

            return Redirect::back()->with('error', trans('crud.finance.message.error'));
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
            'module' => 'finances',
            'reason' => $request->return_reason,
        ]);

        $buy->nd_status_id = 8;

        if(NDReturnReason::where('nd_buys_id', $request->nd_buys_id)->count() > 0 && $buy->save()){
            $sale = NDSale::where('nd_buys_id', $request->nd_buys_id)->first();
            
            if(Storage::delete($sale->proof_of_payment)){
                return Redirect::route($this->active)->with('success', trans('crud.building.message.returned'));
            }else{
                NDReturnReason::destroy(NDReturnReason::where('nd_buys_id', $request->nd_buys_id)->first()->id);

                $buy->nd_status_id = $status_back;
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
        
        $item = NDFinanceDetailView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'first_name',
                    'last_name',
                    'quantity',
                    'package',
                    'nd_themathics_id',
                    'modifications',
                    'observations_finances',
                    'delivery_price',
                    'delivery_date',
                    'nd_delivery_schedules_id',
                    'preferential_schedule',
                    'proof_of_payment',
                    'delivery_man',
                )
                ->first();
        if($item->preferential_schedule != '' && $item->preferential_schedule != null){
            $item->nd_delivery_schedules_id = '';
        }
        $item = $item ? $item->toArray() : array();

        return view('admin.crud.show', compact($this->compact));
    }
}

