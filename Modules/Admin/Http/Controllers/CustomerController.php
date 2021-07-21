<?php

namespace Modules\Admin\Http\Controllers;

use App\DataTables\CustomersDataTable;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CustomerController extends Controller
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
     *
     * @param CustomersDataTable $dataTable
     * @return mixed
     */
    public function index(CustomersDataTable $dataTable)
    {
        return $dataTable->render('admin::customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
     * @param Customer $customer
     * @return Response
     */
    public function show(Customer $customer)
    {
        return view('admin::customer.show', ['customer' => $customer->loadMissing('relatedUser', 'relatedOrders')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Customer $customer
     * @return Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
