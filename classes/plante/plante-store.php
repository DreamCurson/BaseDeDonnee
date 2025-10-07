<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../../dreamplante.php');
    exit;
}

require_once('../CRUD.php');

$crud = new CRUD;

echo "allo";

// try {
//     $insert = $crud->insert('', $_POST);
//     header("Location: ../../dreamplante.php");
//     exit;
// } catch (PDOException $e) {
//     if ($e->getCode() == 23000) {
//         header("Location: inscription.php?erreur=erreurDonnee");
//         exit;
//     }
// }
