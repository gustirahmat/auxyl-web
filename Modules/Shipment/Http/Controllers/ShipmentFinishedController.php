<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Shipment\Entities\OrderDelivery;
use Modules\Shipment\Entities\OrderStatus;
use Throwable;

class ShipmentFinishedController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param int $delivery_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function __invoke(int $delivery_id, Request $request): RedirectResponse
    {
        try {
            $delivery = OrderDelivery::with('relatedOrder.relatedStatuses')->findOrFail($delivery_id);

            DB::beginTransaction();

            $delivery->relatedOrder->order_latest_status = 5;
            $delivery->relatedOrder->save();
            $status = new OrderStatus([
                'status_code' => 5,
                'status_action' => 'Pesanan selesai',
                'status_comment' => 'Pesanan dianggap selesai oleh Admin'
            ]);
            $delivery->relatedOrder->relatedStatuses()->save($status);

            DB::commit();

            return redirect()->route('shipment.index')->with('success', 'Berhasil memperbarui status pengiriman');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }
}
