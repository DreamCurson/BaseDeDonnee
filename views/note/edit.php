{{ include('layouts/header.php', { title: 'DreamPlante | Modifier un événement' }) }}
<script type="module" src="{{ asset }}script/main.js"></script>

<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier l'événement</h1>

        <form class="formulaireUtilisateur__form" method="post">
            <input type="hidden" name="idPlante" value="{{ note.idPlante }}">
            <input type="hidden" name="idNote" value="{{ note.idNote }}"> 

            <label class="formulaireUtilisateur__label">
                Titre de la note
                <input 
                    value="{{ note.titre }}"
                    type="text" 
                    name="titre" 
                    class="formulaireUtilisateur__input" 
                    placeholder="Exemple : Entretien d'automne"
                    required
                >
            </label>
            {% if errors.titre is defined %}
                <span class="error">{{ errors.titre }}</span>
            {% endif %}

            <label class="formulaireUtilisateur__label">
                Contenu
                <textarea 
                    name="contenu" 
                    class="formulaireUtilisateur__input" 
                    rows="5" 
                    required
                >{{ note.contenu }}</textarea>
            </label>

            <button type="submit" class="formulaireUtilisateur__button">Enregistrer</button>
        </form>

        <div class="formulaireUtilisateur__bouton">
            <button type="button" class="formulaireUtilisateur__delete">Supprimer la note</button>
            <a href="noteDelete?id={{ note.idNote }}" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>
    </div>
</body>
