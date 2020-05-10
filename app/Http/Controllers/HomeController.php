<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\Category;
use App\Models\Member;
use App\Models\UseLikes;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Tag;
use App\Models\Trailer;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class HomeController extends BaseUserController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $data = [
            'history' => self::history(),
        ];
        return view('index',$data);
    }

    public function search(Request $request)
    {
        $dataRequest = [];
        foreach ($request->all() as $key => $item) {
            if (!empty($item)) {
                $dataRequest[$key] = $item;
            }
        }
        $movies = Movie::builderMovie($dataRequest)->paginate(12);
        $data = [
            'categories' => Category::has('movie')->get(),
            'countries' => Country::has('movie')->get(),
            'movies' => $movies,
            'oldData' => $dataRequest,
        ];
        return view('search', $data);
    }

    public function ranking()
    {
        $odd = Movie::where('form', 'like', 'Odd')->latest()->limit(10)->get();
        $set = Movie::where('form', 'like', 'Set')->latest()->limit(10)->get();
        $view = Movie::orderBy('number_view', 'desc')->limit(10)->get();
        $has = Movie::where('has_movie', 0)->orderBy('realease_year', 'desc')->limit(10)->get();
        $tags = Tag::has('movie')->limit(15)->get();
        $data = [
            'odd' => $odd,
            'set' => $set,
            'view' => $view,
            'has' => $has,
            'tags' => $tags
        ];
        return response()->json(
            [
                'status' => 'success',
                'data' => $data
            ], Response::HTTP_OK);
    }

    public function detail(Movie $movie)
    {
        $cookie_history = json_decode(Cookie::get('cookie-history'));
        if(empty($cookie_history)) {
            $data_cookie[]= $movie->id;
            Cookie::queue('cookie-history', json_encode([$movie->id]),2628000);
        } else {
            if(array_search($movie->id,$cookie_history) === false) {
                $cookie_history[] = $movie->id;
                Cookie::queue('cookie-history', json_encode($cookie_history),2628000);
            }
        }

        $movie['country_id'] = implode(Country::whereIn('id', json_decode($movie->country_id))->pluck('name')->toarray(), ', ');
        $movie['category'] = implode($movie->categories()->pluck('name')->toarray(), " ,");
        $movie['tags'] = $movie->tags()->pluck('name')->toarray();
        $movie['other'] = Movie::inRandomOrder()->limit(8)->get();
        $movie['members'] = Movie::getListMemberByMovie($movie->id);
        $movie['episodes'] = $movie->episode()->get();
        $movie['trailers'] = $movie->trailer()->get();
        $data = [
            'movie' => $movie,
        ];
        return view('detail', $data);
    }


    public function cast(Member $member)
    {
        $member['other'] = Movie::inRandomOrder()->limit(8)->get();
        $member['movies'] = $member->movies;
        $data = [
            'member' => $member,
        ];
        return view('cast', $data);
    }


    public function watch(Movie $movie, $id)
    {
        $data = [
            'episodes' => Episode::where('movie_id', $movie->id)->get(),
            'episode' => Episode::where('episode', $id)
                ->where('movie_id', $movie->id)->first(),
            'movie' => $movie,
            'tags' => $movie->tags()->pluck('name')->toarray(),
            'other' => Movie::inRandomOrder()->limit(8)->get(),
        ];
        return view('watch', $data);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return back();
        }
        return back()->withErrors(['message' => 'some thing wrong!'], 'login');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        return back();

    }

    public function register(AuthRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();
        return back();
    }

    public function rating(Request $request)
    {
        $currentUser = $this->guard()->user();
        if ($currentUser) {
            $like = UseLikes::where('movie_id', $request->movie_id)
                ->where('user_id', $currentUser->id)->first();
            $data = $request->only(['movie_id', 'point']);
            if (!$like) {
                $like = new UseLikes();
                $data['user_id'] = $currentUser->id;
            }
            $like->fill($data)->save();
            $movie = Movie::find($data['movie_id']);
            $likes = UseLikes::where('movie_id', $data['movie_id'])->get();
            $total = 0;
            foreach ($likes as $like) {
                $total += $like->point;
            }
            $movie->number_like =($total / ($likes->count()));
            $movie->save();
        }
        return response()->json(
            [
                'status' => 'success',
            ], Response::HTTP_OK);
    }

    private function guard()
    {
        return Auth::guard('user');
    }

    private function history()
    {
        $cookie_history = json_decode(Cookie::get('cookie-history'));
        $movies =[];
        if(!empty($cookie_history)) {
            $movies = Movie::whereIn('id',array_values($cookie_history))->limit(10)->get();
        }
        return $movies;
    }
}

