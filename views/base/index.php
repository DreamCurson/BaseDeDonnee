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
            <?php if (empty($plantes)): ?>
                <!-- Aucune plante trouvé -->
                <div class="dreamplante__nav_aucune">
                </div>
            <?php else: ?>
                <!-- Liste des plantes appartenant à l’utilisateur -->
                <?php foreach ($plantes as $plante): ?>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="idPlante" value="">
                        <button type="submit" class="dreamplante__plante-nom">Nom Plante</button>
                    </form>
                <?php endforeach; ?>
            <?php endif; ?>
            <!-- Bouton pour ajouter une nouvelle plante -->
            <a href="" class="bouton__ajouter">+</a>
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
            <?php if ($idPlante && $planteSelectionnee): ?>
                <!-- Détails de la plante sélectionnée -->
                <div class="dreamplante__entete">
                    <h2 class="dreamplante__plante-titre"></h2>
                    <a href="" class="bouton__modifier">
                        <img src="{{ img }}edit.png" alt="Modifier" class="bouton__modifier-icon">
                    </a>
                </div>
                <div class="dreamplante__plante-contenu">
                    <p>Type : </p>
                    <p>Acquise le : </p>
                    <p>Âge : </p>
                </div>

            <?php elseif (empty($plantes)): ?>
                <!-- Aucune plante encore ajoutée -->
                <div class="dreamplante__aucune">
                    <p>Ajouter une plante pour commencer</p>
                    <a href="classes/plante/plante-create.php" class="bouton__ajouter">+</a>
                </div>
            <?php else: ?>
                <!-- Aucune plante sélectionnée -->
                <div class="dreamplante__aucune">
                    <p>Sélectionnez une plante dans la navigation</p>
                </div>
            <?php endif; ?>
        </section>
    </main>

</body>