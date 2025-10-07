<?php
$erreur = $_GET['erreur'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamPlante | Ajout plante</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="formulaire__background ">
    <div class="formulairePlante">
        <h2 class="formulairePlante__titre">Ajouter votre plante</h2>

        <?php if ($erreur === 'erreurDonnee'): ?>
            <p class="formulairePlante__erreur">Ce nom d'utilisateur est déjà utilisé.</p>
        <?php endif; ?>

        <form class="formulairePlante__form" action="plante-store.php" method="post">
            <label class="formulairePlante__label">
                Nom de votre plante
                <input type="text" name="nom" class="formulairePlante__input" required>
            </label>

            <label class="formulairePlante__label">
                Type de plante
                <input type="text" name="typePlante" class="formulairePlante__input">
            </label>

            <label class="formulairePlante__label">
                Date d'aquisition de votre plante
                <input type="date" name="dateAcquisition" class="formulairePlante__input" required>
            </label>

            <input type="submit" value="Ajouter la plante" class="formulairePlante__bouton">
        </form>

        <p class="formulairePlante__texte">
            Annuler la création <a href="../../dreamplante.php" class="formulairePlante__lien">Annuler</a>
        </p>
    </div>
</body>
</html>
