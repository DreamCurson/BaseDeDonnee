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

        <section class="dreamplante__evenements boite">
            {% if idPlante and planteSelectionnee %}
                <div class="dreamplante__entete">
                    <h2 class="dreamplante__evenements-titre">Événements</h2>
                    <a href="evenementAjoute?idPlante={{ planteSelectionnee.idPlante }}" class="bouton__ajouter">+</a>
                </div>

                {% if evenements is not empty %}
                    <div class="dreamplante__evenements-contenu">
                        {% for evenement in evenements %}
                            <div class="dreamplante__evenement {{ evenement.typeClass }}">
                                <div class="dreamplante__evenement_contenu">
                                    <p><strong>{{ evenement.typeNom }}</strong></p>
                                    <p>{{ evenement.date }}</p>
                                    <p>{{ evenement.commentaire }}</p>
                                </div>
                                <div class="dreamplante__evenement_bouton">
                                    <a href="evenementModifie?id={{ evenement.idEvenement }}" class="bouton__modifier_petit">
                                        <img src="{{ img }}edit.png" alt="Modifier" class="bouton__modifier-icon">
                                    </a>
                                    <a href="" class="bouton__retirer">-</a>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                {% else %}
                    <div class="dreamplante__aucune">
                        <p>Aucun événement à ce jour</p>
                    </div>
                {% endif %}

            {% elseif plantesUtilisateur is empty %}
                <div class="dreamplante__aucune">
                    <p>Ajouter une plante pour créer des événements</p>
                </div>
            {% else %}
                <div class="dreamplante__aucune">
                    <p>Sélectionnez une plante pour voir ses événements</p>
                </div>
            {% endif %}
        </section>


        <aside class="dreamplante__notes boite">
            <div class="dreamplante__entete">
                <h2 class="dreamplante__notes-titre">Notes</h2>
            </div>

            <div class="dreamplante__notes-contenu">
                {% if idPlante and planteSelectionnee %}
                    {% if notes is not empty %}
                        {% for note in notes %}
                            <div class="dreamplante__note">
                                <div class="dreamplante__note_contenu">
                                    <p><strong>{{ note.titre }}</strong></p>
                                    <p>{{ note.contenu }}</p>
                                </div>
                                <div class="dreamplante__note_bouton">
                                    <a href="" class="bouton__modifier_petit">
                                        <img src="{{ img }}edit.png" alt="Modifier" class="bouton__modifier-icon">
                                    </a>
                                    <a href="" class="bouton__retirer">-</a>
                                </div>
                            </div>
                        {% endfor %}
                    {% else %}
                        <div class="dreamplante__aucune">
                            <p>Fonction désactivé pour l'instant</p>
                        </div>
                    {% endif %}
                {% elseif plantesUtilisateur is empty %}
                    <div class="dreamplante__aucune">
                        <p>Fonction désactivé pour l'instant</p>
                    </div>
                {% else %}
                    <div class="dreamplante__aucune">
                        <p>Fonction désactivé pour l'instant</p>
                    </div>
                {% endif %}
            </div>
        </aside>

    </main>
</body>
</html>
