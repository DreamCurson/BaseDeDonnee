{{ include('layouts/header.php', {title: 'DreamPlante | Ajouter une plante'})}}

<body class="formulaire__background ">
    <div class="formulairePlante">
        <h2 class="formulairePlante__titre">Ajouter votre plante</h2>

        <form class="formulairePlante__form" method="post">
            <label class="formulairePlante__label">
                Nom de votre plante
                <input type="text" name="nom" class="formulairePlante__input" required>
            </label>
            {% if errors.nom is defined %}
                <span class="error">{{ errors.nom }}</span>
            {% endif %}

            <label class="formulairePlante__label">
                Type de plante
                <input type="text" name="typePlante" class="formulairePlante__input">
            </label>

            <label class="formulairePlante__label">
                Date d'aquisition de votre plante
                <input type="date" name="dateAcquisition" class="formulairePlante__input" required>
            </label>
            {% if errors.dateAcquisition is defined %}
                <span class="error">{{ errors.dateAcquisition }}</span>
            {% endif %}

            <input type="submit" value="Ajouter la plante" class="formulairePlante__bouton">
        </form>

        <p class="formulairePlante__texte">
            Annuler la création <a href="dreamplante" class="formulairePlante__lien">Annuler</a>
        </p>
    </div>
</body>

{{ include('layouts/footer.php')}}
