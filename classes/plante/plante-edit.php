<?php
session_start();

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../../index.php');
    exit;
}

require_once('../CRUD.php');
$crud = new CRUD;

$idUtilisateur = $_SESSION['idUtilisateur'];

if (isset($_GET['id'])) {
    // Stocke l'identifiant en session pour revenir dans plante-edit sans afficher l'id dans la navigation
    $_SESSION['planteEdition'] = (int)$_GET['id'];

    header('Location: plante-edit.php');
    exit;
}

// Si aucune plante n'est sélectionné (tentative d'accès sans avoir passé par la page principal)
if (!isset($_SESSION['planteEdition'])) {
    header('Location: ../../index.php');
    exit;
}

// Récupère l'ID de la plante depuis la session
$idPlante = $_SESSION['planteEdition'];

// Sélectionne la plante correspondante dans la base
$plante = $crud->selectId('plante', $idPlante, 'idPlante');

// Vérifie que la plante appartient bien à l'utilisateur connecté
if ($plante['utilisateur_idUtilisateur'] != $idUtilisateur) {
    // Si ce n’est pas le cas, on empêche l’accès
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
            <!-- Champ caché pour transmettre l'id de la plante -->
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
