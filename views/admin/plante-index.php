{{ include('layouts/header.php', {title: 'Admin | Information plante'})}}
<script type="module" src="{{ asset }}script/main.js"></script>

<body class="page-background">
    <div class="info-container">
        <h1 class="page-title">Information sur la plante</h1>

        <div class="section plante-info">
            <div class="dreamplante__entete margin">
                <h2 class="section-title">Plante</h2>
                <a href="admin-modifierPlante?id={{ plante.idPlante }}" class="bouton__modifier">
                    <img src="{{ img }}edit.png" alt="Modifier" class="bouton__modifier-icon">
                </a>
            </div>
            <div class="section-content">
                <p><strong>Nom:</strong> {{ plante.nom }}</p>
                <p><strong>Type de plante:</strong> {{ plante.typePlante }}</p>
                <p><strong>Date d'acquisition:</strong> {{ plante.dateAcquisition }}</p>
                <p><strong>Utilisateur associé:</strong> {{ plante.nomUtilisateur }}</p>
            </div>
        </div>

        <div class="section evenement-info">
            <div class="dreamplante__entete margin">
                <h2 class="section-title">Événements</h2>
                <a href="admin-ajouterEvenement?id={{ plante.idPlante }}" class="bouton__ajouter">+</a>
            </div>

            {% if evenements is not empty %}
                <div class="events-list">
                    {% for evenement in evenements %}
                        <div class="note-item">
                            <div class="note-item-flex">
                                <p><strong>Date:</strong> {{ evenement.date }}</p>
                                <p><strong>Type d'événement:</strong> {{ evenement.typeEvenement }}</p>
                                <p><strong>Commentaire:</strong> {{ evenement.commentaire }}</p>
                            </div>
                            <a href="admin-supprimerEvenement?id={{ evenement.idEvenement }}&idPlante={{ plante.idPlante }}" class="bouton__retirer">-</a>
                        </div>
                    {% endfor %}
                </div>
            {% else %}
                <p>Aucun événement associé à cette plante.</p>
            {% endif %}
        </div>

        <div class="section note-info">
            <div class="dreamplante__entete margin">
                <h2 class="section-title">Notes</h2>
                <a href="admin-ajouterNote?id={{ plante.idPlante }}" class="bouton__ajouter">+</a>
            </div>

            {% if notes is not empty %}
                <div class="notes-list">
                    {% for note in notes %}
                        <div class="note-item">
                            <div class="note-item-flex">
                                <p><strong>Titre:</strong> {{ note.titre }}</p>
                                <p><strong>Contenu:</strong> {{ note.contenu }}</p>
                            </div>
                            <a href="admin-supprimerNote?id={{ note.idNote }}&idPlante={{ plante.idPlante }}" class="bouton__retirer">-</a>
                        </div>
                    {% endfor %}
                </div>
            {% else %}
                <p>Aucune note associée à cette plante.</p>
            {% endif %}
        </div>

        <div class="formulaireUtilisateur__bouton">
            <button type="button" class="formulaireUtilisateur__delete">Supprimer la plante</button>
            <a href="admin-supprimerPlante?id={{ plante.idPlante }}" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>

        <p class="formulaireInscription__texte">
            <a href="admin" class="formulaireInscription__lien">Retour</a>
        </p>
    </div>
</body>

{{ include('layouts/footer.php') }}
