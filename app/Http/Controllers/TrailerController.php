<?php

namespace App\Http\Controllers;

use App\Models\Trailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class TrailerController extends Controller
{

    public  function destroy(Trailer $trailer)
    {
        Trailer::_remove($trailer);
        return response()->json(
            [
                'status' => 'success',
            ], Response::HTTP_OK);
    }

    public function view(Trailer $trailer)
    {
        $trailer['number_view'] = $trailer['number_view'] + 1;
        $trailer->save();
        return response()->json(
            [
                'status' => 'success',
            ], Response::HTTP_OK);
    }
}
