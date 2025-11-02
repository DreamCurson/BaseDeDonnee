<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamPlante {{ nomUtilisateur }}</title>
    <link rel="stylesheet" href="{{ asset }}css/style.css">
</head>
<body class="dreamplante">
    <nav class="dreamplante__nav">
        <div class="dreamplante__nav-gauche">
            {% if plantesUtilisateur is empty %}
                <!-- Aucune plante trouvée -->
                <div class="dreamplante__nav_aucune">
                </div>
            {% else %}
                <!-- Liste des plantes appartenant à l’utilisateur -->
                {% for plante in plantesUtilisateur %}
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="idPlante" value="{{ plante.idPlante }}">
                        <button type="submit" class="dreamplante__plante-nom">
                            {{ plante.nom }}
                        </button>
                    </form>
                {% endfor %}
            {% endif %}

            <!-- Bouton pour ajouter une nouvelle plante -->
            <a href="planteAjoute" class="bouton__ajouter">+</a>
        </div>

        <!-- Zone utilisateur : nom, modifier, déconnexion -->
        <div class="dreamplante__nav-droite">
            <span class="dreamplante__utilisateur-nom">{{ nomUtilisateur }}</span>
            <a class="dreamplante__modifier" href="modifierUtilisateur?id={{ idUtilisateur }}">Modifier</a>
            <a class="dreamplante__deconnexion" href="logout">Déconnexion</a>
        </div>
    </nav>
        
    <main class="dreamplante__conteneur">
        <section class="dreamplante__plante boite">

            {% if idPlante and planteSelectionnee %}
                <!-- Détails de la plante sélectionnée -->
                <div class="dreamplante__entete">
                    <h2 class="dreamplante__plante-titre">{{ planteSelectionnee.nom }}</h2>
                    <a href="planteModifie?id={{ idPlante }}" class="bouton__modifier">
                        <img src="{{ img }}edit.png" alt="Modifier" class="bouton__modifier-icon">
                    </a>
                </div>
                <div class="dreamplante__plante-contenu">
                <p>Type : {{ planteSelectionnee.typePlante|default('Pas défini') }}</p>
                    <p>Acquise le : {{ planteSelectionnee.dateAcquisition }}</p>
                    <p>Âge : {{ planteSelectionnee.ageTexte }}</p>
                </div>

            {% elseif plantesUtilisateur is empty %}
                <!-- Aucune plante encore ajoutée -->
                <div class="dreamplante__aucune">
                    <p>Ajouter une plante pour commencer</p>
                    <a href="planteAjoute" class="bouton__ajouter">+</a>
                </div>

            {% else %}
                <!-- Aucune plante sélectionnée -->
                <div class="dreamplante__aucune">
                    <p>Sélectionnez une plante dans la navigation</p>
                </div>
            {% endif %}
        </section>
    </main>
</body>
</html>
