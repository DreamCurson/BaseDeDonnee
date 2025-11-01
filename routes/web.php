<?php
// include 'routes/Route.php';
// include 'controllers/HomeController.php';
use App\Routes\Route;
use App\Controllers\ConnexionController;

Route::get('/inscription', 'ConnexionController@inscription');
Route::post('/inscription', 'ConnexionController@store');

// En débutant le site
Route::get('/', 'ConnexionController@index');
Route::post('/', 'ConnexionController@validate');
// En cliquant sur se connecter depuis inscription
Route::get('/connexion', 'ConnexionController@index');
Route::post('/connexion', 'ConnexionController@validate');

Route::get('/logout', 'ConnexionController@logout');
Route::get('/modifierUtilisateur', 'ConnexionController@edit');

Route::get('/dreamplante', 'BaseController@index');
Route::get('/base/index', 'BaseController@index'); 



// Route::get('/clients', 'ClientController@index');
// Route::get('/client/show', 'ClientController@show');
// Route::get('/client/create', 'ClientController@create');
// Route::post('/client/create', 'ClientController@store');
// Route::get('/client/edit', 'ClientController@edit');
// Route::post('/client/edit', 'ClientController@update');
// Route::post('/client/delete', 'ClientController@delete');



Route::dispatch();