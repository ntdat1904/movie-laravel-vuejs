<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class UserController extends Controller
{

    CONST AVATAR_FOLDER = 'uploads/user';

    CONST ROOT_FOLDER = '/files/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::_buildUsers($request);
        return response()->json(
            [
                'status' => 'success',
                'users' => $users
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
    public function store(UserRequest $request)
    {
        $dataInsert = $request->only('name', 'email', 'role');
        if ($request->hasFile('avatar_url')) {
            $file = $request->file('avatar_url');
            $imageName = $file->store(self::AVATAR_FOLDER, 'my_upload');
            $dataInsert['avatar_url'] = self::ROOT_FOLDER . $imageName;
        }
        $dataInsert['password'] = bcrypt($request->password);
        if (User::create($dataInsert)) {
            return response()->json([
                'status' => 'success',
                'data' => $dataInsert,
            ], 200);
        }
        return response()->json([
            'status' => 'has_error'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->img = false;
        if (!empty($user->avatar_url) && Storage::disk('my_upload')->exists(str_replace(self::ROOT_FOLDER, '', $user->avatar_url))) {
            $user->img = true;
        }
        return response()->json(
            [
                'status' => 'success',
                'user' => $user,
            ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, UserRequest $request)
    {
        $dataInsert = $request->only('name', 'email', 'role');
        if ($request->hasFile('avatar_url')) {
            $file = $request->file('avatar_url');
            $imageName = $file->store(self::AVATAR_FOLDER, 'my_upload');
            $dataInsert['avatar_url'] = self::ROOT_FOLDER . $imageName;
            $user->avatar_url = str_replace(self::ROOT_FOLDER, '', $user->avatar_url);
            Storage::disk('my_upload')->delete($user->avatar_url);
        }
        if ($user->fill($dataInsert)->save()) {
            return response()->json([
                'status' => 'success',
            ], 200);
        }
        return response()->json([
            'status' => 'has_error'
        ], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            $user->avatar_url = str_replace(self::ROOT_FOLDER, '', $user->avatar_url);
            Storage::disk('my_upload')->delete($user->avatar_url);
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
            $users = User::whereIn('id', $request->params)->get();
            foreach ($users as $user) {
                $user->avatar_url = str_replace(self::ROOT_FOLDER, '', $user->avatar_url);
                Storage::disk('my_upload')->delete($user->avatar_url);
            }
            if (User::whereIn('id', $request->params)->delete()) {
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

    private function guard()
    {
        return Auth::guard();
    }
}
