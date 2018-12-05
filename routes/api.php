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