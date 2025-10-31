{{ include('layouts/header.php', {title: 'DreamPlante | Créer un utilisateur'})}}

<body class="formulaire__background ">
    <div class="formulaireInscription">
        <h2 class="formulaireInscription__titre">Inscription</h2>

        <form class="formulaireInscription__form" action="" method="post">
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
            Déjà inscrit ? <a href="connexion" class="formulaireInscription__lien">Se connecter</a>
        </p>
    </div>
</body>

{{ include('layouts/footer.php')}}