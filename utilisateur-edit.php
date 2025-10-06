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

$erreur = $_GET['erreur'] ?? null;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamPlante | Modifier votre profil</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script type="module" src="assets/script/main.js"></script>
</head>
<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier votre profil</h1>
        <?php if ($erreur === 'modificationUtilisateur'): ?>
            <p class="formulaireUtilisateur__erreur">
                La mise à jour des données a échoué
            </p>
        <?php endif; ?>
        <?php if ($erreur === 'nomUtilisateur'): ?>
            <p class="formulaireUtilisateur__erreur">
                Ce nom d'utilisateur est déjà utilisé
            </p>
        <?php endif; ?>

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
        <div class="formulaireUtilisateur__bouton">
            <button type="button" class="formulaireUtilisateur__delete">Supprimer le compte</button>
            <a href="utilisateur-delete.php" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>
    </div>
</body>
</html>
