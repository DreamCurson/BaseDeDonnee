{{ include('layouts/header.php', {title: 'Admin | Ajouter une plante'}) }}
<body class="formulaire__background">
    <div class="formulaire">
        <h1 class="formulaire__title">Ajouter un événement</h1>

        <form class="formulaire__form" method="post">
            <input type="hidden" name="idPlante" value="{{ evenement.idPlante|default(planteSelectionnee.idPlante) }}">

            <label class="formulaire__label">
                Type d’événement
                <select name="idTypeEvenement" class="formulaire__input" required>
                    <option value="" disabled
                        {% if evenement.idTypeEvenement is not defined %}selected{% endif %}>
                        Sélectionnez un type
                    </option>
                    {% for type in typesEvenement %}
                        <option value="{{ type.idTypeEvenement }}"
                            {% if evenement.idTypeEvenement is defined and type.idTypeEvenement == evenement.idTypeEvenement %}selected{% endif %}>
                            {{ type.typeEvenement }}
                        </option>
                    {% endfor %}
                </select>
            </label>
            {% if errors.typeEvenement is defined %}
                <span class="error">{{ errors.typeEvenement }}</span>
            {% endif %}

            <label class="formulaire__label">
                Commentaire
                <textarea name="commentaire" class="formulaire__input" rows="4">{{ evenement.commentaire|default('') }}</textarea>
            </label>
            {% if errors.commentaire is defined %}
                <span class="error">{{ errors.commentaire }}</span>
            {% endif %}

            <label class="formulaire__label">
                Date de l’événement
                <input 
                    required
                    type="date" 
                    name="date" 
                    class="formulaire__input" 
                    value="{{ evenement.date|default('now'|date('Y-m-d')) }}"
                >
            </label>

            <button type="submit" class="formulaire__button">Enregistrer</button>
        </form>

        <p class="formulairePlante__texte">
            <a href="admin-planteInfo?id={{ planteSelectionnee.idPlante }}" class="formulairePlante__lien">Retour</a>
        </p>
    </div>
</body>
