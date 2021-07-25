<?php

namespace Modules\Complain\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use JD\Cloudder\Facades\Cloudder;
use Modules\Complain\Entities\OrderComplain;
use Modules\Complain\Entities\OrderStatus;
use Throwable;

class ComplainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('password.confirm')->only('edit');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $complains = OrderComplain::all();

        return view('complain::index', ['complains' => $complains]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('complain::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param OrderComplain $complain
     * @return Renderable
     */
    public function show(OrderComplain $complain)
    {
        return view('complain::show', [
            'complain' => $complain->loadMissing('relatedOrder'),
            'order' => $complain->relatedOrder
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param OrderComplain $complain
     * @return Renderable
     */
    public function edit(OrderComplain $complain)
    {
        return view('complain::update', ['complain' => $complain->loadMissing('relatedOrder.relatedCustomer')]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param OrderComplain $complain
     * @return RedirectResponse
     */
    public function update(Request $request, OrderComplain $complain): RedirectResponse
    {
        $validated_data = $request->validate([
            'complain_status' => 'bail|required|integer',
            'complain_resolution' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            if ($validated_data['complain_status'] == 3) {
                $complain->loadMissing('relatedOrder.relatedStatuses');
                $order = $complain->relatedOrder;
                $order->order_latest_status = 5;
                $status = new OrderStatus([
                    'status_code' => 5,
                    'status_action' => 'Pesanan selesai',
                    'status_comment' => $validated_data['complain_resolution']
                ]);
                $order->save();
                $order->relatedStatuses()->save($status);
            }
            $complain->update($validated_data);

            DB::commit();

            return redirect()->route('complain.show', $complain->complain_id)->with('success', 'Berhasil memperbarui status komplain untuk pesanan ini');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param OrderComplain $complain
     * @return void
     */
    public function destroy(OrderComplain $complain)
    {
        //
    }
}
