{{ include('layouts/header.php', {title:'Dreamplante Admin'})}}
    <h1>Liste de chaque plante</h1>
    <table>
        <tr>
            <th>Nom</th>
            <th>typePlante</th>
            <th>dateAcquisition</th>
            <th>utilisateur_idUtilisateur</th>
        </tr>
        {% for plante in plantes %}
        <tr>
            <td><a href="">{{ plante.nom }}</a></td>
            <td>{{ plante.typePlante }}</td>
            <td>{{ plante.dateAcquisition }}</td>
            <td>{{ plante.utilisateur_idUtilisateur }}</td>
        </tr>
        {% endfor %}
    </table>

    <!-- clic sur plante donne evenement et note  -->
{{ include('layouts/footer.php')}}
</body>
</html>