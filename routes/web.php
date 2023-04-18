<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send', [\App\Http\Controllers\MessageController::class, 'send']);

Route::get('/teste', function () {
    $startDate = '2023/04/05';
    $endDate = '2023/12/28';

    $endDate = strtotime($endDate);
    for($i = strtotime('Wednesday', strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
        echo date('d-m-Y ', $i);
});
