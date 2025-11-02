<?php
namespace App\Controllers;
use App\Providers\View;
use App\Models\Plante;

class BaseController {
    public function __construct() {
        session_start();

        if(!isset($_SESSION['nomUtilisateur'])){
            View::redirect('connexion');
            exit;
        }
    }

    public function index() {
        $nomUtilisateur = $_SESSION['nomUtilisateur'];
        $idUtilisateur = $_SESSION['idUtilisateur'];

        $plantes = new Plante;
        $plantesUtilisateur = $plantes->selectBy('utilisateur_idUtilisateur', $idUtilisateur);

        return View::render('base/index', [
            'nomUtilisateur' => $nomUtilisateur,
            'idUtilisateur' => $idUtilisateur,
            'plantesUtilisateur' => $plantesUtilisateur
        ]);
    }
}

