<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function () {
    app(ThreadController::class)->deleteOldThreads();
})->daily();
// Compare this snippet from app/Http/Controllers/ThreadController.php:
