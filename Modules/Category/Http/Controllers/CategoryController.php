<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Category\Entities\Category;
use Throwable;

class CategoryController extends Controller
{
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
    public function index(): Renderable
    {
        $categories = Category::withCount('relatedProducts')->get();

        return view('category::index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('category::create');
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

            if ($request->has('category_icon')) {
                $imageName = Str::slug($validated_data['category_name']) . '.' . $request->file('category_icon')->getClientOriginalExtension();
                $request->category_icon->storeAs('public/images/category/', $imageName);
                $validated_data['category_icon'] = 'storage/images/category/' . $imageName;
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
     * @param Category $category
     * @return Renderable
     */
    public function show(Category $category): Renderable
    {
        return view('category::show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Category $category
     * @return Renderable
     */
    public function edit(Category $category): Renderable
    {
        return view('category::edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated_data = $this->validate_data($request, $category->category_id);

        try {
            DB::beginTransaction();

            if ($request->has('category_icon')) {
                Storage::delete('public/images/category/' . substr($category->category_icon, 23));
                $imageName = Str::slug($validated_data['category_name']) . '.' . $request->file('category_icon')->getClientOriginalExtension();
                $request->category_icon->storeAs('public/images/category/', $imageName);
                $validated_data['category_icon'] = 'storage/images/category/' . $imageName;
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
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            DB::beginTransaction();

            Storage::delete('public/images/category/' . substr($category->category_icon, 23));
            $category->delete();

            DB::commit();

            return redirect()->route('category.index')->with('success', 'Berhasil menghapus kategori ' . $category->category_name);
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }
}
