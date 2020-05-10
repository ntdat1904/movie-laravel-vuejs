<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Movie;
use View;
use App\Http\Controllers\Controller;

class BaseUserController extends Controller
{

    public function __construct()
    {
        $fillSelect = ["id","native_name","vietnamese_name","avatar_url","number_view","realease_year","type_language","resolution"];

        $gCategories = Category::listCategory(10);
        $gCountries = Country::listCountries(10);
        $gOddLastest = Movie::select($fillSelect)->where('form', 'like', 'Odd')->latest()->limit(10)->get();
        $gSetLastest = Movie::select($fillSelect)->where('form', 'like', 'Set')->latest()->limit(10)->get();
        $gViewHighest = Movie::select($fillSelect)->where('has_movie', 1)->orderBy('number_view', 'desc')->limit(10)->get();
        $gRealease = Movie::select($fillSelect)->where('has_movie', 0)->orderBy('realease_year', 'desc')->limit(10)->get();
        View::share([
            'gCategories' => $gCategories,
            'gCountries' => $gCountries,
            'gOddLastest' => $gOddLastest,
            'gSetLastest' => $gSetLastest,
            'gViewHighest' => $gViewHighest,
            'gRealease' => $gRealease,
        ]);
    }
}
