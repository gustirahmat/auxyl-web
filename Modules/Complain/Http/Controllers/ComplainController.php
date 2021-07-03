<?php

namespace Modules\Complain\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Modules\Category\Entities\Category;
use Modules\Complain\Entities\OrderComplain;

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

    protected function validate_data($request, $category_id = null)
    {
        $validate = [
            "category_name" => "bail|required|string|max:191|unique:categories,category_name,{$category_id},category_id",
            "category_icon" => "nullable|image|max:2048",
            "category_gender" => "required|integer",
        ];

        return $request->validate($validate);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
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
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated_data = $this->validate_data($request);

        try {
            DB::beginTransaction();

            if ($request->has('category_icon')) {
                if (App::environment('production')) {
                    $image_name = $request->file('category_icon')->getRealPath();
                    Cloudder::upload($image_name, null, array(
                        'folder' => 'images/category',
                        'overwrite' => true,
                        'resource_type' => 'image'
                    ));

                    list($width, $height) = getimagesize($image_name);
                    $category_icon = Cloudder::secureShow(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
                    $path = $category_icon;
                } else {
                    $image_name = Str::slug($validated_data['category_name']) . '.' . $request->file('category_icon')->getClientOriginalExtension();
                    $path = $request->file('category_icon')->storeAs(
                        'images/category', $image_name, 'public'
                    );
                }

                $validated_data['category_icon'] = $path;
            }
            $category = Category::create($validated_data);

            DB::commit();

            return redirect('category')->with('success', 'Berhasil menambah kategori ' . $category->category_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('complain::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('complain::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validated_data = $this->validate_data($request, $category->category_id);

        try {
            DB::beginTransaction();

            if ($request->has('category_icon')) {
                if (App::environment('production')) {
                    Cloudder::delete($category->category_icon, array(
                        'resource_type' => 'image'
                    ));

                    $image_name = $request->file('category_icon')->getRealPath();
                    Cloudder::upload($image_name, null, array(
                        'folder' => 'images/category',
                        'overwrite' => true,
                        'resource_type' => 'image'
                    ));

                    list($width, $height) = getimagesize($image_name);
                    $category_icon = Cloudder::secureShow(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
                    $path = $category_icon;
                } else {
                    Storage::disk('public')->delete($category->category_icon);
                    $image_name = Str::slug($validated_data['category_name']) . '.' . $request->file('category_icon')->getClientOriginalExtension();
                    $path = $request->file('category_icon')->storeAs(
                        'images/category', $image_name, 'public'
                    );
                }

                $validated_data['category_icon'] = $path;
            }
            $category->update($validated_data);

            DB::commit();

            return redirect()->route('category.index')->with('success', 'Berhasil mengubah kategori ' . $category->category_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            if (App::environment('production')) {
                Cloudder::delete($category->category_icon, array(
                    'resource_type' => 'image'
                ));
            } else {
                Storage::disk('public')->delete($category->category_icon);
            }
            $category->delete();

            DB::commit();

            return redirect()->route('category.index')->with('success', 'Berhasil menghapus kategori ' . $category->category_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }
}
