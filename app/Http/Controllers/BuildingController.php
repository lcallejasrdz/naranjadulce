<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuildingRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use App\Buy;
use App\Sale;
use DB;

use Redirect;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->middleware('moduleBuildings');
        
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
        $view = 'buildings';

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
        $item = DB::table('buys')
                    ->where('buys.slug', $slug)
                    ->join('sales', 'buys.slug', '=', 'sales.slug')
                    ->select(
                        'buys.id',
                        'buys.slug',
                        'buys.first_name',
                        'buys.last_name',
                        'sales.quantity',
                        'sales.seller_package',
                        'buys.thematic',
                        'sales.seller_modifications',
                        'sales.observations_buildings',
                        'buys.buy_message',
                        'buys.who_sends',
                        'buys.who_receives',
                        'buys.delivery_date',
                        'sales.delivery_type',
                        'buys.delivery_schedule',
                        'sales.preferential_schedule'
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
        $status_back = $buy->status_id;
        if($status_back == 2){
            $buy->status_id = 4;
        }else{
            $buy->status_id = 5;
        }

        if($item->save() && $buy->save()){
            return Redirect::route($this->active)->with('success', trans('crud.building.message.success'));
        }else{
            $item->forceDelete();
            $buy->status_id = $status_back;
            $buy->save();
            return Redirect::back()->with('error', trans('crud.building.message.error'));
        }
    }
}

