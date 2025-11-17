{% include 'layouts/header.php' with {title: 'Admin | Ajouter une note'} %}

<body class="formulaire__background">

    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Ajouter une note</h1>
        <form class="formulaireUtilisateur__form" method="post">
            <input type="hidden" name="idPlante" value="{{ idPlante }}">

            <label class="formulaireUtilisateur__label">
                Titre de la note
                <input 
                    type="text" 
                    name="titre" 
                    class="formulaireUtilisateur__input" 
                    placeholder="Exemple : Entretien d'automne"
                    required
                    value="{{ note.titre }}"
                >
            </label>
            {% if errors.titre is defined %}
                <span class="error">{{ errors.titre }}</span>
            {% endif %}

            <label class="formulaireUtilisateur__label">
                <textarea 
                    name="contenu" 
                    class="formulaireUtilisateur__input" 
                    rows="5" 
                    placeholder="Ajoutez ici vos observations..."
                    required
                >{{ note.contenu }}</textarea>
            </label>

            <button type="submit" class="formulaireUtilisateur__button">Enregistrer</button>
        </form>

        <p class="formulairePlante__texte">
            <a href="admin-planteInfo?id={{ idPlante }}" class="formulairePlante__lien">Retour</a>
        </p>
    </div>

</body>

{% include 'layouts/footer.php' %}
