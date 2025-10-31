<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../../index.php');
    exit;
}

session_start();

require_once('../CRUD.php');
$crud = new CRUD;

try {
    $update = $crud->update('note', $_POST, 'idNote');

    if ($update) {
        header('Location: ../../dreamplante.php');
        exit;
    } else {
        header('Location: notes-edit.php?erreur=modification');
        exit;
    }
} catch (PDOException $e) {
    header('Location: notes-edit.php?erreur=modification');
    exit;
}
