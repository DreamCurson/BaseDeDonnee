<?php
// include 'routes/Route.php';
// include 'controllers/HomeController.php';
use App\Routes\Route;
use App\Controllers\ConnexionController;

Route::get('/', 'ConnexionController@index');
Route::get('/connexion', 'ConnexionController@index');
Route::post('/', 'ConnexionController@validate');
// Route::get('/user/create', 'UserController@create');
// Route::post('/user/create', 'UserController@store');

Route::get('/inscription', 'ConnexionController@inscription');



// Route::get('/clients', 'ClientController@index');
// Route::get('/client/show', 'ClientController@show');
// Route::get('/client/create', 'ClientController@create');
// Route::post('/client/create', 'ClientController@store');
// Route::get('/client/edit', 'ClientController@edit');
// Route::post('/client/edit', 'ClientController@update');
// Route::post('/client/delete', 'ClientController@delete');



Route::dispatch();