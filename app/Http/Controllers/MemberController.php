<?php

namespace App\Http\Controllers;

use App\Models\MemberMovie;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Member\storeRequest;
use App\Http\Requests\Member\updateRequest;
use File;
use Illuminate\Http\Response;
use DB;

class MemberController extends Controller
{
    CONST convertCreateInputName = [
        'country_id' => 'country_id',
        'weight' => 'weight',
        'height' => 'height',
        'introduce' => 'introduce',
        'name' => 'name',
        'type' => 'type'
    ];

    CONST convertUpdateInputName = [
        'country_id' => 'country_id',
        'weight' => 'weight',
        'height' => 'height',
        'introduce' => 'introduce',
        'name' => 'name',
        'type' => 'type'
    ];
    CONST selectField = [
        'country' => 'country_id',
        'weight' => 'weight',
        'height' => 'height',
        'introduce' => 'introduce',
        'name' => 'name',
        'type' => 'type'
    ];

    CONST AVATAR_FOLDER = 'uploads/member';

    CONST ROOT_FOLDER = '/files/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $members = Member::buildMembers($request);
        return response()->json(
            [
                'status' => 'success',
                'members' => $members
            ], 200);
    }

    public function data()
    {
        $members = Member::getList();
        return response()->json(
            [
                'status' => 'success',
                'members' => $members
            ], 200);
    }


    public function show(Member $member)
    {

        $member->img = false;
        if (!empty($member->avatar_url) && Storage::disk('my_upload')->exists(str_replace(self::ROOT_FOLDER, '', $member->avatar_url))) {
            $member->img = true;
        }
        $movies = $member->movies;
        foreach ($movies as $movie) {
            $movie['name'] = $movie->native_name;
        }
        $country = $member->country;
        $detail = $member->memberMovie;
        return response()->json(
            [
                'status' => 'success',
                'members' => $member,
                'movies' => $movies,
                'country' => $country,
                'detail' => $detail,

            ], 200);
    }

    public function getList(Request $request)
    {
        $filter = $request->all(['page', 'field_sort', 'sort_type', 'per_page']);
        $list = Member::getListMember($filter);

        foreach ($list as $key => $value) {
            $value->avatar_url = Storage::disk('my_upload')->url($value->avatar_url);
            $value->height = number_format($value->height, 2);
        }

        return response()->json([
            'status' => 200,
            'data' => $list ?? []
        ], 200);
    }

    public function destroy(Member $member)
    {
        if ($member->delete()) {
            return response()->json(
                [
                    'status' => 'success',
                ], 200);
        }
        return response()->json(
            [
                'status' => 'error',
            ], 200);
    }

    public function destroyMultiple(Request $request)
    {
        if (!empty($request->params)) {
            if (Member::whereIn('id', $request->params)->delete()) {
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

    public function addNew(storeRequest $request)
    {
        $dataRequest = $request->all(array_keys(self::convertCreateInputName));
        $member = new Member();
        $movies = [];
        foreach (json_decode($request->actors) as $movie) {
            $movies[] = [$movie->id => ['name_in_movie' => $movie->name]];
        }
        foreach ($dataRequest as $key => $value) {
            $member[self::convertCreateInputName[$key]] = $value;
        }

        if ($request->hasFile('avatar_url')) {
            $file = $request->file('avatar_url');
            $imageName = $file->store(self::AVATAR_FOLDER, 'my_upload');
            $member['avatar_url'] = self::ROOT_FOLDER . $imageName;
        }
        if ($member->save()) {
            foreach ($movies as $movie) {
                $member->movies()->attach($movie);
            }

            return response()->json([
                'status' => 'success',
                'data' => $member,
            ], 200);
        }

        return response()->json([
            'status' => 'has_error'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update(updateRequest $request, Member $member)
    {
        DB::beginTransaction();
        try {
            if ($member) {
                $dataRequest = $request->all(array_keys(self::convertUpdateInputName));
                $dataUpdate = [];
                foreach ($dataRequest as $key => $value) {
                    $dataUpdate[self::convertUpdateInputName[$key]] = $value;
                }
                $movies = [];
                foreach (json_decode($request->actors) as $movie) {
                    $movies[] = [$movie->id => ['name_in_movie' => $movie->name]];
                }
                MemberMovie::where('member_id', $member->id)->delete();
                if ($request->hasFile('avatar_url')) {

                    $file = $request->file('avatar_url');
                    $imageName = $file->store(self::AVATAR_FOLDER, 'my_upload');
                    $dataUpdate['avatar_url'] = self::ROOT_FOLDER . $imageName;
//                    if (!empty($member->avatar_url)) {
                    $member->avatar_url = str_replace(self::ROOT_FOLDER, '', $member->avatar_url);
                    Storage::disk('my_upload')->delete($member->avatar_url);
//                    }
                }
                if ($member->fill($dataUpdate)->save()) {
                    foreach ($movies as $movie) {
                        $member->movies()->attach($movie);
                    }

                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'has_error'
            ], 500);
        }
        return response()->json([
            'status' => 'success',
        ], 200);

    }

    public function delete(Request $request)
    {
        $id = $request->id;
        if (Member::where('id', $id)->delete()) {
            return response()->json([
                'status' => 'success'
            ], 200);
        }

        return response()->json([
            'status' => 'has_error'
        ], 500);
    }

    public function detail(Member $member, Request $request)
    {
        if($member) {
            $member['movie'] = $member->movies()->paginate(4);
            return response()->json([
                'status' => 'success',
                'member' =>$member
            ], 200);
        }

        return response()->json([
            'status' => 'not_found'
        ], 404);
    }
}
