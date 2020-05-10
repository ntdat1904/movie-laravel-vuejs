<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertVideoEpisode;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Episode\EpisodeRequest;
use Illuminate\Support\Facades\Storage;

class EpisodeController extends Controller
{

    CONST EPISODE_FOLDER = 'uploads/movie/episode';

    CONST ROOT_FOLDER = '/files/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Episode $episode)
    {
        $episode->video_url = $episode->video_url;
        return response()->json(
            [
                'status' => 'success',
                'episode' => $episode->toArray()
            ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EpisodeRequest $request, Episode $episode)
    {
        $dataRequest = [];
        foreach ($request->only(['episode', 'video_url']) as $key => $item) {
            (!empty($item)) ? $dataRequest[$key] = $item : '';
        }
        if (!empty($dataRequest['video_url'])) {
            if (filter_var($dataRequest['video_url'], FILTER_VALIDATE_URL)) {
                Storage::disk('my_upload')->delete(
                    [
                        Episode::EPISODE_FOLDER . $episode->video_url,
                        Episode::EPISODE_480_FOLDER . $episode->video_url,
                        Episode::EPISODE_720_FOLDER . $episode->video_url
                    ]);
                $episode->fill($dataRequest)->save();
            } else if (!Storage::disk('my_upload')->exists('uploads/draft/' . $dataRequest['video_url'])) {

                Storage::disk('my_upload')->delete(
                    [
                        Episode::EPISODE_FOLDER . $episode->video_url,
                        Episode::EPISODE_480_FOLDER . $episode->video_url,
                        Episode::EPISODE_720_FOLDER . $episode->video_url
                    ]);
                $episode->fill($dataRequest)->save();
                Storage::disk('my_upload')->move('uploads/draft/' . $dataRequest['video_url'], Episode::EPISODE_FOLDER . $dataRequest['video_url']);
                ConvertVideoEpisode::dispatch($episode);
            }
        } else {
            $episode->fill($dataRequest)->save();
        }

        return response()->json(
            [
                'status' => 'success',
                'episode' => $episode->toArray()
            ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Episode $episode)
    {
        Episode::_remove($episode);
        return response()->json(
            [
                'status' => 'success',
            ], Response::HTTP_OK);
    }

    public function view(Episode $episode)
    {
        $episode['number_view'] = $episode['number_view'] + 1;
        $episode->save();
        $movie = Movie::find($episode->movie_id);
        if ($movie->form === 'Odd') {
            $movie['number_view'] = $episode['number_view'];
        } else {
            $allEpisode = Episode::where('movie_id', $movie->id)->get();
            $point = 0;
            foreach ($allEpisode as $item) {
                $point += $item->number_view;
            }
            $movie['number_view'] = ceil($point / $allEpisode->count());
        }
        $movie->save();
        return response()->json(
            [
                'status' => 'success',
                'result' => $episode
            ], Response::HTTP_OK);
    }
}
