{{ include('layouts/header.php', {title: 'Admin | Modifier une Plante'})}}
<script type="module" src="{{ asset }}script/main.js"></script>

<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier la plante</h1>

        <form class="formulaireUtilisateur__form" method="post">
            <input type="hidden" name="idPlante" value="{{ plante.idPlante }}">

            <label class="formulaire__label">
                Utilisateur à associer à la plante
                <select name="utilisateur_idUtilisateur" class="formulaire__input" required>
                    <option value="" disabled
                        {% if plante.utilisateur_idUtilisateur is not defined or plante.utilisateur_idUtilisateur == '' %}
                            selected
                        {% endif %}
                    >
                        Sélectionnez un utilisateur
                    </option>

                    {% for utilisateur in utilisateurs %}
                        <option value="{{ utilisateur.idUtilisateur }}"
                            {% if plante.utilisateur_idUtilisateur is defined 
                                and plante.utilisateur_idUtilisateur == utilisateur.idUtilisateur %}
                                selected
                            {% endif %}
                        >
                            {{ utilisateur.nomUtilisateur }}
                        </option>
                    {% endfor %}
                </select>
            </label>

            <label class="formulaireUtilisateur__label">
                Nom de la plante
                <input type="text" name="nom" class="formulaireUtilisateur__input" value="{{ plante.nom }}" required>
            </label>
            {% if errors.nom is defined %}
                <span class="error">{{ errors.nom }}</span>
            {% endif %}

            <label class="formulaireUtilisateur__label">
                Type de plante
                <input type="text" name="typePlante" class="formulaireUtilisateur__input" value="{{ plante.typePlante }}">
            </label>

            <label class="formulaireUtilisateur__label">
                Date d’acquisition
                <input type="date" name="dateAcquisition" class="formulaireUtilisateur__input" value="{{ plante.dateAcquisition }}">
            </label>
            {% if errors.dateAcquisition is defined %}
                <span class="error">{{ errors.dateAcquisition }}</span>
            {% endif %}

            <button type="submit" class="formulaireUtilisateur__button">Enregistrer</button>
        </form>

        <div class="formulaireUtilisateur__bouton">
            <button type="button" class="formulaireUtilisateur__delete">Supprimer la plante</button>
            <a href="admin-supprimerPlante?id={{ plante.idPlante }}" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>

        <p class="formulaireInscription__texte">
            <a href="admin-planteInfo?id={{ plante.idPlante }}" class="formulaireInscription__lien">Retour</a>
        </p>
    </div>
</body>
</html>
