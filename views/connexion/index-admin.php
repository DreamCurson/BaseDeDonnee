{{ include('layouts/header.php', {title: 'DreamPlante | Connexion'})}}

<body class="formulaire__background">
    <div class="formulaireConnection">
        <div class="formulaireConnection_entete">
            <h2 class="formulaireConnection__title">Connexion Admin</h2>
            {% if errors.message is defined %}
                <span class="error">{{ errors.message }}</span>
            {% endif %}
        </div>
        <form class="formulaireConnection__form" method="post">
            <label for="nomUtilisateur" class="formulaireConnection__label" value="{{ admin.nomUtilisateur }}">Nom d'utilisateur</label>
            <input 
            value="{{ admin.nomUtilisateur }}"
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
            <a href="connexion" class="formulaireConnection__link">Retour connexion client</a>
        </p>
    </div>
</body>
{{ include('layouts/footer.php')}}