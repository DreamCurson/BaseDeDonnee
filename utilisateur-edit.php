<?php
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: index.php');
    exit;
}

require_once('classes/CRUD.php');
$crud = new CRUD;

$idUtilisateur = $_SESSION['idUtilisateur'];

$selectUser = $crud->selectId('utilisateur', $idUtilisateur, 'idUtilisateur');

if (!$selectUser) {
    header('Location: index.php');
    exit;
}

extract($selectUser);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier votre profil</h1>
        <form class="formulaireUtilisateur__form" action="utilisateur-store.php" method="post">
            <input type="hidden" name="idUtilisateur" value="<?= $idUtilisateur; ?>">

            <label class="formulaireUtilisateur__label">
                Nom d'utilisateur
                <input type="text" name="nomUtilisateur" class="formulaireUtilisateur__input" value="<?= ($nomUtilisateur); ?>" required>
            </label>
            <label class="formulaireUtilisateur__label">
                Email
                <input type="email" name="email" class="formulaireUtilisateur__input" value="<?= ($email); ?>">
            </label>
            <label class="formulaireUtilisateur__label">
                Mot de passe
                <input type="text" name="motDePasse" class="formulaireUtilisateur__input" value="<?= ($motDePasse); ?>">
            </label>
            <button type="submit" class="formulaireUtilisateur__button">Enregistrer</button>
        </form>
    </div>
</body>
</html>
