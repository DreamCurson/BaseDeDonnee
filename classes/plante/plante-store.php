<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../../dreamplante.php');
    exit;
}

require_once('../CRUD.php');
$crud = new CRUD;

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../../index.php');
    exit;
}

$idUtilisateur = $_SESSION['idUtilisateur'];

$data = [
    'nom' => $_POST['nom'],
    'typePlante' => $_POST['typePlante'] ?? null,
    'dateAcquisition' => $_POST['dateAcquisition'],
    // N'est pas dans le POST donc on ne peux pas simplement mettre $_POST dans le insert
    'utilisateur_idUtilisateur' => $idUtilisateur
];

try {
    $insert = $crud->insert('plante', $data);
    header('Location: ../../dreamplante.php');
    exit;
} catch (PDOException $e) {
    header('Location: plante-create.php?erreur=erreurDonnee');
    exit;
}
