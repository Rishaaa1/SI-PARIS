<?php

return [
    'paths' => [
        resource_path('views'),
    ],

    // Gunakan path absolut Laravel tanpa realpath() agar cache path
    // tetap valid meskipun realpath() gagal menemukan folder saat boot.
    'compiled' => env('VIEW_COMPILED_PATH', storage_path('framework/views')),
];
