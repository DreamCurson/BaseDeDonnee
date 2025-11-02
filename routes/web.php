<?php
// include 'routes/Route.php';
// include 'controllers/HomeController.php';
use App\Routes\Route;
use App\Controllers\ConnexionController;

// En débutant le site
Route::get('/', 'ConnexionController@index');
Route::post('/', 'ConnexionController@validate');
// En cliquant sur se connecter depuis inscription
Route::get('/connexion', 'ConnexionController@index');
Route::post('/connexion', 'ConnexionController@validate');

Route::get('/inscription', 'ConnexionController@inscription');
Route::post('/inscription', 'ConnexionController@store');

Route::get('/modifierUtilisateur', 'ConnexionController@edit');
Route::post('/modifierUtilisateur', 'ConnexionController@update');
Route::get('/supprimerUtilisateur', 'ConnexionController@delete');
Route::get('/logout', 'ConnexionController@logout');

Route::get('/dreamplante', 'BaseController@index');
Route::get('/base/index', 'BaseController@index');
Route::post('/dreamplante', 'BaseController@select'); 

Route::get('/planteAjoute', 'PlanteController@add');
Route::post('/planteAjoute', 'PlanteController@store');
Route::get('/planteModifie', 'PlanteController@edit');
Route::post('/planteModifie', 'PlanteController@update');
Route::get('/planteDelete', 'PlanteController@delete');

Route::get('/evenementAjoute', 'EvenementController@add');
Route::post('/evenementAjoute', 'EvenementController@store');
Route::get('/evenementModifie', 'EvenementController@edit');
Route::post('/evenementModifie', 'EvenementController@update');
Route::get('/evenementDelete', 'EvenementController@delete');

Route::dispatch();