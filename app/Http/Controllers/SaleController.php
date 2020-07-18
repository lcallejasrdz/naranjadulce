<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest as MasterRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\NDBuy;
use App\NDBuysOrigin;
use App\NDCustomerForm;
use App\NDPinkBasket;
use App\NDDetailBuy;
use App\NDSale;
use App\NDPackageDetail;
use App\NDFinance;
use App\NDBuilding;
use App\NDShipping;
use App\NDDelivery;
use App\NDSaleConfirmView;
use App\NDSaleDetailView;
use App\NDDeliveryType;
use App\NDReturnReason;

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

        if($item->status_id == 8){
            $last_reason = NDReturnReason::where('nd_buys_id', $item->id)->first();
            $return_reason = $last_reason->reason;
            $return_module = $last_reason->module;

            $sale = NDSale::where('nd_buys_id', $item->id)->first();
            $package_detail = NDPackageDetail::where('nd_buys_id', $item->id)->first();

            return view('admin.crud.form', compact($this->compact, 'buy', 'return_reason', 'return_module', 'sale', 'package_detail', 'nd_delivery_types_id'));
        }else{
            return view('admin.crud.form', compact($this->compact, 'buy', 'nd_delivery_types_id'));
        }
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

        if($buy->nd_status_id == 8){
            $sale = NDSale::where('nd_buys_id', $request->nd_buys_id)->first();
            $package_detail = NDPackageDetail::where('nd_buys_id', $request->nd_buys_id)->first();
        }

        // Save File
        if($request->proof_verified == 0)
            $path = Storage::putFileAs(
                    'receipts',
                    $request->file('proof_of_payment'),
                    $buy->slug.'.'.$request->file('proof_of_payment')->extension()
                );
        else{
            $path = $sale->proof_of_payment;
        }

        if($buy->nd_status_id == 1){
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
        }else{
            $sale->nd_buys_id = $request->nd_buys_id;
            $sale->nd_delivery_types_id = $request->nd_delivery_types_id;
            $sale->preferential_schedule = $request->preferential_schedule;
            $sale->observations_finances = $request->observations_finances;
            $sale->observations_buildings = $request->observations_buildings;
            $sale->observations_shippings = $request->observations_shippings;
            $sale->proof_of_payment = $path;

            $package_detail->nd_buys_id = $request->nd_buys_id;
            $package_detail->quantity = $request->quantity;
            $package_detail->package = $request->package;
            $package_detail->modifications = $request->modifications;
            $package_detail->delivery_price = $request->delivery_price;

            if($request->return_module == 'finances'){
                $buy->nd_status_id = 4;
            }else if($request->return_module == 'buildings'){
                $buy->nd_status_id = 3;
            }else{
                $buy->nd_status_id = 5;
            }

            if($sale->save() && $package_detail->save() && $buy->save()){
                NDReturnReason::destroy(NDReturnReason::where('nd_buys_id', $request->nd_buys_id)->first()->id);

                return Redirect::route($this->active)->with('success', trans('crud.sale.message.success'));
            }else{
                if($request->proof_verified == 0){
                    Storage::delete($path);
                }

                $buy->nd_status_id = 8;
                $buy->save();

                return Redirect::back()->with('error', trans('crud.sale.message.error'));
            }
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
                    'delivery_man',
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
        if(NDBuy::destroy($request->nd_buys_id)){
            if(NDBuysOrigin::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDBuysOrigin::destroy(NDBuysOrigin::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDCustomerForm::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDCustomerForm::destroy(NDCustomerForm::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDPinkBasket::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDPinkBasket::destroy(NDPinkBasket::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDDetailBuy::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDDetailBuy::destroy(NDDetailBuy::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDSale::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDSale::destroy(NDSale::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDPackageDetail::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDPackageDetail::destroy(NDPackageDetail::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDFinance::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDFinance::destroy(NDFinance::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDBuilding::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDBuilding::destroy(NDBuilding::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDShipping::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDShipping::destroy(NDShipping::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDDelivery::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDDelivery::destroy(NDDelivery::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }
            if(NDReturnReason::where('nd_buys_id', $request->nd_buys_id)->count() > 0){
                NDReturnReason::destroy(NDReturnReason::where('nd_buys_id', $request->nd_buys_id)->first()->id);
            }

            return Redirect::route($this->active)->with('success', trans('crud.delete.message.success'));
        }else{
            return Redirect::back()->with('danger', trans('crud.delete.message.error'));
        }
    }
}

