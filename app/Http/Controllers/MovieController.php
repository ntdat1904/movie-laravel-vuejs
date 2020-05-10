<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertVideoEpisode;
use App\Jobs\ConvertVideoForDownloading;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\ConvertVideoTrailer;
use App\Models\Country;
use App\Models\Tag;
use App\Models\Trailer;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\MemberMovie;

class MovieController extends Controller
{
    CONST convertCreateInputName = [
        'native_name' => 'native_name',
        'vietnamese_name' => 'vietnamese_name',
        'introduce' => 'introduce',
        'has_movie' => 'has_movie',
        'IMDb_scores' => 'IMDb_scores',
        'episode_number_current' => 'episode_number_current',
        'episode_number' => 'episode_number',
        'realease_year' => 'realease_year',
        'time' => 'time',
        'quality' => 'quality',
        'resolution' => 'resolution',
        'type_language' => 'type_language',
        'form' => 'form',
        'production_company' => 'production_company',
        'country_id' => 'country_id',
    ];

    CONST AVATAR_FOLDER = 'uploads/movie';

    CONST TRAILER_FOLDER = 'uploads/movie/trailer';

    CONST DRAFT_FOLDER = 'uploads/draft/';

    CONST EPISODE_FOLDER = 'uploads/movie/episode';


