<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use DateTime;
use Redirect;
use App\NDProduct;
use App\NDInventoryProduct;
use App\NDProductDetailView;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware('moduleProduct');
        
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
        $view = 'products';

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
        /* Slug */
        $now = new DateTime();
        $current_date = $now->format('YmdHis');
        $slug = Str::slug($current_date.$request->_token.rand(1000,9999));

        $item = NDProduct::create([
                    'slug' => $slug,
                    'code' => $request->code,
                    'category' => $request->category,
                    'type' => $request->type,
                    'product_name' => $request->product_name,
                    'supplier' => $request->supplier,
                    'brand' => $request->brand,
                    'price' => $request->price,
                ]);

        NDInventoryProduct::create([
            'nd_products_id' => $item->id,
            'income' => $request->quantity,
            'outcome' => 0,
        ]);

        if(NDProduct::where('id', $item->id)->count() > 0 && NDInventoryProduct::where('nd_products_id', $item->id)->count() > 0){
            return Redirect::route($this->active)->with('success', trans('crud.create.message.success'));
        }else{
            $item->forceDelete();
            return Redirect::back()->with('error', trans('crud.create.message.error'));
        }
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
        
        $item = NDProductDetailView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'code',
                    'category',
                    'type',
                    'product_name',
                    'supplier',
                    'brand',
                    'price',
                    'quantity',
                )
                ->first();
        $item = $item ? $item->toArray() : array();

        return view('admin.crud.show', compact($this->compact, 'item'));
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
