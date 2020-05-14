<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Http\Requests\UserRequest as MasterRequest;
use Illuminate\Support\Str as Str;
use Sentinel;
use Activation;

class UserController extends Controller
{
    public function __construct()
    {
        // General
        $this->active = explode('.',\Request::route()->getName())[0];
        $this->model = trans('module_'.$this->active.'.controller.model');
        $this->create_fields = trans('module_'.$this->active.'.controller.create_fields');
        $this->full_model = 'App\\'.$this->model;
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

        $user = Sentinel::findById($item->id);
        $activation = Activation::create($user);
        Activation::complete($user, $activation->code);

        /* Extras */
        $role = Sentinel::findRoleById($request->role_id);
        $role->users()->attach($item);

        /* Slug */
        $item->slug = Str::slug($item->first_name.' '.$item->last_name.' '.$item->id);

        if($item->save()){
            return Redirect::route($this->active.'.create')->with('success', trans('crud.create.message.success'));
        }else{
            $item->forceDelete();
            return Redirect::back()->with('error', trans('crud.create.message.error'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterRequest $request, $id)
    {
        $item = $this->full_model::find($id);

        /* Extras */
        $role = Sentinel::findRoleById($item->role_id);
        $role->users()->detach($item);

        $item->fill($request->only($this->create_fields));

        /* Extras */
        $role = Sentinel::findRoleById($request->role_id);
        $role->users()->attach($item);

        /* Slug */
        $item->slug = Str::slug($item->first_name.' '.$item->last_name.' '.$item->id);

        if($item->save()){
            return Redirect::route($this->active.'.edit', $item->id)->with('success', trans('crud.update.message.success'));
        }else{
            return Redirect::back()->with('error', trans('crud.update.message.error'));
        }
    }
}
