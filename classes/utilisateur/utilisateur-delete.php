<?php
session_start();
require_once('../CRUD.php');

$crud = new CRUD;

$nomUtilisateur = $_SESSION['nomUtilisateur'];

if (!$nomUtilisateur) {
    header('Location: utilisateur-edit.php?erreur=supprimer');
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
