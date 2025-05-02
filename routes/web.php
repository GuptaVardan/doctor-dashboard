<?php

use Illuminate\Routing\Router;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/assets/{filename}', function ($filename) {
    $path = storage_path('app/public/assets/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::post('/', [AppointmentController::class,'save'])->name('save.appointment');

Route::get('/doctor/login', function() {
    return view('Doctor.Auth.login');
})->name('doctor.login');
Route::get('/doctor/registration', function() {
    return view('Doctor.Auth.signup');
})->name('doctor.registration');

Route::post('/doctor/registration',[AuthController::class, 'savedoc'])->name('doctor.registration.save');

Route::get('/doctor/dashboard',function(){
    return view('Doctor.dashboard');
});

Route::post('/doctor/login',[AuthController::class, 'DocLogin'])->name('doctor.login.save');
Route::get('/',[AuthController::class, 'showDoctors']);