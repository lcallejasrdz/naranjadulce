<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest as MasterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use DateTime;
use Redirect;
use App\NDPackage;
use App\NDPackageDetailView;
use App\NDProduct;
use App\NDProductDetailView;
use App\NDProductPackage;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('modulePackages');
        
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

        // Create
        $this->edit_word = trans('module_'.$this->active.'.controller.edit_word');

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
        $view = 'packages';

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

        $nd_products_id = NDProduct::get()->pluck('product_name', 'id');

        return view('admin.crud.form', compact($this->compact, 'nd_products_id'));
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

        $item = NDPackage::create([
                    'slug' => $slug,
                    'name' => $request->name,
                    'price' => $request->amount,
                ]);

        $products = $request->products;
        $quantities = $request->quantities;

        for($i=0; $i<count($products); $i++){
            NDProductPackage::create([
                'nd_packages_id' => $item->id,
                'nd_products_id' => $products[$i],
                'quantity' => $quantities[$i],
            ]);
        }

        if(NDPackage::where('id', $item->id)->count() > 0){
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
        
        $item = NDPackageDetailView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'name',
                    'price',
                )
                ->first();
        $item = $item ? $item->toArray() : array();

        return view('admin.crud.show', compact($this->compact, 'item'));
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
        
        $item = NDPackageDetailView::where('id', $id)
                ->select(
                    'id',
                    'slug',
                    'name',
                    'price',
                )
                ->first();

        return view('admin.crud.form', compact($this->compact, 'item'));
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
        $item = NDPackage::find($id);

        $item->name = $request->name;
        $item->price = $request->price;

        if($item->save()){
            return Redirect::route($this->active.'.edit', $item->id)->with('success', trans('crud.update.message.success'));
        }else{
            return Redirect::back()->with('error', trans('crud.update.message.error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(NDPackage::destroy($request->id)){
            return Redirect::route($this->active)->with('success', trans('crud.delete.message.success'));
        }else{
            return Redirect::back()->with('danger', trans('crud.delete.message.error'));
        }
    }

    public function products(Request $request, $id)
    {
        if($request->ajax()){
            $product = NDProductDetailView::where('id', $id)->get();
            return response()->json($product);
        }
    }
}
