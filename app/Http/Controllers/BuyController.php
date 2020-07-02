<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Redirect;
use App\Schedule;
use DateTime;
use DateInterval;

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

        return view('admin.modules.'.$active, compact($this->compact, 'schedules', 'current_date', 'current_time', 'current_day'));
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

        /* Slug */
        $item->slug = Str::slug($request->_token.$item->id);

        if($item->save()){
            return Redirect::route($this->active.'.create')->with('success', trans('crud.buy.message.success').$item->id);
        }else{
            $item->forceDelete();
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
                        $catalog_schedules = Schedule::whereIn('id', [2,3])->get();
                    // Si es después de la 1:00
                    }else{
                        $catalog_schedules = Schedule::where('id', 3)->get();
                    }
                // Si estoy pidiendo para mañana
                }else if($selected_date <= $tomorrow_date){
                    // Si es antes de las 7:00
                    if($current_time <= '18:59:59'){
                        $catalog_schedules = Schedule::get();
                    // Si es después de las 7:00
                    }else{
                        $catalog_schedules = Schedule::whereIn('id', [2,3])->get();
                    }
                // Si estoy pidiendo para después de mañana
                }else{
                    // Si es para lunes a viernes
                    if($selected_day != 'Saturday' && $selected_day != 'Sunday'){
                        $catalog_schedules = Schedule::get();
                    // Si es para sabado o domingo
                    }else{
                        $catalog_schedules = Schedule::whereIn('id', [1,3])->get();
                    }
                }
            }
            // Si estoy pidiendo en viernes
            else if($current_day == 'Friday'){
                // Si estoy pidiendo para hoy
                if($selected_date <= $current_date){
                    // Si es antes de la 1:00
                    if($current_time <= '12:59:59'){
                        $catalog_schedules = Schedule::whereIn('id', [2,3])->get();
                    // Si es después de la 1:00
                    }else{
                        $catalog_schedules = Schedule::where('id', 3)->get();
                    }
                // Si estoy pidiendo para mañana
                }else if($selected_date <= $tomorrow_date){
                    // Si es antes de las 7:00
                    if($current_time <= '18:59:59'){
                        $catalog_schedules = Schedule::whereIn('id', [1,3])->get();
                    // Si es después de las 7:00
                    }else{
                        $catalog_schedules = Schedule::where('id', 3)->get();
                    }
                // Si estoy pidiendo para después de mañana
                }else{
                    // Si es para lunes a viernes
                    if($selected_day != 'Saturday' && $selected_day != 'Sunday'){
                        $catalog_schedules = Schedule::get();
                    // Si es para sabado o domingo
                    }else{
                        $catalog_schedules = Schedule::whereIn('id', [1,3])->get();
                    }
                }
            }
            // Si estoy pidiendo en sábado
            else if($current_day == 'Saturday'){
                // Si estoy pidiendo para mañana
                if($selected_date <= $tomorrow_date){
                    // Si es antes de las 12:00
                    if($current_time <= '11:59:59'){
                        $catalog_schedules = Schedule::whereIn('id', [1,3])->get();
                    // Si es después de las 12:00
                    }else{
                        $catalog_schedules = Schedule::where('id', 3)->get();
                    }
                // Si estoy pidiendo para después de mañana
                }else{
                    // Si es para lunes a viernes
                    if($selected_day != 'Saturday' && $selected_day != 'Sunday'){
                        $catalog_schedules = Schedule::get();
                    // Si es para sabado o domingo
                    }else{
                        $catalog_schedules = Schedule::whereIn('id', [1,3])->get();
                    }
                }
            }
            // Si estoy pidiendo en domingo
            else if($current_day == 'Sunday'){
                // Si estoy pidiendo para mañana
                if($selected_date <= $tomorrow_date){
                    // Si es antes de las 12:00
                    if($current_time <= '11:59:59'){
                        $catalog_schedules = Schedule::whereIn('id', [1,3])->get();
                    // Si es después de las 12:00
                    }else{
                        $catalog_schedules = Schedule::whereIn('id', [2,3])->get();
                    }
                // Si estoy pidiendo para después de mañana
                }else{
                    // Si es para lunes a viernes
                    if($selected_day != 'Saturday' && $selected_day != 'Sunday'){
                        $catalog_schedules = Schedule::get();
                    // Si es para sabado o domingo
                    }else{
                        $catalog_schedules = Schedule::whereIn('id', [1,3])->get();
                    }
                }
            }
            // Casos no contemplados
            else{
                $catalog_schedules = Schedule::get();
            }

            return response()->json($catalog_schedules);
        }
    }
}
