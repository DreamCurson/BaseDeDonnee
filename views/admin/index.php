{{ include('layouts/headerAdmin.php', {title:'Dreamplante Admin'}) }}

<div class="table-plante-boite">
    <h1 class="page-title">Liste des plantes</h1>

    <table class="table-plante">
        <thead class="table-plante__head">
            <tr class="table-plante__row table-plante__row--header">
                <th class="table-plante__cell table-plante__cell--head">Nom Plante</th>
                <th class="table-plante__cell table-plante__cell--head">Type</th>
                <th class="table-plante__cell table-plante__cell--head">Date d’acquisition</th>
                <th class="table-plante__cell table-plante__cell--head">Utilisateur</th>
            </tr>
        </thead>
        <tbody class="table-plante__body">
            {% for plante in plantes %}
            <tr class="table-plante__row">
                <td class="table-plante__cell">
                    <a href="" class="table-plante__link">{{ plante.nom }}</a>
                </td>
                <td class="table-plante__cell">{{ plante.typePlante }}</td>
                <td class="table-plante__cell">{{ plante.dateAcquisition }}</td>
                <td class="table-plante__cell">{{ plante.utilisateur_idUtilisateur }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

{{ include('layouts/footer.php') }}
