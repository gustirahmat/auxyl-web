<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Throwable;

class ProductStockController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validate_data($request)
    {
        $validate = [
            "stock_qty" => "bail|required|integer",
            "stock_status" => "required|boolean",
            "stock_notes" => "nullable|string",
        ];

        return $request->validate($validate);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index($product_id)
    {
        $product = Product::with('relatedStocks')->findOrFail($product_id);

        return view('product::stock.index', ['product' => $product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create($product_id)
    {
        $product = Product::with('relatedStocks')->findOrFail($product_id);

        return view('product::stock.create', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $product_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function store($product_id, Request $request): RedirectResponse
    {
        $validated_data = $this->validate_data($request);

        try {
            DB::beginTransaction();

            $product = Product::with('relatedStocks')->findOrFail($product_id);

            $stock = new ProductStock([
                'stock_qty' => $validated_data['stock_qty'],
                'stock_status' => $validated_data['stock_status'],
                'stock_notes' => $validated_data['stock_notes'],
            ]);
            $product->relatedStocks()->save($stock);

            $math = -1;
            if ($validated_data['stock_status']) {
                $math = 1;
            }
            $product->product_stock = $product->product_stock + ($validated_data['stock_qty'] * $math);
            $product->save();

            DB::commit();

            return redirect()->route('product.stock.index', ['product' => $product->product_id])->with('success', 'Berhasil menambah histori stok produk ' . $product->product_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ProductStock $productStock
     * @return Response
     */
    public function show(ProductStock $productStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProductStock $productStock
     * @return Response
     */
    public function edit(ProductStock $productStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ProductStock $productStock
     * @return Response
     */
    public function update(Request $request, ProductStock $productStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductStock $productStock
     * @return Response
     */
    public function destroy(ProductStock $productStock)
    {
        //
    }
}
