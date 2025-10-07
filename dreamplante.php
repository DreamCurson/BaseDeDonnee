<?php
session_start();

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: connexion.php');
    exit;
}

require_once('classes/CRUD.php');
$crud = new CRUD;

$nomUtilisateur = $_SESSION['nomUtilisateur'];
$idUtilisateur = $_SESSION['idUtilisateur'];

// var_dump($idUtilisateur);

$plantes = $crud->selectWhere('plante', 'utilisateur_idUtilisateur', $idUtilisateur);

// var_dump($plantes);
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
            <?php if (empty($plantes)): ?>
                <div class="dreamplante__nav_aucune">
                    <p>Ajouter une plante</p>
                </div>
            <?php else: ?>
                <?php foreach ($plantes as $plante): ?>
                    <p class="dreamplante__plante-nom"><?= ($plante['nom']); ?></p>
                <?php endforeach; ?>
             <?php endif; ?>
            <a href="classes/plante/plante-create.php" class="bouton__ajouter">+</a>
        </div>

        <div class="dreamplante__nav-droite">
            <span class="dreamplante__utilisateur-nom"> <?php echo ($nomUtilisateur); ?></span>
            <a class="dreamplante__modifier" href="classes/utilisateur/utilisateur-edit.php">Modifier</a>
            <a class="dreamplante__deconnexion" href="classes/utilisateur/utilisateur-deconnexion.php">Déconnexion</a>
        </div>
    </nav>


    <main class="dreamplante__conteneur">
        <section class="dreamplante__plante boite">
            <?php if (empty($plantes)): ?>
                <div class="dreamplante__aucune">
                    <p>Ajouter une plante pour commencer</p>
                    <a href="classes/plante/plante-create.php" class="bouton__ajouter">+</a>
                </div>
            <?php else: ?>
                <?php foreach ($plantes as $plante): ?>
                    <div class="dreamplante__entete">
                        <h2 class="dreamplante__plante-titre"><?= ($plante['nom']); ?></h2>
                        <a href="classes/plante/plante-edit.php?id=<?= $plante['idPlante']; ?>" class="bouton__modifier">
                            <img src="assets/img/edit.png" alt="Modifier" class="bouton__modifier-icon">
                        </a>
                    </div>
                    <div class="dreamplante__plante-contenu">
                        <p>Type : <?= ($plante['typePlante']); ?></p>
                        <p>Acquise le : <?= ($plante['dateAcquisition']); ?></p>
                        <p>Age : </p>
                    </div>
                <?php endforeach; ?>
             <?php endif; ?>
        </section>


        <section class="dreamplante__evenements boite">
            <div class="dreamplante__entete">
                <h2 class="dreamplante__evenements-titre">Événements</h2>
                <button class="bouton__ajouter">+</button>
            </div>
            <div class="dreamplante__evenements-contenu">
                <!-- Contenu des événements -->
            </div>
        </section>

        <aside class="dreamplante__notes boite">
            <div class="dreamplante__entete">
                <h2 class="dreamplante__notes-titre">Notes</h2>
                <button class="bouton__ajouter">+</button>
            </div>

            <div class="dreamplante__notes-contenu">
                <!-- Notes utilisateur -->
            </div>
        </aside>
    </main>

</body>
</html>
