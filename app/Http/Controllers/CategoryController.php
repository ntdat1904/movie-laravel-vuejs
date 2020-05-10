<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::buildCategories($request);
        return response()->json([
            'status' => 'success',
            'categories' => $categories,
        ], 200);
    }

    public function data()
    {
        return response()->json([
            'status' => 'success',
            'categories' => Category::getAll(),
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        //
        try {
            $dataCategory = [];
            $dataCategory = $request->only(['name', 'number_order']);

            if (Category::create($dataCategory)) {
                return response()->json([
                    'status' => 'success',
                ], 200);
            }
            return response()->json([
                'status' => 'error',
            ], 500);

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        return response()->json([
            'status' => 'success',
            'category' => $category,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //
        try {
            $dataCategory = [];
            $dataCategory = $request->only(['name', 'number_order']);

            if ($category->fill($dataCategory)->save()) {
                return response()->json([
                    'status' => 'success',
                ], 200);
            }
            return response()->json([
                'status' => 'error',
            ], 500);

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category->delete()) {
            DB::table('category_movies')->where('category_id', '=', $id)->delete();
            return response()->json(
                [
                    'status' => 'success',
                ], 200);
        }
        return response()->json(
            [
                'status' => 'error',
            ], 500);
    }

    public function destroyMultiple(Request $request)
    {
        if (!empty($request->params)) {
            if (Category::whereIn('id', $request->params)->delete()) {
                DB::table('category_movies')->whereIn('category_id', $request->params)->delete();
                return response()->json(
                    [
                        'status' => 'success',
                    ], 200);
            }
        }
        return response()->json(
            [
                'status' => 'error',
            ], 200);
    }

}
