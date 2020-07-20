<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Redirect;
use DateTime;
use DateInterval;
use App\NDAddressType;
use App\NDParking;
use App\NDThemathic;
use App\NDContactMean;
use App\NDDeliverySchedule;

use App\NDBuy;
use App\NDBuysOrigin;
use App\NDCustomerForm;
use App\NDDetailBuy;

class BuyController extends Controller
{
    public function __construct()
    {
        // General
        $this->active = explode('.',\Request::route()->getName())[0];
        $this->word = trans('module_'.$this->active.'.controller.word');
        $this->model = trans('module_'.$this->active.'.controller.model');
        $this->create_fields = trans('module_'.$this->active.'.controller.create_fields');
        $this->full_model = 'App\\'.$this->model;

        // Final compact
        $this->compact = ['view', 'active', 'word', 'model', 'select', 'columns', 'actions', 'item'];
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
        $word = $this->word;
        $model = null;
        $select = null;
        $columns = null;
        $actions = null;
        $item = null;

        $schedules = [];

        $now = new DateTime();
        $current_date = $now->format('d/m/Y');
        $current_time = $now->format('H:i:s');
        $current_day = $now->format('l');

        $nd_address_types_id = NDAddressType::get()->pluck('name', 'id');
        $nd_parkings_id = NDParking::get()->pluck('name', 'id');
        $nd_themathics_id = NDThemathic::get()->pluck('name', 'id');
        $nd_delivery_schedules_id = [];
        $nd_contact_means_id = NDContactMean::get()->pluck('name', 'id');

        return view('admin.modules.'.$active, compact($this->compact, 'schedules', 'current_date', 'current_time', 'current_day', 'nd_address_types_id', 'nd_parkings_id', 'nd_themathics_id', 'nd_delivery_schedules_id', 'nd_contact_means_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterRequest $request)
    {
        /* Slug */
        $now = new DateTime();
        $current_date = $now->format('YmdHis');
        $slug = Str::slug($current_date.$request->_token.rand(1000,9999));

        $item = NDBuy::create([
                    'slug' => $slug,
                    'nd_status_id' => 1,
                ]);

        NDBuysOrigin::create([
            'nd_buys_id' => $item->id,
            'nd_origins_id' => 1,
        ]);

        NDCustomerForm::create([
            'nd_buys_id' => $item->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'postal_code' => $request->postal_code,
            'state' => $request->state,
            'municipality' => $request->municipality,
            'colony' => $request->colony,
            'street' => $request->street,
            'no_ext' => $request->no_ext,
            'no_int' => $request->no_int,
            'nd_address_types_id' => $request->nd_address_types_id,
            'address_references' => $request->address_references,
            'nd_parkings_id' => $request->nd_parkings_id,
            'package' => $request->package,
            'nd_themathics_id' => $request->nd_themathics_id,
            'modifications' => $request->modifications,
            'observations' => $request->observations,
            'nd_contact_means_id' => $request->nd_contact_means_id,
            'contact_mean_other' => $request->contact_mean_other,
        ]);

        $date = explode('/', $request->delivery_date);
        $delivery_date = new DateTime($date[2].'-'.$date[1].'-'.$date[0]);

        NDDetailBuy::create([
            'nd_buys_id' => $item->id,
            'who_sends' => $request->who_sends,
            'who_receives' => $request->who_receives,
            'dedication' => $request->dedication,
            'delivery_date' => $delivery_date,
            'nd_delivery_schedules_id' => $request->nd_delivery_schedules_id,
        ]);

        if(NDBuy::where('id', $item->id)->count() > 0 && NDBuysOrigin::where('nd_buys_id', $item->id)->count() > 0 && NDCustomerForm::where('nd_buys_id', $item->id)->count() > 0 && NDDetailBuy::where('nd_buys_id', $item->id)->count() > 0){
            return Redirect::route($this->active.'.create')->with('success', trans('crud.buy.message.success').$item->id);
        }else{
            NDDetailBuy::destroy(NDDetailBuy::where('nd_buys_id', $item->id)->first()->id);
            NDCustomerForm::destroy(NDCustomerForm::where('nd_buys_id', $item->id)->first()->id);
            NDBuysOrigin::destroy(NDBuysOrigin::where('nd_buys_id', $item->id)->first()->id);
            NDBuy::destroy($item->id);

            return Redirect::back()->with('error', trans('crud.buy.message.error'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(MasterRequest $request, $id)
    {
        $item = $this->full_model::find($id);

        $item->fill($request->only($this->create_fields));

        /* Slug */
        $item->slug = Str::slug($item->name.' '.$item->id);

        if($item->save()){
            return Redirect::route($this->active.'.edit', $item->id)->with('success', trans('crud.update.message.success'));
        }else{
            return Redirect::back()->with('error', trans('crud.update.message.error'));
        }
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

            // Si estoy pidiendo en lunes, marte, miercoles, jueves
            if($current_day != 'Friday' && $current_day != 'Saturday' && $current_day != 'Sunday'){
                // Si estoy pidiendo para hoy
                if($selected_date <= $current_date){
                    // Si es antes de la 1:00
                    if($current_time <= '12:59:59'){
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [2,3])->get();
                    // Si es después de la 1:00
                    }else{
                        $catalog_schedules = NDDeliverySchedule::where('id', 3)->get();
                    }
                // Si estoy pidiendo para mañana
                }else if($selected_date <= $tomorrow_date){
                    // Si es antes de las 7:00
                    if($current_time <= '18:59:59'){
                        $catalog_schedules = NDDeliverySchedule::get();
                    // Si es después de las 7:00
                    }else{
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [2,3])->get();
                    }
                // Si estoy pidiendo para después de mañana
                }else{
                    // Si es para lunes a viernes
                    if($selected_day != 'Saturday' && $selected_day != 'Sunday'){
                        $catalog_schedules = NDDeliverySchedule::get();
                    // Si es para sabado o domingo
                    }else{
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [1,3])->get();
                    }
                }
            }
            // Si estoy pidiendo en viernes
            else if($current_day == 'Friday'){
                // Si estoy pidiendo para hoy
                if($selected_date <= $current_date){
                    // Si es antes de la 1:00
                    if($current_time <= '12:59:59'){
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [2,3])->get();
                    // Si es después de la 1:00
                    }else{
                        $catalog_schedules = NDDeliverySchedule::where('id', 3)->get();
                    }
                // Si estoy pidiendo para mañana
                }else if($selected_date <= $tomorrow_date){
                    // Si es antes de las 7:00
                    if($current_time <= '18:59:59'){
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [1,3])->get();
                    // Si es después de las 7:00
                    }else{
                        $catalog_schedules = NDDeliverySchedule::where('id', 3)->get();
                    }
                // Si estoy pidiendo para después de mañana
                }else{
                    // Si es para lunes a viernes
                    if($selected_day != 'Saturday' && $selected_day != 'Sunday'){
                        $catalog_schedules = NDDeliverySchedule::get();
                    // Si es para sabado o domingo
                    }else{
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [1,3])->get();
                    }
                }
            }
            // Si estoy pidiendo en sábado
            else if($current_day == 'Saturday'){
                // Si estoy pidiendo para mañana
                if($selected_date <= $tomorrow_date){
                    // Si es antes de las 12:00
                    if($current_time <= '11:59:59'){
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [1,3])->get();
                    // Si es después de las 12:00
                    }else{
                        $catalog_schedules = NDDeliverySchedule::where('id', 3)->get();
                    }
                // Si estoy pidiendo para después de mañana
                }else{
                    // Si es para lunes a viernes
                    if($selected_day != 'Saturday' && $selected_day != 'Sunday'){
                        $catalog_schedules = NDDeliverySchedule::get();
                    // Si es para sabado o domingo
                    }else{
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [1,3])->get();
                    }
                }
            }
            // Si estoy pidiendo en domingo
            else if($current_day == 'Sunday'){
                // Si estoy pidiendo para mañana
                if($selected_date <= $tomorrow_date){
                    // Si es antes de las 12:00
                    if($current_time <= '11:59:59'){
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [1,3])->get();
                    // Si es después de las 12:00
                    }else{
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [2,3])->get();
                    }
                // Si estoy pidiendo para después de mañana
                }else{
                    // Si es para lunes a viernes
                    if($selected_day != 'Saturday' && $selected_day != 'Sunday'){
                        $catalog_schedules = NDDeliverySchedule::get();
                    // Si es para sabado o domingo
                    }else{
                        $catalog_schedules = NDDeliverySchedule::whereIn('id', [1,3])->get();
                    }
                }
            }
            // Casos no contemplados
            else{
                $catalog_schedules = NDDeliverySchedule::get();
            }

            return response()->json($catalog_schedules);
        }
    }
}
