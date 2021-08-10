<?php

namespace Modules\Shipment\Http\Controllers;

use App\DataTables\OrderDeliveriesDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Shipment\Entities\OrderDelivery;
use Modules\Shipment\Entities\OrderStatus;
use Throwable;

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
     * @param OrderDelivery $shipment
     * @return RedirectResponse
     */
    public function update(Request $request, OrderDelivery $shipment): RedirectResponse
    {
        $validated_data = $request->validate([
            'delivery_order_number' => 'bail|required|string|max:191',
            'delivery_fee' => 'required|integer|min:0|max:100000000',
            'delivery_act_date' => 'required|date',
            'delivery_est_date' => 'required|date',
            'delivery_rcv_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $shipment->update($validated_data);
            $shipment->loadMissing('relatedOrder.relatedStatuses');
            if ($request->has('delivery_rcv_date')) {
                $status = new OrderStatus([
                    'status_code' => 4,
                    'status_action' => 'Pesanan diterima',
                    'status_comment' => 'Diterima tanggal ' . $validated_data['delivery_rcv_date']
                ]);
                $shipment->relatedOrder->order_latest_status = 4;
            } else {
                $status = new OrderStatus([
                    'status_code' => 3,
                    'status_action' => 'Pesanan dikirim',
                    'status_comment' => 'Dikirim tanggal ' . $validated_data['delivery_act_date']
                ]);
                $shipment->relatedOrder->order_ongkir = $validated_data['delivery_fee'];
                $shipment->relatedOrder->order_latest_status = 3;
            }
            $shipment->relatedOrder->relatedStatuses()->save($status);
            $shipment->relatedOrder->save();

            DB::commit();

            return redirect()->route('shipment.index')->with('success', 'Berhasil memperbarui status pengiriman');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
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
