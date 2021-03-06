<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Throwable;

class ProductPhotoController extends Controller
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
            "image_url" => "bail|required|image|max:2048",
            "image_alt_text" => "nullable|string",
        ];

        return $request->validate($validate);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @param int $product_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(int $product_id, Request $request): RedirectResponse
    {
        $validated_data = $this->validate_data($request);

        try {
            $product = Product::with('relatedPhotos')->findOrFail($product_id);

            if ($request->has('image_url')) {
                if (App::environment('production')) {
                    $image_name = $request->file('image_url')->getRealPath();
                    Cloudder::upload($image_name, null, array(
                        'folder' => 'images/product/' . $product->product_id,
                        'overwrite' => true,
                        'resource_type' => 'image'
                    ));

                    list($width, $height) = getimagesize($image_name);
                    $image_url = Cloudder::secureShow(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
                    $path = $image_url;
                } else {
                    $image_name = Str::slug($product->product_name) . '-' . time() . '.' . $request->file('image_url')->getClientOriginalExtension();
                    $path = $request->file('image_url')->storeAs(
                        'images/product/' . $product->product_id, $image_name, 'public'
                    );
                }

                $photo = new ProductPhoto([
                    'image_url' => $path,
                    'image_alt_text' => $validated_data['image_alt_text'],
                ]);
                $product->relatedPhotos()->save($photo);
            }

            return redirect()->route('product.show', $product->product_id)->with('messsage', 'Berhasil menambah gambar produk baru');
        } catch (Throwable $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ProductPhoto $productPhoto
     * @return Response
     */
    public function show(ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProductPhoto $productPhoto
     * @return Response
     */
    public function edit(ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ProductPhoto $productPhoto
     * @return Response
     */
    public function update(Request $request, ProductPhoto $productPhoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $product_id
     * @param int $productPhoto
     * @return RedirectResponse
     */
    public function destroy(int $product_id, int $productPhoto): RedirectResponse
    {
        try {
            $photo = ProductPhoto::findOrFail($productPhoto);
            if (isset($photo->image_url)) {
                if (App::environment('production')) {
                    Cloudder::delete($photo->image_url, array(
                        'resource_type' => 'image'
                    ));
                } else {
                    if (Storage::disk('public')->exists($photo->image_url)) {
                        Storage::disk('public')->delete($photo->image_url);
                    }
                }
            }
            $photo->delete();

            return back()->with('success', 'Berhasil menghapus gambar!');
        } catch (Throwable $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
