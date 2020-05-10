<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ResetPassword;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\Category;
use App\Models\Country;
use App\Models\Movie;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use View;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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

//    public function validateEmail(Request $request)
//    {
//        $request->validate(['email' => 'required|email|exists:users,email']);
//    }

    public function sendResetLinkEmail(ResetPassword $request)
    {
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }
}
