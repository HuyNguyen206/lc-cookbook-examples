<?php

use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('upload:cleanup', function () {
    $this->info('Cleaning up the tmp uploads folder...');

    $tmpFiles = Storage::files("tmp/announcement");
    $countDeletedFiles = 0;
    foreach ($tmpFiles as $tmpFile) {
        $timeString = DateTime::createFromFormat("U", File::lastModified(Storage::path($tmpFile)))
            ->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'))
            ->format('Y-m-d h:i:s');
        $date = Carbon::createFromTimeString($timeString);
        $now = Carbon::createFromFormat('Y-m-d h:i:s', now());

        if ($date->diffInMinutes($now) > 5) {
            Storage::delete($tmpFile);
            $countDeletedFiles++;
        }
    }

    $this->info("$countDeletedFiles files have been delete on " . now());

})->purpose('Clean up tmp uploads folder');
