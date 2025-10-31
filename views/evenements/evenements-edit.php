<?php
session_start();

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../../index.php');
    exit;
}

require_once('../CRUD.php');
$crud = new CRUD;

if (isset($_GET['id'])) {
    $_SESSION['evenementEdition'] = (int)$_GET['id'];
    header('Location: evenements-edit.php');
    exit;
}

if (!isset($_SESSION['evenementEdition'])) {
    header('Location: ../../dreamplante.php');
    exit;
}

// var_dump($_SESSION);

$idEvenement = $_SESSION['evenementEdition'];
$evenement = $crud->selectId('evenement', $idEvenement, 'idEvenement');

if (!$evenement) {
    header('Location: ../../dreamplante.php');
    exit;
}

$typesEvenement = $crud->select('typeEvenement', 'typeEvenement');

extract($evenement);

$erreur = $_GET['erreur'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamPlante | Modifier l'événement</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script type="module" src="../../assets/script/main.js"></script>
</head>
<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier l'événement</h1>

        <?php if ($erreur === 'modification'): ?>
            <p class="formulaireUtilisateur__erreur">
                Une erreur est survenue lors de la modification.
            </p>
        <?php endif; ?>

        <form class="formulaire__form" action="evenements-update.php" method="post">
            <input type="hidden" name="idEvenement" value="<?= $idEvenement; ?>">
            <input type="hidden" name="idPlante" value="<?= $idPlante; ?>">

            <label class="formulaire__label">
                Type d’événement
                <select name="idTypeEvenement" class="formulaire__input" required>
                    <option value="" disabled>Sélectionnez un type</option>
                    <?php foreach ($typesEvenement as $type): ?>
                        <option value="<?= $type['idTypeEvenement']; ?>"
                            <?= $type['idTypeEvenement'] == $evenement['idTypeEvenement'] ? 'selected' : ''; ?>>
                            <?= ($type['typeEvenement']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="formulaire__label">
                Commentaire
                <textarea name="commentaire" class="formulaire__input" rows="4"><?= ($evenement['commentaire']); ?></textarea>
            </label>

            <label class="formulaire__label">
                Date de l’événement
                <input 
                    type="date" 
                    name="date" 
                    class="formulaire__input" 
                    value="<?= ($evenement['date']); ?>"
                >
            </label>

            <button type="submit" class="formulaire__button">Enregistrer</button>
        </form>

        <div class="formulaireUtilisateur__bouton">
            <button type="button" class="formulaireUtilisateur__delete">Supprimer l'évènement</button>
            <a href="evenements-delete.php?id=<?= ($idEvenement); ?>" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>
    </div>
</body>
</html>
