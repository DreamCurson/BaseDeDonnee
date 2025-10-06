<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: connexion.php');
    exit;
}

require_once('classes/CRUD.php');
$crud = new CRUD;

$nomUtilisateur = trim($_POST['nomUtilisateur']);
$motDePasse = $_POST['motDePasse'];

$utilisateurs = $crud->select('utilisateur', 'idUtilisateur');

$found = false;
foreach ($utilisateurs as $user) {
    if ($user['nomUtilisateur'] === $nomUtilisateur && $user['motDePasse'] === $motDePasse) {
        $found = true;
        session_start();
        $_SESSION['idUtilisateur'] = $user['idUtilisateur'];
        $_SESSION['nomUtilisateur'] = $user['nomUtilisateur'];

        header("Location: dreamplante.php");
        exit;
    }
}

if (!$found) {
    header("Location: index.php?erreur=connexion");
    exit;
}
