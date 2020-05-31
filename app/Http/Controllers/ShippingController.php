<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingRequest as MasterRequest;
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
        $item = DB::table('buys')
                    ->where('buys.slug', $slug)
                    ->join('sales', 'buys.slug', '=', 'sales.slug')
                    ->select(
                        'buys.id',
                        'buys.slug',
                        'buys.email',
                        'buys.first_name',
                        'buys.last_name',
                        'buys.phone',
                        'buys.postal_code',
                        'buys.state',
                        'buys.municipality',
                        'buys.colony',
                        'buys.street',
                        'buys.no_ext',
                        'buys.no_int',
                        'buys.address_references',
                        'buys.address_type',
                        'buys.parking',
                        'sales.seller_package',
                        'sales.seller_modifications',
                        'sales.delivery_type',
                        'buys.buy_message',
                        'buys.who_sends',
                        'buys.who_receives',
                        'buys.delivery_date',
                        'buys.delivery_schedule',
                        'buys.observations',
                        'buys.how_know_us',
                        'buys.how_know_us_other'
                    )
                    ->first();
        $buy = [
            'id' => $item->id,
            'slug' => $item->slug,
            'email' => $item->email,
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'phone' => $item->phone,
            'postal_code' => $item->postal_code,
            'state' => $item->state,
            'municipality' => $item->municipality,
            'colony' => $item->colony,
            'street' => $item->street,
            'no_ext' => $item->no_ext,
            'no_int' => $item->no_int,
            'address_references' => $item->address_references,
            'address_type' => $item->address_type,
            'parking' => $item->parking,
            'seller_package' => $item->seller_package,
            'seller_modifications' => $item->seller_modifications,
            'delivery_type' => $item->delivery_type,
            'buy_message' => $item->buy_message,
            'who_sends' => $item->who_sends,
            'who_receives' => $item->who_receives,
            'delivery_date' => $item->delivery_date,
            'delivery_schedule' => $item->delivery_schedule,
            'observations' => $item->observations,
            'how_know_us' => $item->how_know_us,
            'how_know_us_other' => $item->how_know_us_other,
        ];
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
        $item = $this->full_model::create($request->only($this->create_fields));

        $buy = Buy::where('slug', $item->slug)->first();
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
}

