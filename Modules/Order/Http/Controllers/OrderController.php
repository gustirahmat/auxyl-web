<?php

namespace Modules\Order\Http\Controllers;

use App\DataTables\OrdersDataTable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Order\Entities\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\OrderStatus;
use Throwable;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OrdersDataTable $dataTable
     * @return mixed
     */
    public function index(OrdersDataTable $dataTable)
    {
        return $dataTable->render('order::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('order::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function show(Order $order)
    {
        return view('order::show', ['order' => $order->loadMissing('relatedCustomer', 'relatedDelivery', 'relatedStatuses')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function edit(Order $order)
    {
        return view('order::update', ['order' => $order->loadMissing('relatedStatuses')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        $validated_data = $request->validate([
            'is_valid' => 'bail|required|boolean',
            'status_reason' => 'nullable|string|max:191'
        ]);

        try {
            DB::beginTransaction();

            if ($validated_data['is_valid']) {
                $order->order_latest_status = 2;
                $status = new OrderStatus([
                    'status_code' => 2,
                    'status_action' => 'Pesanan dibayar',
                    'status_comment' => null
                ]);
            } else {
                $order->order_latest_status = 1;
                $order->order_payment_proof = null;
                $status = new OrderStatus([
                    'status_code' => 1,
                    'status_action' => 'Verifikasi pembayaran gagal',
                    'status_comment' => $validated_data['status_reason']
                ]);
            }
            $order->save();
            $order->relatedStatuses()->save($status);

            DB::commit();

            return redirect()->route('order.show', $order->order_id)->with('success', 'Berhasil memperbarui status pesanan');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $order->order_latest_status = 7;
            $status = new OrderStatus([
                'status_code' => 7,
                'status_action' => 'Pesanan dibatalkan',
                'status_comment' => 'Pesanan dibatalkan manual oleh Admin'
            ]);
            $order->save();
            $order->relatedStatuses()->save($status);

            DB::commit();

            return redirect()->route('order.show', $order->order_id)->with('success', 'Berhasil memperbarui status pesanan');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }
}
