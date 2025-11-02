{{ include('layouts/header.php', { title: 'DreamPlante | Modifier un événement' }) }}
<script type="module" src="{{ asset }}script/main.js"></script>

<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier l'événement</h1>

        <form class="formulaire__form" method="post">
            <input type="hidden" name="idPlante" value="{{ idPlante }}">

            <label class="formulaire__label">
                Type d’événement
                <select name="idTypeEvenement" class="formulaire__input" required>
                    <option value="" disabled {% if evenement.idTypeEvenement is not defined %}selected{% endif %}>Sélectionnez un type</option>
                    {% for type in typesEvenement %}
                        <option value="{{ type.idTypeEvenement }}"
                            {% if evenement.idTypeEvenement is defined and type.idTypeEvenement == evenement.idTypeEvenement %}selected{% endif %}>
                            {{ type.typeEvenement }}
                        </option>
                    {% endfor %}
                </select>

            </label>

            <label class="formulaire__label">
                Commentaire
                <textarea name="commentaire" class="formulaire__input" rows="4">{{ evenement.commentaire }}</textarea>
            </label>
            {% if errors.commentaire is defined %}
                <span class="error">{{ errors.commentaire }}</span>
            {% endif %}
            
            <label class="formulaire__label">
                Date de l’événement
                <input 
                    type="date" 
                    name="date" 
                    class="formulaire__input" 
                    value="{{ evenement.date }}"
                >
            </label>

            <button type="submit" class="formulaire__button">Enregistrer</button>
        </form>

        <div class="formulaireUtilisateur__bouton">
            <button type="button" class="formulaireUtilisateur__delete">Supprimer l'évènement</button>
            <a href="evenementDelete?id={{ evenement.idEvenement }}" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>
    </div>
</body>

{{ include('layouts/footer.php') }}
