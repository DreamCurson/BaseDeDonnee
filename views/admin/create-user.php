{{ include('layouts/header.php', {title: 'Admin | Créer un utilisateur'})}}
<body class="formulaire__background ">
    <div class="formulaireInscription">
        <h2 class="formulaireInscription__titre">Ajouter un utilisateur</h2>

        <form class="formulaireInscription__form" method="post">   
            <label class="formulaireInscription__label">
                Nom d'utilisateur
                {% if errors.nomUtilisateur is defined %}
                    <span class="error">{{ errors.nomUtilisateur }}</span>
                {% endif %}
                <input type="text" name="nomUtilisateur" class="formulaireInscription__input" value="{{ utilisateur.nomUtilisateur }}" required>
            </label>

            <label class="formulaireInscription__label">
                Email (optionnel)
                <input type="email" name="email" class="formulaireInscription__input" value="{{ utilisateur.email }}">
            </label>

            <label class="formulaireInscription__label">
                Mot de passe
                {% if errors.motDePasse is defined %}
                <span class="error">{{ errors.motDePasse }}</span>
                {% endif %}
                <input type="password" name="motDePasse" class="formulaireInscription__input" required>
            </label>

            <input type="submit" value="Inscrire l'utilisateur" class="formulaireInscription__bouton">
        </form>

        <p class="formulaireInscription__texte">
            <a href="admin" class="formulaireInscription__lien">Retour</a>
        </p>
    </div>
</body>

{{ include('layouts/footer.php')}}