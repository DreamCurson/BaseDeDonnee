<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header('location: inscription.php');
    exit;
}

require_once('classes/CRUD.php');

$crud = new CRUD;

$insert = $crud->insert('utilisateur', $_POST);

print_r($insert);


?>