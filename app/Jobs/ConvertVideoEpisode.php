<?php

namespace App\Jobs;

use App\Models\Episode;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;

class ConvertVideoEpisode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $episode;

    CONSt path = 'uploads/movie/episode/';

    public function __construct(Episode $episode)
    {
        $this->episode = $episode;

    }

    public function handle()
    {
        $this->episode['path'] = self::path . $this->episode->video_url;
        $lowBitrate = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(250);
        $highBitrate = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(1000);
        FFMpeg::fromDisk('my_upload')
            ->open($this->episode->path)
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(480, 360));
            })
            ->export()
            ->toDisk('episode_480')
            ->inFormat($lowBitrate)
            ->save($this->episode->video_url)
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(720, 480));
            })
            ->export()
            ->toDisk('episode_720')
            ->inFormat($highBitrate)
            ->save($this->episode->video_url);
    }
}
