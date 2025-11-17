{{ include('layouts/header.php', {title: 'Admin | Modifier un utilisateur'})}}
<script type="module" src="{{ asset }}script/main.js"></script>
<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier l'utilisateur</h1>
        <form class="formulaireUtilisateur__form" method="post">
            <input type="hidden" name="idUtilisateur" value="{{ utilisateur.idUtilisateur }}">
            <label class="formulaireUtilisateur__label">
                Nom d'utilisateur
                <input type="text" name="nomUtilisateur" class="formulaireUtilisateur__input" value="{{ utilisateur.nomUtilisateur }}" required>
            </label>
            {% if errors.nomUtilisateur is defined %}
                <span class="error">{{ errors.nomUtilisateur }}</span>
            {% endif %}
            <label class="formulaireUtilisateur__label">
                Email
                <input type="email" name="email" class="formulaireUtilisateur__input" value="{{ utilisateur.email }}">
            </label>
            <label class="formulaireUtilisateur__label">
                Mot de passe (Si vide le mot de passe ne change pas)
                <input type="password" name="motDePasse" class="formulaireUtilisateur__input">
            </label>
            {% if errors.motDePasse is defined %}
                <span class="error">{{ errors.motDePasse }}</span>
            {% endif %}
            <button type="submit" class="formulaireUtilisateur__button">Enregistrer</button>
        </form>
        <div class="formulaireUtilisateur__bouton">
            <button type="button" class="formulaireUtilisateur__delete">Supprimer le compte</button>
            <a href="admin-supprimerUtilisateur?id={{ utilisateur.idUtilisateur }}" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>
        <p class="formulaireInscription__texte">
            <a href="admin" class="formulaireInscription__lien">Retour</a>
        </p>
</body>