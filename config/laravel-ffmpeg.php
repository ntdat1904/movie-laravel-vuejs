<?php

return [
    'default_disk' => 'local',
    'ffmpeg' => [
        'binaries' => env('FFMPEG_BINARIES') ,
        'threads' => 12,
    ],
    'ffprobe' => [
        'binaries' => env('FFPROBE_BINARIES') ,
    ],
    'timeout' => 30000,
];
