{{ include('layouts/headerAdmin.php', {title:'Dreamplante Admin'}) }}
<div class="table-plante-boite">
    <h2 class="page-title">Liste des utilisateurs</h1>
    <p class="formulaireInscription__texte">
        <a href="" class="formulaireInscription__lien bottom">Ajouter un utilisateur</a>
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
        <a href="" class="formulaireInscription__lien bottom">Ajouter une plante</a>
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
                    <a href="" class="bouton__modifier_petit bouton__modifier_action">
                        <img src="{{ img }}edit.png" alt="Modifier" class="bouton__modifier-icon">
                    </a>
                </td>
                <td class="table-plante__cell_modifier"><a href="admin-supprimerPlante?id={{ plante.idPlante }}" class="bouton__retirer_action">-</a></td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

{{ include('layouts/footer.php') }}
