<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductPhoto;
use Modules\Product\Entities\ProductStock;
use Modules\Supplier\Entities\Supplier;
use Throwable;

class ProductController extends Controller
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

    protected function validate_data($request, $product_id = null)
    {
        $validate = [
            "product_name" => "bail|required|string|max:191|unique:products,product_name,{$product_id},product_id",
            "category_id" => "required|integer",
            "supplier_id" => "required|integer",
            "price_supplier" => "required|numeric|min:0",
            "price_selling" => "required|numeric|min:1|gte:price_supplier",
            "product_description" => "required|string",
            "product_guarantee" => "nullable|string",
            "product_stock" => "sometimes|required|integer|min:0",
            "product_image" => "sometimes|required|image|max:2048",
        ];

        return $request->validate($validate);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $products = Product::all();

        return view('product::index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Renderable
     */
    public function create(Request $request): Renderable
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('product::create', [
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $validated_data = $this->validate_data($request);

        try {
            // '00001'
            $validated_data['product_sku'] = '00001';
            $product_skus = [];
            $products = Product::withTrashed()->whereNotNull('product_sku')->lockForUpdate()->get();
            foreach ($products as $product) {
                array_push($product_skus, substr($product->product_sku, -5));
            }
            if ($product_skus) {
                sort($product_skus);
                $value = end($product_skus) + 1;
                $validated_data['product_sku'] = str_pad($value, 5, "0", STR_PAD_LEFT);
            }

            DB::beginTransaction();

            $product = Product::create($validated_data);
            if ($request->has('product_image')) {
                if (App::environment('production')) {
                    $image_name = $request->file('product_image')->getRealPath();
                    Cloudder::upload($image_name, null, array(
                        'folder' => 'images/product/' . $product->product_id,
                        'overwrite' => true,
                        'resource_type' => 'image'
                    ));

                    list($width, $height) = getimagesize($image_name);
                    $product_image = Cloudder::secureShow(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
                    $path = $product_image;
                } else {
                    $image_name = Str::slug($product->product_name) . '-' . time() . '.' . $request->file('product_image')->getClientOriginalExtension();
                    $path = $request->file('product_image')->storeAs(
                        'images/product/' . $product->product_id, $image_name, 'public'
                    );
                }

                $photo = new ProductPhoto([
                    'product_image' => $path,
                    'image_alt_text' => 'Gambar ' . $product->product_name
                ]);
                $product->relatedPhotos()->save($photo);
            }

            $stock = new ProductStock([
                'stock_qty' => $product->product_stock,
                'stock_status' => true,
                'stock_notes' => 'Produk baru ditambahkan',
            ]);
            $product->relatedStocks()->save($stock);

            DB::commit();

            return redirect('product')->with('success', 'Berhasil menambah produk ' . $product->product_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param Product $product
     * @return Renderable
     */
    public function show(Product $product): Renderable
    {
        return view('product::show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Product $product
     * @return Renderable
     */
    public function edit(Product $product): Renderable
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('product::edit', [
            'categories' => $categories,
            'suppliers' => $suppliers,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated_data = $this->validate_data($request, $product->product_id);

        try {
            DB::beginTransaction();

            $product->update($validated_data);

            DB::commit();

            return redirect()->route('product.index')->with('success', 'Berhasil mengubah produk ' . $product->product_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            DB::beginTransaction();

//            Storage::delete('public/images/product/' . substr($product->product_icon, 23));
            $product->delete();

            DB::commit();

            return redirect()->route('product.index')->with('success', 'Berhasil menghapus produk ' . $product->product_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }
}
