<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Redirect;

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

        return view('admin.modules.'.$active, compact($this->compact));
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
}
