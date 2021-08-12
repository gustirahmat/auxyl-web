<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $year
     * @param int $month
     * @param Request $request
     * @return Renderable
     */
    public function index(int $year, int $month, Request $request): Renderable
    {
        $orders = Order::with('relatedProducts')
            ->whereIn('order_latest_status', [5,6])
            ->whereYear('order_date', $year)
            ->whereMonth('order_date', $month)
            ->get();

        $hpp_finished = 0;
        foreach ($orders->where('order_latest_status', '=', 5) as $order) {
            foreach ($order->relatedProducts as $product) {
                $hpp_finished += ($product->order_product_buy * $product->order_product_qty);
            }
        }

        $hpp_returned = 0;
        foreach ($orders->where('order_latest_status', '=', 6) as $order) {
            foreach ($order->relatedProducts as $product) {
                $hpp_returned += ($product->order_product_buy * $product->order_product_qty);
            }
        }

        return view('report::index', [
            'year' => $year,
            'month' => date("F", mktime(0, 0, 0, $month, 1, $year)),
            'orders' => $orders,
            'hpp_finished' => $hpp_finished,
            'hpp_returned' => $hpp_returned,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('report::create');
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
        return view('report::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('report::edit');
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
