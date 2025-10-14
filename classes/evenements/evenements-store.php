<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php');
    exit;
}

require_once('../CRUD.php');
$crud = new CRUD;

if (!isset($_SESSION['idUtilisateur'], $_POST['idPlante'], $_POST['idTypeEvenement'])) {
    header('Location: evenement-create.php');
    exit;
}

try {
    $insert = $crud->insert('evenement', $_POST);

    $_SESSION['planteSelectionnee'] = $_POST['idPlante'];
    header("Location: ../../dreamplante.php");

    exit;

} catch (PDOException $e) {
    header("Location: evenement-create.php");
    exit;
}
