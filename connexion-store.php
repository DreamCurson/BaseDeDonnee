<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: index.php');
    exit;
}

require_once('classes/CRUD.php');
$crud = new CRUD;

// Récupération données du formulaire de connexion (enleve les espaces au cas où l'utilisateur met "test ")
$nomUtilisateur = trim($_POST['nomUtilisateur']);
$motDePasse = $_POST['motDePasse'];

// Sélectionne tous les utilisateurs dans la table "utilisateur"
$utilisateurs = $crud->select('utilisateur', 'idUtilisateur');

// Vérifie si l’utilisateur existe et si le mot de passe correspond
$found = false;
foreach ($utilisateurs as $user) {
    if ($user['nomUtilisateur'] === $nomUtilisateur && $user['motDePasse'] === $motDePasse) {
        // Si correspondance trouvée on ajoute le nom d'utilisateur et l'id dans la session
        $found = true;
        session_start();
        $_SESSION['idUtilisateur'] = $user['idUtilisateur'];
        $_SESSION['nomUtilisateur'] = $user['nomUtilisateur'];

        header("Location: dreamplante.php");
        exit;
    }
}

// Si aucun utilisateur ne correspond on retourne dans l'index avec un erreur
if (!$found) {
    header("Location: index.php?erreur=connexion");
    exit;
}
