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

class ConvertVideoForDownloading implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $upload;

    CONSt path = 'uploads/draft/';
    CONSt pathExport480 = 'uploads/movie/episode/480/';
    CONSt pathExport720 = 'uploads/movie/episode/720/';

    public function __construct($upload)
    {
        $this->upload = $upload;

    }

    public function handle()
    {
        $this->upload['path'] = self::path . $this->upload->url;
        $lowBitrate = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(250);
        $highBitrate = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(1000);
        FFMpeg::fromDisk('my_upload')
            ->open($this->upload->path)
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(480, 360));
            })
            ->export()
            ->toDisk('episode_480')
            ->inFormat($lowBitrate)
            ->save("480p_" . $this->upload->url)
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(720, 480));
            })
            ->export()
            ->toDisk('episode_720')
            ->inFormat($highBitrate)
            ->save("720p_" . $this->upload->url);
    }
}
