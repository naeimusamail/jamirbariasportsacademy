<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Prepare Writable /tmp Storage for Serverless (Vercel)
|--------------------------------------------------------------------------
*/
$tmpStorage = sys_get_temp_dir() . '/storage';
$directories = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/cache',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/logs',
    $tmpStorage . '/app/public',
    sys_get_temp_dir() . '/bootstrap/cache',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

/*
|--------------------------------------------------------------------------
| Register Auto Loader & Bootstrap Application
|--------------------------------------------------------------------------
*/
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Bind Storage Path to Temporary Directory
|--------------------------------------------------------------------------
*/
$app->useStoragePath($tmpStorage);

/*
|--------------------------------------------------------------------------
| Handle Request
|--------------------------------------------------------------------------
*/
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
