<?php
session_start();

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../../index.php');
    exit;
}

require_once('../CRUD.php');
$crud = new CRUD;

$idPlante = $_GET['id'] ?? null;
$idUtilisateur = $_SESSION['idUtilisateur'];

if (!$idPlante) {
    header('Location: ../../dreamplante.php');
    exit;
}

$plante = $crud->selectId('plante', $idPlante, 'idPlante');

if ($plante['utilisateur_idUtilisateur'] != $idUtilisateur) {
    header('Location: ../../dreamplante.php');
    exit;
}

extract($plante);

$erreur = $_GET['erreur'] ?? null;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamPlante | Modifier la plante</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script type="module" src="../../assets/script/main.js"></script>
</head>
<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier la plante</h1>
        <?php if ($erreur === 'modification'): ?>
            <p class="formulaireUtilisateur__erreur">
                Une erreur est survenue lors de la modification.
            </p>
        <?php endif; ?>
        <form class="formulaireUtilisateur__form" action="plante-update.php" method="post">
            <input type="hidden" name="idPlante" value="<?= ($idPlante); ?>">

            <label class="formulaireUtilisateur__label">
                Nom de la plante
                <input type="text" name="nom" class="formulaireUtilisateur__input" value="<?= ($nom); ?>" required>
            </label>

            <label class="formulaireUtilisateur__label">
                Type de plante
                <input type="text" name="typePlante" class="formulaireUtilisateur__input" value="<?= ($typePlante ?? ''); ?>">
            </label>

            <label class="formulaireUtilisateur__label">
                Date d’acquisition
                <input type="date" name="dateAcquisition" class="formulaireUtilisateur__input" value="<?= ($dateAcquisition ?? ''); ?>">
            </label>

            <button type="submit" class="formulaireUtilisateur__button">Enregistrer</button>
        </form>

        <div class="formulaireUtilisateur__bouton">
            <button type="button" class="formulaireUtilisateur__delete">Supprimer la plante</button>
            <a href="plante-delete.php?id=<?= ($idPlante); ?>" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>
    </div>
</body>
</html>
