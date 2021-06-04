<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Supplier\Entities\Supplier;
use Throwable;

class SupplierController extends Controller
{
    public function validate_data($request, $supplier_id = null)
    {
        $validate = [
            "supplier_name" => "bail|required|string|max:191|unique:suppliers,supplier_name,{$supplier_id},supplier_id",
            "supplier_phone" => "required|digits_between:8,20|unique:suppliers,supplier_phone,{$supplier_id},supplier_id",
            "supplier_address" => "required|string",
        ];

        return $request->validate($validate);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $suppliers = Supplier::all();

        return view('supplier::index', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('supplier::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated_data = $this->validate_data($request);

        try {
            DB::beginTransaction();

            $supplier = Supplier::create($validated_data);

            DB::commit();

            return redirect()->route('supplier.index')->with('success', 'Berhasil menambah supplier ' . $supplier->supplier_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param Supplier $supplier
     * @return Renderable
     */
    public function show(Supplier $supplier): Renderable
    {
        return view('supplier::show', ['supplier' => $supplier]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Supplier $supplier
     * @return Renderable
     */
    public function edit(Supplier $supplier): Renderable
    {
        return view('supplier::edit', ['supplier' => $supplier]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Supplier $supplier
     * @return RedirectResponse
     */
    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $validated_data = $this->validate_data($request, $supplier->supplier_id);

        try {
            DB::beginTransaction();

            $supplier->update($validated_data);

            DB::commit();

            return redirect()->route('supplier.index')->with('success', 'Berhasil mengubah supplier ' . $supplier->supplier_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Supplier $supplier
     * @return RedirectResponse
     */
    public function destroy(Supplier $supplier)
    {
        try {
            DB::beginTransaction();

            $supplier->delete();

            DB::commit();

            return redirect()->route('supplier.index')->with('success', 'Berhasil menghapus supplier ' . $supplier->supplier_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }
}
