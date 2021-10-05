<?php

use App\Address;
use App\Car;
use App\Owner;
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

Route::get('owner', 'OwnerController@index');
// create a new route to return the average number of addresses and cars per user
Route::get('average_number_addresses_and_cars_per_user', 'OwnerController@average_number_addresses_and_cars_per_user');
// create a new route to return the Owners Address
Route::get('getOwnerAddress/{owner}', 'OwnerController@getOwnerAddress');
// update url for delete
Route::get('owner/show/{owner}', 'OwnerController@show');
Route::post('owner/store', 'OwnerController@store');
// update url for updating one owner
Route::put('owner/update/{owner}', 'OwnerController@update');
// update url for one delete
Route::delete('owner/delete/{owner}', 'OwnerController@delete');

Route::get('address', 'AddressController@index');
// create a new route to return the average number of cars per address
Route::get('average_number_of_cars_per_address', 'AddressController@average_number_of_cars_per_address');
// update url for showing one address
Route::get('address/show/{address}', 'AddressController@show');
Route::post('address', 'AddressController@store');
// update url for updating one address
Route::put('address/update/{address}', 'AddressController@update');
// update url for delete one address
Route::delete('address/delete/{address}', 'AddressController@delete');

Route::get('car', 'CarController@index');
// create a new route to return the average number of user and address per car
Route::get('average_number_of_user_and_address_per_car', 'CarController@average_number_of_user_and_address_per_car');
// update url for showing one car
Route::get('car/show/{car}', 'CarController@show');
Route::post('car', 'CarController@store');
// update url for updating one car
Route::put('car/update/{car}', 'CarController@update');
// update url for delete one car
Route::delete('car/delete/{car}', 'CarController@delete');

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*');
