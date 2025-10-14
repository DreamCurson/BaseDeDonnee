<?php
session_start();
require_once('../CRUD.php');

$crud = new CRUD;

// On continue avec le nomUtilisateur dans la session enregistrer depuis la connexion
$nomUtilisateur = $_SESSION['nomUtilisateur'];

// Si il n'y a pas d'utilisateur (quelqu'un essaie d'accéder au delete depuis l'index) on retourne dans la page de connexion
if (!$nomUtilisateur) {
    header('Location: ../../index.php');
    exit;
}

$delete = $crud->delete('utilisateur', $nomUtilisateur, 'nomUtilisateur');

if ($delete) {
    // https://www.php.net/manual/en/function.session-destroy.php
    session_destroy();
    header('Location: ../../index.php');
    exit;
} else {
    header('Location: utilisateur-edit.php?erreur=supprimer');
    exit;
}
