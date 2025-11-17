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

Route::get('/noteAjoute', 'NoteController@add');
Route::post('/noteAjoute', 'NoteController@store');
Route::get('/noteEdit', 'NoteController@edit');
Route::post('/noteEdit', 'NoteController@update');
Route::get('/noteDelete', 'NoteController@delete');

Route::get('/admin-connexion', 'AdminController@connexion');
Route::post('/admin-connexion', 'AdminController@validate');
Route::get('/admin', 'AdminController@index');

Route::get('/admin-ajouterPlante', 'AdminController@addPlante');
Route::post('/admin-ajouterPlante', 'AdminController@savePlante');
Route::get('/admin-modifierPlante', 'AdminController@editPlante');

Route::get('/admin-supprimerPlante', 'AdminController@deletePlante');

Route::get('/admin-supprimerUtilisateur', 'AdminController@deleteUser');
Route::get('/admin-modifierUtilisateur', 'AdminController@editUser');
Route::post('/admin-modifierUtilisateur', 'AdminController@updateUser');
Route::get('/admin-ajouterUtilisateur', 'AdminController@addUser');
Route::post('/admin-ajouterUtilisateur', 'AdminController@saveUser');

Route::post('/uploadIcon', 'IconController@store');

Route::dispatch();