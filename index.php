<?php
$erreur = $_GET['erreur'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>DreamPlante</title>
</head>
<body class="formulaire__background">
    <div class="formulaireConnection">
        <h2 class="formulaireConnection__title">Connexion</h2>
        <?php if ($erreur === 'connexion'): ?>
            <p class="formulaireConnection__erreur">
                Nom d'utilisateur ou mot de passe incorrect.
            </p>
        <?php endif; ?>
        <form class="formulaireConnection__form" action="connexion-store.php" method="post">
            <label for="nomUtilisateur" class="formulaireConnection__label">Nom d'utilisateur</label>
            <input 
            type="text" 
            id="nomUtilisateur" 
            name="nomUtilisateur" 
            class="formulaireConnection__input"
            required
            />

            <label for="motDePasse" class="formulaireConnection__label">Mot de passe</label>
            <input 
            type="password" 
            id="motDePasse" 
            name="motDePasse" 
            class="formulaireConnection__input"
            required
            />

            <button type="submit" class="formulaireConnection__button">Se connecter</button>
        </form>

        <p class="formulaireConnection__signup">
            Pas encore inscrit ? 
            <a href="inscription.php" class="formulaireConnection__link">S'inscrire</a>
        </p>
    </div>

</body>
</html>