<?php

namespace Modules\Shipment\Http\Controllers;

use App\DataTables\OrderDeliveriesDataTable;
use App\DataTables\OrdersDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Shipment\Entities\OrderDelivery;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param OrderDeliveriesDataTable $dataTable
     * @return mixed
     */
    public function index(OrderDeliveriesDataTable $dataTable)
    {
        return $dataTable->render('shipment::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('shipment::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('shipment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param OrderDelivery $shipment
     * @return Renderable
     */
    public function edit(OrderDelivery $shipment): Renderable
    {
        return view('shipment::update', ['delivery' => $shipment->loadMissing('relatedOrder.relatedCustomer')]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
