<?php
namespace App\Controllers;
use App\Models\Utilisateur;
use App\Providers\View;

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

        return View::render('base/index', [
            'nomUtilisateur' => $nomUtilisateur,
            'idUtilisateur' => $idUtilisateur
        ]);
    }
}

