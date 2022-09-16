<?php

use Illuminate\Support\Facades\Route;

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
    abort_if(! $announcement->isActive === null, 403);

    return view('announcement.show', compact('announcement'));
})->name('announcement.show');

Route::get('announcement/edit', function () {
    $announcement = \App\Models\Announcement::first();
    abort_if($announcement === null, 404);
    abort_if(! $announcement->isActive === null, 403);

    return view('announcement.edit', compact('announcement'));
})->name('announcement.edit');

Route::patch('announcement/update', function (\Illuminate\Http\Request $request) {
    $announcement = \App\Models\Announcement::first();
    abort_if($announcement === null, 404);
    abort_if(! $announcement->isActive === null, 403);
    $columnList = \Illuminate\Support\Facades\Schema::getColumnListing((new \App\Models\Announcement())->getTable());
    $inputWithValidationRule = [];
    foreach ($columnList as $column) {
        if (!in_array($column, ['id', 'created_at', 'updated_at'])) {
            if ($column === 'image') {
                $inputWithValidationRule[$column] = 'file|image|max:20000';
            } else {
                $inputWithValidationRule[$column] = 'required';
            }
        }
    }

    $data =\Illuminate\Support\Arr::except($request->validate($inputWithValidationRule), 'image');
    $image = $request->file('image');
    if ($image) {
        if ($announcement->image && \Illuminate\Support\Facades\Storage::exists($announcement->image)) {
            \Illuminate\Support\Facades\Storage::delete($announcement->image);
        }
        $name = "{$announcement->id}_".$image->getClientOriginalName();
        $data['image'] = $image->storeAs('announcement', $name);
    }
    $announcement->update($data);

    return redirect()->route('announcement.show')->with('success_message', 'Announcement was updated successfully!');
})->name('announcement.update');
