<?php

namespace Modules\Promo\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Modules\Promo\Entities\Promo;
use Modules\Promo\Entities\Product;
use Throwable;

class PromoController extends Controller
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

    protected function validate_data($request, $promo_id = null)
    {
        $validate = [
            "promo_name" => "bail|required|string|max:191|unique:promos,promo_name,{$promo_id},promo_id",
            "promo_started_at" => "required|date",
            "promo_finished_at" => "required|date|after:promo_started_at",
            "promo_desc" => "nullable|string",
            "promo_terms" => "nullable|string",
            "promo_banner" => "required|image|max:2048",
            "products" => "required|array",
            "products.*.product_id" => "required|integer",
            "products.*.promo_product_stock" => "required|integer|min:1",
            "products.*.promo_price_supplier" => "required|numeric|min:0",
            "products.*.promo_price_selling" => "required|numeric|min:1|gte:products.*.promo_price_supplier",
        ];

        return $request->validate($validate);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $promos = Promo::withCount('relatedProducts')->get();

        return view('promo::index', ['promos' => $promos]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $products = Product::all();

        return view('promo::create', ['products' => $products]);
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
            DB::beginTransaction();

            if ($request->has('promo_banner')) {
                if (App::environment('production')) {
                    $image_name = $request->file('promo_banner')->getRealPath();
                    Cloudder::upload($image_name, null, array(
                        'folder' => 'images/promo',
                        'overwrite' => true,
                        'resource_type' => 'image'
                    ));

                    list($width, $height) = getimagesize($image_name);
                    $promo_banner = Cloudder::secureShow(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
                    $path = $promo_banner;
                } else {
                    $image_name = Str::slug($validated_data['promo_name']) . '.' . $request->file('promo_banner')->getClientOriginalExtension();
                    $path = $request->file('promo_banner')->storeAs(
                        'images/category', $image_name, 'public'
                    );
                }

                $validated_data['promo_banner'] = $path;
            }
            $promo = Promo::with('relatedProducts')->create($validated_data);

            foreach ($validated_data['products'] as $product) {
                $promo->relatedProducts()->attach($product['product_id'], [
                    'promo_product_stock' => $product['promo_product_stock'],
                    'promo_price_supplier' => $product['promo_price_supplier'],
                    'promo_price_selling' => $product['promo_price_selling'],
                ]);
            }

            DB::commit();

            return redirect('promo')->with('success', 'Berhasil menambah promo ' . $promo->promo_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param Promo $promo
     * @return Renderable
     */
    public function show(Promo $promo): Renderable
    {
        return view('promo::show', ['promo' => $promo]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Promo $promo
     * @return Renderable
     */
    public function edit(Promo $promo): Renderable
    {
        return view('promo::edit', ['promo' => $promo]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Promo $promo
     * @return RedirectResponse
     */
    public function update(Request $request, Promo $promo): RedirectResponse
    {
        $validated_data = $this->validate_data($request, $promo->promo_id);

        try {
            DB::beginTransaction();

            if ($request->has('promo_banner')) {
                if (App::environment('production')) {
                    Cloudder::delete($promo->promo_banner, array(
                        'resource_type' => 'image'
                    ));

                    $image_name = $request->file('promo_banner')->getRealPath();
                    Cloudder::upload($image_name, null, array(
                        'folder' => 'images/promo',
                        'overwrite' => true,
                        'resource_type' => 'image'
                    ));

                    list($width, $height) = getimagesize($image_name);
                    $promo_banner = Cloudder::secureShow(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
                    $path = $promo_banner;
                } else {
                    Storage::disk('public')->delete($promo->promo_banner);
                    $image_name = Str::slug($validated_data['promo_name']) . '.' . $request->file('promo_banner')->getClientOriginalExtension();
                    $path = $request->file('promo_banner')->storeAs(
                        'images/promo', $image_name, 'public'
                    );
                }

                $validated_data['promo_banner'] = $path;
            }
            $promo->update($validated_data);

            DB::commit();

            return redirect()->route('promo.index')->with('success', 'Berhasil mengubah promo ' . $promo->promo_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Promo $promo
     * @return RedirectResponse
     */
    public function destroy(Promo $promo): RedirectResponse
    {
        try {
            DB::beginTransaction();

            if (App::environment('production')) {
                Cloudder::delete($promo->promo_banner, array(
                    'resource_type' => 'image'
                ));
            } else {
                Storage::disk('public')->delete($promo->promo_banner);
            }
            $promo->relatedProducts()->detach();
            $promo->delete();

            DB::commit();

            return redirect()->route('promo.index')->with('success', 'Berhasil menghapus promo ' . $promo->promo_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }
}
