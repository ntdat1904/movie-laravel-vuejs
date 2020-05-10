<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function getAll(Request $request)
    {
        $list = Country::orderBy('number_order','ASC')->get();
        return response()->json([
            'status' => 'success',
            'data' => $list
        ],200);
    }



}
