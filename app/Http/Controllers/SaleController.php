<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest as MasterRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Arr;
use App\ViewBuy;
use App\ViewSale;
use App\Building;
use App\Finance;
use App\Sale;
use App\Buy;
use App\NDBuy;
use App\NDSaleConfirmView;
use App\NDDeliveryType;
use App\NDSale;
use App\NDPackageDetail;
use App\NDSaleDetailView;

use Redirect;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('moduleSales');
        
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
    public function create($slug)
    {
        $view = 'create';

        $active = $this->active;
        $word = $this->create_word;
        $model = null;
        $select = null;
        $columns = null;
        $actions = null;
        $item = NDSaleConfirmView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'first_name',
                    'last_name',
                    'phone',
                    'package',
                    'nd_themathics_id',
                    'modifications',
                    'dedication',
                    'delivery_date',
                    'delivery_schedules_id',
                    'nd_delivery_schedules_id',
                    'observations',
                    'who_sends',
                    'who_receives',
                    'postal_code',
                    'state',
                    'municipality',
                    'colony',
                    'street',
                    'no_ext',
                    'no_int',
                    'nd_contact_means_id',
                    'contact_mean_other',
                    'status_id',
                    'nd_status_id'
                )
                ->first();
        $buy = $item ? $item->toArray() : array();

        $nd_delivery_types_id = NDDeliveryType::get()->pluck('name', 'id');
        
        return view('admin.crud.form', compact($this->compact, 'buy', 'nd_delivery_types_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterRequest $request)
    {
        $buy = NDBuy::find($request->nd_buys_id);

        // Save File
        $path = Storage::putFileAs(
                'receipts',
                $request->file('proof_of_payment'),
                $buy->slug.'.'.$request->file('proof_of_payment')->extension()
            );

        NDSale::create([
            'nd_buys_id' => $request->nd_buys_id,
            'nd_delivery_types_id' => $request->nd_delivery_types_id,
            'preferential_schedule' => $request->preferential_schedule,
            'observations_finances' => $request->observations_finances,
            'observations_buildings' => $request->observations_buildings,
            'observations_shippings' => $request->observations_shippings,
            'proof_of_payment' => $path,
        ]);

        NDPackageDetail::create([
            'nd_buys_id' => $request->nd_buys_id,
            'quantity' => $request->quantity,
            'package' => $request->package,
            'modifications' => $request->modifications,
            'delivery_price' => $request->delivery_price,
        ]);

        $buy->nd_status_id = 4;

        if(NDSale::where('nd_buys_id', $request->nd_buys_id)->count() > 0 && NDPackageDetail::where('nd_buys_id', $request->nd_buys_id)->count() > 0 && $buy->save()){
            return Redirect::route($this->active)->with('success', trans('crud.sale.message.success'));
        }else{
            NDSale::destroy(NDSale::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            Storage::delete($path);

            NDPackageDetail::destroy(NDPackageDetail::where('nd_buys_id', $request->nd_buys_id)->first()->id);

            $buy->nd_status_id = 1;
            $buy->save();

            return Redirect::back()->with('error', trans('crud.sale.message.error'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finished()
    {
        $view = 'finished';

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
        
        $item = NDSaleDetailView::where('slug', $slug)
                ->select(
                    'id',
                    'slug',
                    'first_name',
                    'last_name',
                    'phone',
                    'package',
                    'nd_themathics_id',
                    'modifications',
                    'dedication',
                    'delivery_date',
                    'nd_delivery_schedules_id',
                    'observations',
                    'who_sends',
                    'who_receives',
                    'postal_code',
                    'state',
                    'municipality',
                    'colony',
                    'street',
                    'no_ext',
                    'no_int',
                    'nd_contact_means_id',
                    'contact_mean_other',
                    'quantity',
                    'seller_package',
                    'seller_modifications',
                    'nd_delivery_types_id',
                    'preferential_schedule',
                    'observations_finances',
                    'observations_buildings',
                    'observations_shippings',
                    'delivery_price',
                    'proof_of_payment',
                    'nd_status_id',
                )
                ->first();
        $item = $item ? $item->toArray() : array();

        return view('admin.crud.show', compact($this->compact));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $slug = Buy::find($request->id)->slug;

        if(Buy::destroy($request->id)){
            if(Finance::where('slug', $slug)->count() > 0){
                $item = Finance::where('slug', $slug)->first();
                Finance::destroy($item->id);
            }

            if(Building::where('slug', $slug)->count() > 0){
                $item = Building::where('slug', $slug)->first();
                Building::destroy($item->id);
            }

            return Redirect::route($this->active)->with('success', trans('crud.delete.message.success'));
        }else{
            return Redirect::back()->with('danger', trans('crud.delete.message.error'));
        }
    }
}

