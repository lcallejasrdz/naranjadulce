<?php

namespace App\Http\Controllers;

use App\Http\Requests\CanastaRosaRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use DateTime;
use DateInterval;
use App\NDBuy;
use App\NDBuysOrigin;
use App\NDCustomerForm;
use App\NDDetailBuy;
use App\NDSale;
use App\NDPackageDetail;
use App\NDFinance;
use App\NDSaleDetailView;
use App\NDReturnReason;
use App\NDDeliverySchedule;
use App\NDThemathic;

use Redirect;

class CanastaRosaController extends Controller
{
    public function __construct()
    {
        $this->middleware('moduleCanastaRosa');
        
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
    public function create()
    {
        $view = 'create';

        $active = $this->active;
        $word = $this->create_word;
        $model = null;
        $select = null;
        $columns = null;
        $actions = null;
        $item = null;

        $nd_themathics_id = NDThemathic::get()->pluck('name', 'id');
        $nd_delivery_schedules_id = [];

        $now = new DateTime();
        $current_date = $now->format('d/m/Y');
        $current_time = $now->format('H:i:s');
        $current_day = $now->format('l');

        return view('admin.crud.form', compact($this->compact, 'nd_themathics_id', 'nd_delivery_schedules_id', 'current_date', 'current_time', 'current_day'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterRequest $request)
    {
        if($request->nd_buys_id == 0){
            /* Slug */
            $now = new DateTime();
            $current_date = $now->format('YmdHis');
            $slug = Str::slug($current_date.$request->_token.rand(1000,9999));

            $item = NDBuy::create([
                        'slug' => $slug,
                        'nd_status_id' => 3,
                    ]);

            NDBuysOrigin::create([
                'nd_buys_id' => $item->id,
                'nd_origins_id' => 2,
                'origins_code' => $request->origins_code,
            ]);

            NDCustomerForm::create([
                'nd_buys_id' => $item->id,
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone' => '',
                'postal_code' => '',
                'state' => '',
                'municipality' => '',
                'colony' => '',
                'street' => '',
                'no_ext' => '',
                'no_int' => '',
                'nd_address_types_id' => 1,
                'address_references' => '',
                'nd_parkings_id' => 1,
                'package' => '',
                'nd_themathics_id' => $request->nd_themathics_id,
                'modifications' => '',
                'observations' => '',
                'nd_contact_means_id' => 5,
                'contact_mean_other' => '',
            ]);

            $date = explode('/', $request->delivery_date);
            $delivery_date = new DateTime($date[2].'-'.$date[1].'-'.$date[0]);

            NDDetailBuy::create([
                'nd_buys_id' => $item->id,
                'who_sends' => $request->who_sends,
                'who_receives' => $request->who_receives,
                'dedication' => $request->dedication,
                'delivery_date' => $delivery_date,
                'nd_delivery_schedules_id' => 3,
            ]);

            NDSale::create([
                'nd_buys_id' => $item->id,
                'nd_delivery_types_id' => 2,
                'preferential_schedule' => '',
                'observations_finances' => '',
                'observations_buildings' => $request->observations_buildings,
                'observations_shippings' => '',
                'proof_of_payment' => '',
            ]);

            NDPackageDetail::create([
                'nd_buys_id' => $item->id,
                'quantity' => $request->quantity,
                'package' => $request->package,
                'modifications' => $request->modifications,
                'delivery_price' => 0,
            ]);

            NDFinance::create([
                'nd_buys_id' => $item->id,
            ]);

            if(NDBuy::where('id', $item->id)->count() > 0 && NDBuysOrigin::where('nd_buys_id', $item->id)->count() > 0 && NDCustomerForm::where('nd_buys_id', $item->id)->count() > 0 && NDDetailBuy::where('nd_buys_id', $item->id)->count() > 0 && NDSale::where('nd_buys_id', $item->id)->count() > 0 && NDPackageDetail::where('nd_buys_id', $item->id)->count() > 0 && NDFinance::where('nd_buys_id', $item->id)->count() > 0){
                return Redirect::route('sales')->with('success', trans('crud.canastarosa.message.success'));
            }else{
                NDPackageDetail::destroy(NDPackageDetail::where('nd_buys_id', $item->id)->first()->id);
                NDSale::destroy(NDSale::where('nd_buys_id', $item->id)->first()->id);
                NDDetailBuy::destroy(NDDetailBuy::where('nd_buys_id', $item->id)->first()->id);
                NDCustomerForm::destroy(NDCustomerForm::where('nd_buys_id', $item->id)->first()->id);
                NDBuysOrigin::destroy(NDBuysOrigin::where('nd_buys_id', $item->id)->first()->id);
                NDBuy::destroy($item->id);

                return Redirect::back()->with('error', trans('crud.canastarosa.message.error'));
            }
        }else{
            $buy = NDBuy::find($request->nd_buys_id);
            $sale = NDSale::where('nd_buys_id', $buy->id)->first();
            $item = NDPackageDetail::where('nd_buys_id', $buy->id)->first();

            $item->modifications = $request->modifications;
            $sale->observations_buildings = $request->observations_buildings;
            $buy->nd_status_id = 3;

            if($item->save() && $sale->save() && $buy->save()){
                NDReturnReason::destroy(NDReturnReason::where('nd_buys_id', $request->nd_buys_id)->first()->id);

                return Redirect::route('sales')->with('success', trans('crud.canastarosa.message.success'));
            }else{
                $buy->nd_buys_id = 8;
                $buy->save();

                return Redirect::back()->with('error', trans('crud.canastarosa.message.error'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $view = 'create';

        $active = $this->active;
        $word = $this->create_word;
        $model = null;
        $select = null;
        $columns = null;
        $actions = null;

        $id = NDBuy::where('slug', $slug)->first()->id;
        $item = NDSaleDetailView::where('slug', $slug)->first();
        $item->nd_themathics_id = NDThemathic::where('name', $item->nd_themathics_id)->first()->id;
        // if($item->nd_delivery_schedules_id > 0){
        //     $item->nd_delivery_schedules_id = NDDeliverySchedule::where('name', $item->nd_delivery_schedules_id)->first()->id;
        // }
        $return_reason = NDReturnReason::where('nd_buys_id', $id)->first()->reason;

        $nd_themathics_id = NDThemathic::get()->pluck('name', 'id');
        $nd_delivery_schedules_id = NDDeliverySchedule::whereIn('id', [1,2])->get()->pluck('name', 'id');

        $now = new DateTime();
        $current_date = $now->format('d/m/Y');
        $current_time = $now->format('H:i:s');
        $current_day = $now->format('l');

        return view('admin.crud.form', compact($this->compact, 'return_reason', 'nd_themathics_id', 'nd_delivery_schedules_id', 'current_date', 'current_time', 'current_day'));
    }

    public function getSchedules(Request $request, $day, $month, $year)
    {
        if($request->ajax()){
            $request_date = new DateTime($year.'-'.$month.'-'.$day);
            $selected_date = $request_date->format('Y-m-d H:i:s');
            $selected_day = $request_date->format('l');
            $selected_date = strtotime($selected_date);

            $now = new DateTime();
            $current_date = $now->format('Y-m-d H:i:s');
            $current_time = $now->format('H:i:s');
            $current_day = $now->format('l');
            $current_date = strtotime($current_date);

            $now->add(new DateInterval('P1D'));
            $tomorrow_date = $now->format('Y-m-d H:i:s');
            $tomorrow_date = strtotime($tomorrow_date);

            // Si estoy pidiendo para hoy
            if($selected_date <= $current_date){
                $catalog_schedules = NDDeliverySchedule::whereIn('id', [2])->get();
            // Si estoy pidiendo para mañana
            }else if($selected_date <= $tomorrow_date){
                // Si es antes de las 7:00
                if($current_time <= '18:59:59'){
                    $catalog_schedules = NDDeliverySchedule::whereIn('id', [1,2])->get();
                // Si es después de las 7:00
                }else{
                    $catalog_schedules = NDDeliverySchedule::whereIn('id', [2])->get();
                }
            // Si estoy pidiendo para después de mañana
            }else{
                $catalog_schedules = NDDeliverySchedule::whereIn('id', [1,2])->get();
            }

            return response()->json($catalog_schedules);
        }
    }
}