    CONST ROOT_FOLDER = '/files/';

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $movies = Movie::_buildMoviesAdmin($request);
        return response()->json(
            [
                'status' => 'success',
                'movies' => $movies
            ], Response::HTTP_OK);
    }

    public function data()
    {
        $movie = Movie::with('countries')->get();

        return response()->json(
            [
                'status' => 'success',
                'movie' => $movie->toArray(),
            ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request)
    {
        DB::beginTransaction();
        try {
            $dataRequest = $request->all(array_keys(self::convertCreateInputName));
            $trailers = $request['trailers'];
            $episodes =  $request['episodes'];
            $movies = new Movie;

            if ($request->hasFile('avatar_url')) {
                $file = $request->file('avatar_url');
                $imageName = $file->store(self::AVATAR_FOLDER, 'my_upload');
                $dataRequest['avatar_url'] = self::ROOT_FOLDER . $imageName;
            }
            $dataRequest['country_id'] = json_encode(explode(',', $request['countries']));

            $members = [];
            foreach (json_decode($request->actors) as $member) {
                $members[] = [$member->id => ['name_in_movie' => $member->name]];
            }

            if ($movies->fill($dataRequest)->save()) {

                $movies->countries()->attach(explode(',', $request->countries));
                $movies->categories()->attach(explode(',', $request->categories));
                $movies->tags()->attach(explode(',', $request->tags));
                // trailers
                foreach ($trailers as $item) {
                    if (!empty($item)) {
                        $trailer = new Trailer();
                        $trailer->movie_id = $movies->id;
                        $trailer->number_view = 0;
                        $trailer->video_url = $item;
                        $trailer->save();
                        if (!filter_var($item, FILTER_VALIDATE_URL) && Storage::disk('my_upload')->exists('uploads/draft/' . $item)) {
                            Storage::disk('my_upload')->move(self::DRAFT_FOLDER . $item, self::TRAILER_FOLDER . '/' . $item);
                            ConvertVideoForStreaming::dispatch($trailer);
                        }
                    }
                }

                // episodes
                $i = 1;
                foreach ($episodes as $item) {
                    if (!empty($item)) {
                        $episode = new Episode();
                        $episode->movie_id = $movies->id;
                        $episode->episode = $i;
                        $episode->number_view = 0;
                        $episode->video_url = $item;
                        $episode->save();
                        if (!filter_var($item, FILTER_VALIDATE_URL)) {
                            Storage::disk('my_upload')->move(self::DRAFT_FOLDER . $item, self::EPISODE_FOLDER . '/' . $item);
                            ConvertVideoEpisode::dispatch($episode);
                        }
                        $i++;
                    }
                }

                foreach ($members as $member) {
                    $movies->members()->attach($member);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                [
                    'status' => 'error',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'status' => 'success',
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {

        $movie->img = false;
        if (!empty($movie->avatar_url) && Storage::disk('my_upload')->exists(str_replace(self::ROOT_FOLDER, '', $movie->avatar_url))) {
            $movie->img = true;
        }
        $array_trailers = [];
        $trailers = $movie->trailer()->get();
        foreach ($trailers as $trailer) {
            $url = str_replace(self::ROOT_FOLDER, '', $trailer->video_url);
            if (Storage::disk('my_upload')->exists($url)) {
                $array_trailers[] = [
                    'url' => url('/') . $trailer->video_url,
                    'type' => 'file',
                    'id' => $trailer->id
                ];
            } else {
                $array_trailers[] = [
                    'url' => $trailer->video_url,
                    'type' => 'url',
                    'id' => $trailer->id
                ];
            }
        }
        $members = $movie->members;
        $episodes = $movie->episode()->orderBy('episode', 'ASC')->get(['episodes.id', 'episodes.video_url', 'episodes.episode']);
        $detail = $movie->memberMovie;

        return response()->json(
            [
                'status' => 'success',
                'movie' => $movie,
                'countries' => $movie->countries()->get(['countries.id', 'countries.name']),
                'tags' => $movie->tags()->get(['tags.id', 'tags.name']),
                'categories' => $movie->categories()->get(['categories.id', 'categories.name']),
                'trailers' => $array_trailers,
                'episodes' => $episodes,
                'detail' => $detail,
                'members' => $members,
            ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(MovieRequest $request, Movie $movie)
    {
        DB::beginTransaction();
        try {
            $dataRequest = $request->all(array_keys(self::convertCreateInputName));
            $trailers = $request['trailers'];
            $episodes = $request['episodes'];

            if ($request->hasFile('avatar_url')) {
                $file = $request->file('avatar_url');
                $imageName = $file->store(self::AVATAR_FOLDER, 'my_upload');
                $url = str_replace(self::ROOT_FOLDER, '', $movie->avatar_url);
                Storage::disk('my_upload')->delete($url);
                $dataRequest['avatar_url'] = self::ROOT_FOLDER . $imageName;
            }

            $members = [];

            foreach (json_decode($request->actors) as $member) {
                $members[] = [$member->id => ['name_in_movie' => $member->name]];
            }

            MemberMovie::where('movie_id', $movie->id)->delete();

            $dataRequest['country_id'] = json_encode(explode(',', $request['countries']));
            if ($movie->fill($dataRequest)->save()) {

                $currentCountries = $movie->countries()->pluck('countries.id')->toArray();

                $request->countries = isset($request->countries) ? $request->countries : [];
                $request->countries = explode(',', $request->countries);
                if (array_merge(array_diff($currentCountries, $request->countries), array_diff($request->countries, $currentCountries))) {
                    $movie->countries()->sync($request->countries);
                }

                $currentTags = $movie->tags()->pluck('tags.id')->toArray();
                $request->tags = isset($request->tags) ? $request->tags : [];
                $request->tags = explode(',', $request->tags);
                if (array_merge(array_diff($currentTags, $request->tags), array_diff($request->tags, $currentTags))) {
                    $movie->tags()->sync($request->tags);
                }

                $currentCategories = $movie->categories()->pluck('categories.id')->toArray();
                $request->categories = isset($request->categories) ? $request->categories : [];
                $request->categories = explode(',', $request->categories);
                if (array_merge(array_diff($currentCategories, $request->categories), array_diff($request->categories, $currentCategories))) {
                    $movie->categories()->sync($request->categories);
                }

                // trailers
                foreach ($trailers as $item) {
                    if (!empty($item)) {
                        $trailer = new Trailer();
                        $trailer->movie_id = $dataRequest['id'];
                        $trailer->number_view = 0;
                        $trailer->video_url = $item;
                        $trailer->save();
                        if (!filter_var($item, FILTER_VALIDATE_URL) && Storage::disk('my_upload')->exists('uploads/draft/' . $item)) {
                            Storage::disk('my_upload')->move(self::DRAFT_FOLDER . $item, self::TRAILER_FOLDER . '/' . $item);
                            ConvertVideoForStreaming::dispatch($trailer);
                        }
                    }
                }
                // Episode
                foreach ($episodes as $item) {
                    if (!empty($item)) {
                        $episode = new Episode();
                        $episode->movie_id = $dataRequest['id'];
                        $episode->number_view = 0;
                        $episode->video_url = $item['video_url'];
                        $episode->episode = $item['episode'];
                        $episode->save();
                        if (!filter_var($item['video_url'], FILTER_VALIDATE_URL ) && Storage::disk('my_upload')->exists('uploads/draft/' . $item['video_url'])) {
                            Storage::disk('my_upload')->move(self::DRAFT_FOLDER . $item['video_url'], self::EPISODE_FOLDER . '/' . $item['video_url']);
                            ConvertVideoEpisode::dispatch($episode);
                        }
                    }
                }

                foreach ($members as $member) {
                    $movie->members()->attach($member);
                }
            }

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            return response()->json(
                [
                    'status' => 'error',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
        };
        return response()->json([
            'status' => 'success',
            'request' => $request->all(),
        ], Response::HTTP_OK);
    }

    public function destroy(Movie $movie)
    {
        $trailers = $movie->trailer()->get();
        $episodes = $movie->episode()->get();
        if ($movie->delete()) {
            foreach ($trailers as $trailer) {
                Trailer::_remove($trailer);
            }

            foreach ($episodes as $episode) {
                Episode::_remove($episode);
            }

            return response()->json(
                [
                    'status' => 'success',
                ], Response::HTTP_OK);
        }
        return response()->json(
            [
                'status' => 'error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function destroyMultiple(Request $request)
    {
        if (!empty($request->params)) {
            foreach (Movie::whereIn('id', $request->params)->get() as $movie) {
                $trailers = $movie->trailer()->get();
                $episodes = $movie->episode()->get();

                foreach ($trailers as $trailer) {
                    Trailer::_remove($trailer);
                }

                foreach ($episodes as $episode) {
                    Episode::_remove($episode);
                }
                $movie->delete();
            }

            return response()->json(
                [
                    'status' => 'success',
                ], Response::HTTP_OK);
        }
        return response()->json(
            [
                'status' => 'error',
            ], Response::HTTP_OK);
    }

    public function country()
    {
        $country = Country::all(['id', 'country_name']);

        return response()->json(
            [
                'status' => 'success',
                'country' => $country
            ], Response::HTTP_OK);
    }

    public function getMovies()
    {
        $movie = Movie::all(['id', 'native_name']);

        return response()->json(
            [
                'status' => 'success',
                'movie' => $movie->toArray()
            ], Response::HTTP_OK);
    }

}
