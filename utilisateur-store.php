<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: dreamplante.php');
    exit;
}

session_start();

require_once('classes/CRUD.php');
$crud = new CRUD;

try {
    $update = $crud->update('utilisateur', $_POST, 'idUtilisateur');

    if ($update) {
        if (isset($_POST['nomUtilisateur'])) {
            $_SESSION['nomUtilisateur'] = $_POST['nomUtilisateur'];
        }

        header('Location: dreamplante.php');
        exit;
    } else {
        header('Location: utilisateur-edit.php?erreur=modificationUtilisateur');
        exit;
    }
} catch (PDOException $e) {
    header('Location: utilisateur-edit.php?erreur=modificationUtilisateur');
    exit;
}
