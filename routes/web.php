<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/charts', function () {
    return view('charts');
});

Route::get('stats', function () {
    return view('stats');
});

Route::get('announcement/show', function () {
    $announcement = \App\Models\Announcement::first();
    abort_if($announcement === null, 404);
    abort_if(!$announcement->isActive === null, 403);

    return view('announcement.show', compact('announcement'));
})->name('announcement.show');

Route::get('announcement/edit', function () {
    $announcement = \App\Models\Announcement::first();
    abort_if($announcement === null, 404);
    abort_if(!$announcement->isActive === null, 403);

    return view('announcement.edit', compact('announcement'));
})->name('announcement.edit');

Route::patch('announcement/update', function (\Illuminate\Http\Request $request) {
    $announcement = \App\Models\Announcement::first();
    abort_if($announcement === null, 404);
    abort_if(!$announcement->isActive === null, 403);
    $columnList = \Illuminate\Support\Facades\Schema::getColumnListing((new \App\Models\Announcement())->getTable());
    $inputWithValidationRule = [];
    foreach ($columnList as $column) {
        if (!in_array($column, ['id', 'created_at', 'updated_at'])) {
            if ($column === 'image') {
                $inputWithValidationRule[$column] = 'string';
            } else {
                $inputWithValidationRule[$column] = 'required';
            }
        }
    }

    $data = \Illuminate\Support\Arr::except($request->validate($inputWithValidationRule), 'image');
    $image = $request->image;
    if ($image) {
        if ($announcement->image && \Illuminate\Support\Facades\Storage::exists($announcement->image)) {
            \Illuminate\Support\Facades\Storage::delete($announcement->image);
        }
        $permanentStorePath = Str::of($image)->replace('tmp', '')->toString();
        Storage::move($image, $permanentStorePath);
//        $name = "{$announcement->id}_".$image->getClientOriginalName();
//        $path = public_path("storage/announcement/$name");
//
//        $image = \Intervention\Image\Facades\Image::make($image);
//        $image->resize(600, null, function ($constraint) {
//            $constraint->aspectRatio();
//            $constraint->upsize();
//        })->save($path);

//        $name = "{$announcement->id}_".$image->getClientOriginalName();
        $data['image'] = $permanentStorePath;
    }
    $announcement->update($data);

    return redirect()->route('announcement.show')->with('success_message', 'Announcement was updated successfully!');
})->name('announcement.update');

Route::post('upload-image', function (Request $request) {
    $request->validate([
        'image' => 'file|image|max:20000'
    ]);

    $image = $request->file('image');
    $name = Str::uuid() . '_' . $image->getClientOriginalName();
    $path = "tmp/announcement";
    $uniquePath = $image->storeAs($path, $name);

    return $uniquePath;

})->name('upload-image');

Route::get('songs', function () {
    return view('drag-drop');
})->name('songs');

Route::get('http-client', function () {
//    $response = Http::get("https://api.github.com/users/HuyNguyen206/repos?sort=created&per_page=10");

    $openMapKey = config('app.open_weather_map_key');
//    $weatherResponse = Http::get("https://api.openweathermap.org/data/2.5/weather?id=1566083&unit=metric&appid=$openMapKey");
//    $weatherResponse = Http::weatherApi()->get("/data/2.5/weather?id=1566083&unit=metric&appid=$openMapKey");
    $movieKey = config('app.movie_db_key');
//    $movieResponse = Http::get("https://api.themoviedb.org/3/movie/popular?api_key=$movieKey&language=en-US&page=1");

    $response = Http::pool(fn(\Illuminate\Http\Client\Pool $pool) => [
        $pool->as('repo')->get("https://api.github.com/users/HuyNguyen206/repos?sort=created&per_page=10"),
        $pool->as('weather')->get("https://api.openweathermap.org/data/2.5/weather?id=1566083&unit=metric&appid=$openMapKey"),
        $pool->as('movies')->get("https://api.themoviedb.org/3/movie/popular?api_key=$movieKey&language=en-US&page=1"),
    ]);

    return view('repo', ['repos' => $response['repo']->json(), 'weather' => $response['weather']->json(), 'movies' => $response['movies']->json()]);
});
