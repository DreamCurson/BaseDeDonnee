<?php
$erreur = $_GET['erreur'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamPlante | Inscription</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="formulaire__background ">
    <div class="formulaireInscription">
        <h1 class="formulaireInscription__titre">Inscription</h1>

        <?php if ($erreur === 'nomUtilisateur'): ?>
            <p class="formulaireInscription__erreur">Ce nom d'utilisateur est déjà utilisé.</p>
        <?php endif; ?>

        <form class="formulaireInscription__form" action="inscription-store.php" method="post">
            <label class="formulaireInscription__label">
                Nom d'utilisateur
                <input type="text" name="nomUtilisateur" class="formulaireInscription__input" required>
            </label>

            <label class="formulaireInscription__label">
                Email (optionnel)
                <input type="email" name="email" class="formulaireInscription__input">
            </label>

            <label class="formulaireInscription__label">
                Mot de passe
                <input type="password" name="motDePasse" class="formulaireInscription__input" required>
            </label>

            <input type="submit" value="S'inscrire" class="formulaireInscription__bouton">
        </form>

        <p class="formulaireInscription__texte">
            Déjà inscrit ? <a href="index.php" class="formulaireInscription__lien">Se connecter</a>
        </p>
    </div>
</body>
</html>
