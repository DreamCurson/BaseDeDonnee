{{ include('layouts/header.php', {title: 'Admin | Ajouter une plante'})}}

<body class="formulaire__background ">
    <div class="formulairePlante">
        <h2 class="formulairePlante__titre">Ajouter votre plante</h2>

        <form class="formulairePlante__form" method="post">
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


            <label class="formulairePlante__label">
                Nom de votre plante
                <input type="text" name="nom" class="formulairePlante__input" value="{{ plante.nom }}" required>
            </label>
            {% if errors.nom is defined %}
                <span class="error">{{ errors.nom }}</span>
            {% endif %}

            <label class="formulairePlante__label">
                Type de plante
                <input type="text" name="typePlante" class="formulairePlante__input" value="{{ plante.typePlante }}" required>
            </label>


            <label class="formulairePlante__label">
                Date d'acquisition de votre plante
                <input type="date" name="dateAcquisition" class="formulairePlante__input"
                    value="{{ plante.dateAcquisition }}" required>
            </label>

            {% if errors.dateAcquisition is defined %}
                <span class="error">{{ errors.dateAcquisition }}</span>
            {% endif %}

            <input type="submit" value="Ajouter la plante" class="formulairePlante__bouton">
        </form>

        <p class="formulaireInscription__texte">
            <a href="admin" class="formulaireInscription__lien">Retour</a>
        </p>
    </div>
</body>

{{ include('layouts/footer.php')}}
