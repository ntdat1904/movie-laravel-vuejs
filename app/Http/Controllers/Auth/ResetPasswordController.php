<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\Category;
use App\Models\Country;
use App\Models\Movie;
use Illuminate\Http\Request;
use View;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

}
