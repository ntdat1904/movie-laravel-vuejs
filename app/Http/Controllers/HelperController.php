<?php

namespace App\Http\Controllers;

use App\Models\Uploads;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;

class HelperController extends Controller
{

    CONST AVATAR_FOLDER = 'uploads/draft';

    CONST ROOT_FOLDER = '/files/';

    //
    public function store(Request $request)
    {
        if ($request->file('file')) {
            return response()->json(['success' => 'You have successfully uploaded an image'], 200);
        }
        return response()->json(['error' => 'uploaded an image has fail'], 500);
    }

    public function checkImages($url)
    {
        if (File::exists(public_path('images/' . $url))) {
            return response()->json(['error' => 'File is exists.'], 200);
        } else {
            return response()->json(['success' => 'File is not exists.'], 404);
        }
    }

    public function destroy(Uploads $upload)
    {
        if ($upload->delete()) {
            $url = str_replace(self::ROOT_FOLDER, '', $upload->url);
            Storage::disk('my_upload')->delete(self::AVATAR_FOLDER . '/' . $url);
            return response()->json(['success' => 'Deleted!'], 200);
        }
        return response()->json(['error' => 'Fail.'], 404);
    }

    public function uploadVideo(Request $request)
    {
        $dataInsert = $request->only(['use_id']);
        if ($request->file('file')) {

            $file = $request->file('file');
            $imageName = $file->store(self::AVATAR_FOLDER, 'my_upload');
            $dataInsert['url'] = str_replace(self::AVATAR_FOLDER . '/', '', $imageName);
            $upload = Uploads::create($dataInsert);
            return response()->json([
                'id' => $upload->id,
                'index' => $request['index'],
                'name' => $request['name'],
                'type' => $request['type'],
                'path' => $upload->url,
            ], 200);
        }
        return response()->json(['error' => 'uploaded an image has fail'], 500);
    }

    public function destroys()
    {
        $id = auth()->user()->id;
        $uploads = Uploads::where('use_id', $id)->get();
        foreach ($uploads as $upload) {
                $url = str_replace(self::ROOT_FOLDER, '', $upload->url);
                Storage::disk('my_upload')->delete(self::AVATAR_FOLDER . '/' . $url);
                $upload->delete();
        }
        return response()->json(['success' => 'Deleted!'], 200);
    }
}
