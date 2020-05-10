<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Services\PayUService\Exception;
use DB;

class TagController extends Controller
{
    CONST convertCreateInputName = [
        'name' => 'name',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = Tag::_buildTags($request);
        return response()->json([
            'status' => 'success',
            'tags' => $tags,
        ], 200);
    }

    public function data()
    {
        return response()->json([
            'status' => 'success',
            'tags' => Tag::getAll(),
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
    public function store(TagRequest $request)
    {
        try {
            $tag = new Tag();
            $tag->name = $request->name;

            if ($tag->save()) {
                return response()->json([
                    'status' => 'success',
                    'tag' => $tag
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
    public function show(Tag $tag)
    {
        return response()->json([
            'status' => 'success',
            'tag' => $tag,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
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
    public function update(TagRequest $request, Tag $tag)
    {
        //
        try {
            $tag->name = $request->name;

            if ($tag->update()) {
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
    public function destroy(Tag $tag)
    {
        if ($tag->delete()) {
            DB::table('tag_movies')->where('tag_id', '=', $tag->id)->delete();
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
            if (Tag::whereIn('id', $request->params)->delete()) {
                DB::table('tag_movies')->whereIn('tag_id', $request->params)->delete();
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
