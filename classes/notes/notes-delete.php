<?php
session_start();
require_once('../CRUD.php');

$crud = new CRUD;

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../../index.php');
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ../../dreamplante.php');
    exit;
}

$id = (int) $_GET['id']; 

try {
    $delete = $crud->delete('note', $id, 'idNote');

    if ($delete) {
        header('Location: ../../dreamplante.php');
        exit;
    } else {
        header('Location: ../../dreamplante.php?erreur=supprimer');
        exit;
    }
} catch (PDOException $e) {
    header('Location: ../../dreamplante.php?erreur=supprimer');
    exit;
}
?>
