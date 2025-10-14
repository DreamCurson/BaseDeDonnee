<?php
session_start();

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../../index.php');
    exit;
}

if (!isset($_SESSION['planteSelectionnee'])) {
    header('Location: ../../dreamplante.php');
    exit;
}

require_once('../CRUD.php');
$crud = new CRUD;

$typesEvenement = $crud->select('typeEvenement', 'typeEvenement');

$idPlante = $_SESSION['planteSelectionnee'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamPlante | Ajouter un événement</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="formulaire__background">
    <div class="formulaire">
        <h1 class="formulaire__title">Ajouter un événement</h1>

        <form class="formulaire__form" action="evenements-store.php" method="post">
            <input type="hidden" name="idPlante" value="<?= $idPlante; ?>">

            <label class="formulaire__label">
                Type d’événement
                <select name="idTypeEvenement" class="formulaire__input" required>
                    <option value="" disabled selected>Sélectionnez un type</option>
                    <?php foreach ($typesEvenement as $type): ?>
                        <option value="<?= $type['idTypeEvenement']; ?>">
                            <?= ($type['typeEvenement']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>


            <label class="formulaire__label">
                Commentaire
                <textarea name="commentaire" class="formulaire__input" rows="4"></textarea>
            </label>

            <label class="formulaire__label">
                Date de l’événement
                <input 
                    type="date" 
                    name="date" 
                    class="formulaire__input" 
                    value="<?= date('Y-m-d'); ?>"
                >
            </label>


            <button type="submit" class="formulaire__button">Enregistrer</button>
        </form>
    </div>
</body>
</html>
