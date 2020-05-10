<?php
namespace App\Http\Controllers;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->role = 1;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success','token' => $token], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password'=>'required|confirmed|min:3',
            'password_confirmation'=>'min:3',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
                'request' => $request
            ], 422);
        }
        $user = new User;
        if ($request->hasFile('avatar_url')) {
            $imageName = time().'.'.$request->avatar_url->getClientOriginalName();
            $request->avatar_url->move(public_path('images'),$imageName);
            $user->avatar_url = $imageName;
        }
        $user->email = $request->email;
        $user->name = $request->name;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }


    public function reset(Request $request)
    {
        $user = User::where('remember_token', $request->token)->first();
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('/');
    }

    private function guard()
    {
        return Auth::guard();
    }
}
