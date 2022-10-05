<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;




Route::view('/', 'auth.login')->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ---------------------------------------------------------------------------------------------------

Route::group(['prefix' => 'student', 'as'=>'student.', 'middleware' => ['auth','isStudent','backNotAllowed']],function () {
    Route::get('profile', 'StudentController@show')->name('profile');
    Route::put('update', 'StudentController@update')->name('update');
    Route::get('pdf', 'StudentController@pdf')->name('pdf');
    Route::get('notes', [NotesController::class, 'index'])->name('notes');
});

Route::resource('admin', AdminController::class)->except([
    'create','edit','update'
])->middleware(['auth','isAdmin','backNotAllowed']);

Route::put('admin', 'AdminController@update')->name('admin.update');


Route::get('/admin/delete/{id}', function ($id){
    return view('admin.delete',['id' => $id]);
})->name('admin.deleteView');

Route::delete('/admin/delete2/{id}', 'AdminController@delete2')->name('admin.delete2');

Route::fallback(function(){
    return view('page404');
});
