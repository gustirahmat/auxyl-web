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

Route::post('shipment/finished/{delivery_id}', 'ShipmentFinishedController')->name('shipment.finished');
Route::resource('shipment', 'ShipmentController');
