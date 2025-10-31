{{ include('layouts/header.php', {title: 'DreamPlante | Connexion'})}}
<body class="formulaire__background">
    <div class="formulaireConnection">
        <h2 class="formulaireConnection__title">Connexion</h2>
        <form class="formulaireConnection__form" method="post">
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

            <button type="submit" class="formulaireConnection__button" value="Save">Se connecter</button>
        </form>

        <p class="formulaireConnection__signup">
            Pas encore inscrit ? 
            <a href="inscription" class="formulaireConnection__link">S'inscrire</a>
        </p>
    </div>
</body>
{{ include('layouts/footer.php')}}