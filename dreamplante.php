<?php
session_start();

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: connexion.php');
    exit;
}

$nomUtilisateur = $_SESSION['nomUtilisateur'];
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamPlante</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="dreamplante">
    <nav class="dreamplante__nav">
        <div class="dreamplante__nav-gauche">
            <p class="dreamplante__plante-nom">Nom plante</p>
            <button class="dreamplante__ajouter">+</button>
        </div>

        <div class="dreamplante__nav-droite">
            <span class="dreamplante__utilisateur-nom"> <?php echo ($nomUtilisateur); ?></span>
            <a class="dreamplante__modifier" href="classes/utilisateur/utilisateur-edit.php">Modifier</a>
            <a class="dreamplante__deconnexion" href="classes/utilisateur/utilisateur-deconnexion.php">Déconnexion</a>
        </div>
    </nav>


    <main class="dreamplante__conteneur">
        <section class="dreamplante__plante boite">
            <div class="dreamplante__entete">
                <h2 class="dreamplante__plante-titre">nom plante</h2>
                <button class="dreamplante__modif">
                    <img src="assets/img/edit.png" alt="Modifier" class="dreamplante__modif-icon">
                </button>
            </div>
            <div class="dreamplante__plante-contenu">
                <!-- Contenu des plantes -->
            </div>
        </section>

        <section class="dreamplante__evenements boite">
            <div class="dreamplante__entete">
                <h2 class="dreamplante__evenements-titre">Événements</h2>
                <button class="dreamplante__ajouter">+</button>
            </div>
            <div class="dreamplante__evenements-contenu">
                <!-- Contenu des événements -->
            </div>
        </section>

        <aside class="dreamplante__notes boite">
            <div class="dreamplante__entete">
                <h2 class="dreamplante__notes-titre">Notes</h2>
                <button class="dreamplante__ajouter">+</button>
            </div>
            <!-- <button class="dreamplante__retirer">-</button> -->

            <div class="dreamplante__notes-contenu">
                <!-- Notes utilisateur -->
            </div>
        </aside>
    </main>

</body>
</html>
