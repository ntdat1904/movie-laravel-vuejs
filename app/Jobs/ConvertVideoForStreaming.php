<?php

namespace App\Jobs;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $trailer;

    CONSt path = 'uploads/movie/trailer/';

    public function __construct($trailer)
    {
        $this->trailer = $trailer;

    }

    public function handle()
    {
        $this->trailer['path'] = self::path . $this->trailer->video_url;
        $lowBitrate = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(250);
        $highBitrate = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(1000);
        FFMpeg::fromDisk('my_upload')
            ->open($this->trailer->path)
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(480, 360));
            })
            ->export()
            ->toDisk('trailer_480')
            ->inFormat($lowBitrate)
            ->save($this->trailer->video_url)
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(720, 480));
            })
            ->export()
            ->toDisk('trailer_720')
            ->inFormat($highBitrate)
            ->save($this->trailer->video_url);
    }
}
