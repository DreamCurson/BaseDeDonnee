<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: inscription.php');
    exit;
}

require_once('../CRUD.php');

$crud = new CRUD;

try {
    $insert = $crud->insert('utilisateur', $_POST);
    header("Location: ../../index.php");
    exit;
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        header("Location: inscription.php?erreur=nomUtilisateur");
        exit;
    }
}
