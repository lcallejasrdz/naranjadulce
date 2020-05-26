<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Redirect;

class CRUDController extends Controller
{
    public function __construct()
    {
        // General
        $this->active = explode('.',\Request::route()->getName())[0];
        if($this->active = 'users'){
            $this->middleware('moduleUsers');
        }else if($this->active = 'sales'){
            $this->middleware('moduleSales');
        }else if($this->active = 'finances'){
            $this->middleware('moduleFinances');
        }else if($this->active = 'buildings'){
            $this->middleware('moduleBuildings');
        }else if($this->active = 'shippings'){
            $this->middleware('moduleShippings');
        }else if($this->active = 'deliveries'){
            $this->middleware('moduleDeliveries');
        }

        $this->word = trans('module_'.$this->active.'.controller.word');

        // Index
        $this->model = trans('module_'.$this->active.'.controller.model');
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

        // Edit
        $this->edit_word = trans('module_'.$this->active.'.controller.edit_word');
        $this->parameter = \Request::route()->parameter('id');
        $this->edit_model = 'App\\'.$this->model;
        $this->edit_item = $this->edit_model::find($this->parameter);

        // Read
        $this->parameter = \Request::route()->parameter('slug');
        $this->full_model = 'App\\View'.$this->model;
        $item = $this->full_model::where('slug', $this->parameter)->first();
        $this->show_item = $item ? $item->toArray() : array();

        // Deleted
        $this->deleted_word = trans('module_'.$this->active.'.controller.deleted_word');

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
        $view = 'index';

        $active = $this->active;
        $word = $this->word;
        $model = $this->model;
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

        return view('admin.crud.form', compact($this->compact));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $view = 'edit';

        $active = $this->active;
        $word = $this->edit_word;
        $model = null;
        $select = null;
        $columns = null;
        $actions = null;
        $item = $this->edit_item;

        return view('admin.crud.form', compact($this->compact, 'item'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $view = 'show';

        $active = $this->active;
        $word = $this->word;
        $model = null;
        $select = null;
        $columns = null;
        $actions = null;
        $item = $this->show_item;

        return view('admin.crud.show', compact($this->compact, 'item'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->full_model = 'App\\'.$this->model;
        if($this->full_model::destroy($request->id)){
            return Redirect::route($this->active)->with('success', trans('crud.delete.message.success'));
        }else{
            return Redirect::back()->with('danger', trans('crud.delete.message.error'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRestore()
    {
        $view = 'deleted';

        $active = $this->active;
        $word = $this->deleted_word;
        $model = $this->model;
        $select = $this->select;
        $columns = $this->columns;
        $actions = $this->actions;
        $item = null;

        return view('admin.crud.list', compact($this->compact));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postRestore(Request $request)
    {
        $this->full_model = 'App\\'.$this->model;
        if($this->full_model::onlyTrashed()->find($request->id)->restore()){
            return Redirect::route($this->active.'.deleted')->with('success', trans('crud.restore.message.success'));
        }else{
            return Redirect::back()->with('danger', trans('crud.restore.message.error'));
        }
    }
}
