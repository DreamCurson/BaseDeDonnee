<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../../dreamplante.php');
    exit;
}

session_start();

require_once('../CRUD.php');
$crud = new CRUD;

try {
    $update = $crud->update('plante', $_POST, 'idPlante');

    if ($update) {
        header('Location: ../../dreamplante.php');
        exit;
    } else {
        header('Location: plante-edit.php?erreur=modification');
        exit;
    }
} catch (PDOException $e) {
    header('Location: plante-edit.php?erreur=modification');
    exit;
}
