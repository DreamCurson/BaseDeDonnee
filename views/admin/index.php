{{ include('layouts/headerAdmin.php', {title:'Dreamplante Admin'}) }}
<aside class="admin-nav">
    <p class="admin-p"> Bonjour {{ user.nomUtilisateurAdmin }}</p>
    <a class="dreamplante__deconnexion" href="logout">Déconnexion</a>
</aside>

<div class="table-plante-boite">
    <h2 class="page-title">Liste des utilisateurs</h1>
    <p class="formulaireInscription__texte">
        <a href="admin-ajouterUtilisateur" class="formulaireInscription__lien bottom">Ajouter un utilisateur</a>
    </p>

    <table class="table-plante">
        <thead class="table-plante__head">
            <tr class="table-plante__row table-plante__row--header">
                <th class="table-plante__cell table-plante__cell--head">Nom Utilisateur</th>
                <th class="table-plante__cell table-plante__cell--head">Mot de passe chiffré</th>
                <th class="table-plante__cell table-plante__cell--head">Action</th>
            </tr>
        </thead>
        <tbody class="table-plante__body">
            {% for utilisateur in utilisateurs %}
            <tr class="table-plante__row">
                <td class="table-plante__cell">{{ utilisateur.nomUtilisateur }}</td>
                <td class="table-plante__cell">{{ utilisateur.motDePasse }}</td>
                <td class="table-plante__cell_modifier">
                    <a href="admin-modifierUtilisateur?id={{ utilisateur.idUtilisateur }}" class="bouton__modifier_petit bouton__modifier_action">
                        <img src="{{ img }}edit.png" alt="Modifier" class="bouton__modifier-icon">
                    </a>
                </td>
                <td class="table-plante__cell_modifier"><a href="admin-supprimerUtilisateur?id={{ utilisateur.idUtilisateur }}" class="bouton__retirer_action">-</a></td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

<div class="table-plante-boite">
    <h2 class="page-title">Liste des plantes</h1>
    <p class="formulaireInscription__texte">
        <a href="admin-ajouterPlante" class="formulaireInscription__lien bottom">Ajouter une plante</a>
    </p>

    <table class="table-plante">
        <thead class="table-plante__head">
            <tr class="table-plante__row table-plante__row--header">
                <th class="table-plante__cell table-plante__cell--head">Nom Plante</th>
                <th class="table-plante__cell table-plante__cell--head">Type</th>
                <th class="table-plante__cell table-plante__cell--head">Date d’acquisition</th>
                <th class="table-plante__cell table-plante__cell--head">Utilisateur</th>
                <th class="table-plante__cell table-plante__cell--head">Action</th>
            </tr>
        </thead>
        <tbody class="table-plante__body">
            {% for plante in plantes %}
            <tr class="table-plante__row">
                <td class="table-plante__cell">{{ plante.nom }}</td>
                <td class="table-plante__cell">{{ plante.typePlante }}</td>
                <td class="table-plante__cell">{{ plante.dateAcquisition }}</td>
                <td class="table-plante__cell">{{ plante.utilisateur_nomUtilisateur }}</td>
                <td class="table-plante__cell_modifier">
                    <a href="admin-planteInfo?id={{ plante.idPlante }}" class="bouton__modifier_petit bouton__modifier_action">
                        <img src="{{ img }}edit.png" alt="Modifier" class="bouton__modifier-icon">
                    </a>
                </td>
                <td class="table-plante__cell_modifier"><a href="admin-supprimerPlante?id={{ plante.idPlante }}" class="bouton__retirer_action">-</a></td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

<h2 class="page-title">Liste des Icônes</h2>

<div class="icon-gallery">
    {% for icon in icons %}
        <div class="icon-gallery__item">
            <img src="data:image/png;base64,{{ icon.iconBase64 }}" alt="Icône {{ icon.idIcon }}" class="icon-gallery__image">
            <form class="icon-gallery__delete-form" action="admin-deleteIcon" method="post">
                <input type="hidden" name="idIcon" value="{{ icon.idIcon }}">
                <button type="submit" class="icon-gallery__delete-btn">Supprimer</button>
            </form>
        </div>
    {% endfor %}
</div>

<aside class="icon-upload">
    <form class="icon-upload__form" action="uploadIcon" method="post" enctype="multipart/form-data">
        <label class="icon-upload__label" for="fileToUpload">Ajouter un icone :</label>
        <input type="file" name="fileToUpload" id="fileToUpload" class="icon-upload__input">
        <input type="submit" value="Ajouter l'icône" name="submit" class="icon-upload__submit">
    </form>
</aside>

{{ include('layouts/footer.php') }}
