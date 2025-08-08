<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('debug:db-host', function () {
    $host = config('database.connections.mysql.host');
    $this->info("Laravel is trying to connect to host: [ " . $host . " ]");
});