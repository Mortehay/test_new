<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//list companies
Route::get('companies','CompaniesController@index');

//list single company
Route::get('company/{id}', 'CompaniesController@show');

//create new company
Route::post('company','CompaniesController@store');

//update company
Route::put('company','CompaniesController@store');

//delete company
Route::delete('company/{id}', 'CompaniesController@destroy');

//list employees
Route::get('employees/{id}','EmployeesController@index');

//list single employee
Route::get('employee/{id}', 'EmployeesController@show');

//create new employee
Route::post('employee','EmployeesController@store');

//update employee
Route::put('employee','EmployeesController@store');

//delete employee
Route::delete('employee/{id}', 'EmployeesController@destroy');

//list tablehosts
Route::get('tablehosts','HostsController@index');

//list single tablehost
Route::get('tablehosts/{id}', 'HostsController@show');

//create new tablehost
Route::post('tablehosts','HostsController@store');

//update tablehost
Route::put('tablehosts','HostsController@store');

//delete tablehost
Route::delete('tablehosts/{id}', 'HostsController@destroy');

//list additionaldomains
Route::get('additionaldomains','AdditionalDomainsController@index');

//list single tablehost
Route::get('additionaldomains/{id}', 'AdditionalDomainsController@show');

//create new tablehost
Route::post('additionaldomains','AdditionalDomainsController@store');

//update tablehost
Route::put('additionaldomains','AdditionalDomainsController@store');

//delete tablehost
Route::delete('additionaldomains/{id}', 'AdditionalDomainsController@destroy');