{{ include('layouts/header.php', {title: 'DreamPlante | Modifier une Plante'})}}
<script type="module" src="{{ asset }}script/main.js"></script>

<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier la plante</h1>

        <form class="formulaireUtilisateur__form" method="post">
            <input type="hidden" name="idPlante" value="{{ plante.idPlante }}">

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
            <a href="planteDelete?id={{ plante.idPlante }}" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>
    </div>
</body>
</html>
