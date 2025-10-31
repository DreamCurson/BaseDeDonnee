<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php');
    exit;
}

require_once('../CRUD.php');
$crud = new CRUD;

if (!isset($_SESSION['idUtilisateur'], $_POST['idPlante'])) {
    header('Location: ../../index.php');
    exit;
}

try {
    $insert = $crud->insert('note', $_POST);
    header("Location: ../../dreamplante.php");

    exit;

} catch (PDOException $e) {
    header("Location: notes-create.php");
    exit;
}
