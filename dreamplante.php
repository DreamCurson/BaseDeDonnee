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

$plantes = $crud->selectWhere('plante', 'utilisateur_idUtilisateur', $idUtilisateur);

$idPlante = $_SESSION['planteSelectionnee'] ?? null;
$planteSelectionnee = null;

if ($idPlante) {
    $planteSelectionnee = $crud->selectId('plante', $idPlante, 'idPlante');
}

if (!empty($planteSelectionnee['dateAcquisition'])) {
    $dateAcquisition = new DateTime($planteSelectionnee['dateAcquisition']);
    $aujourdhui = new DateTime();
    $interval = $dateAcquisition->diff($aujourdhui);
    $ageParts = [];

    // Si la plante a au moins 1 an,
    // on ajoute le nombre d’années dans le tableau $ageParts.
    // Exemple : "1 an" || "2 ans" ("s" si pluriel)
    if ($interval->y > 0)
    $ageParts[] = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');


    // Si la plante a au moins 1 mois,
    // on ajoute le nombre de mois dans le tableau $ageParts.
    // Exemple : "2 mois"
    if ($interval->m > 0)
    $ageParts[] = $interval->m . ' mois';


    // Si la plante n’a pas encore un an complet (moins de 12 mois),
    // et qu’il y a au moins 1 jour,
    // on ajoute le nombre de jours dans le tableau $ageParts.
    // "1 jour" || "2 jours" ("s" si pluriel)
    if ($interval->d > 0 && $interval->y === 0)
    $ageParts[] = $interval->d . ' jour' . ($interval->d > 1 ? 's' : '');

    $ageTexte = implode(' ', $ageParts);

    if (empty($ageTexte)) $ageTexte = "moins d’un jour";

} else {
    $ageTexte = "Date inconnue";
}


$erreur = $_GET['erreur'] ?? null;

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

<?php if ($erreur === 'supprimer'): ?>
    <dialog open id="warningDialog">
        <p>Échec lors de la suppression d'une plante</p>
        <form method="dialog">
            <button>Fermer</button>
        </form>
    </dialog>
<?php endif; ?>

<nav class="dreamplante__nav">
    <div class="dreamplante__nav-gauche">
        <?php if (empty($plantes)): ?>
            <div class="dreamplante__nav_aucune">
            </div>
        <?php else: ?>
            <?php foreach ($plantes as $plante): ?>
                <form action="classes/plante/plante-select.php" method="post" style="display:inline;">
                    <input type="hidden" name="idPlante" value="<?= ($plante['idPlante']) ?>">
                    <button type="submit" class="dreamplante__plante-nom">
                        <?= ($plante['nom']) ?>
                    </button>
                </form>
            <?php endforeach; ?>
        <?php endif; ?>
        <a href="classes/plante/plante-create.php" class="bouton__ajouter">+</a>
    </div>

    <div class="dreamplante__nav-droite">
        <span class="dreamplante__utilisateur-nom"><?= ($nomUtilisateur) ?></span>
        <a class="dreamplante__modifier" href="classes/utilisateur/utilisateur-edit.php">Modifier</a>
        <a class="dreamplante__deconnexion" href="classes/utilisateur/utilisateur-deconnexion.php">Déconnexion</a>
    </div>
</nav>

<main class="dreamplante__conteneur">
    <section class="dreamplante__plante boite">
        <?php if ($idPlante && $planteSelectionnee): ?>
            <div class="dreamplante__entete">
                <h2 class="dreamplante__plante-titre"><?= ($planteSelectionnee['nom']) ?></h2>
                <a href="classes/plante/plante-edit.php?id=<?= $planteSelectionnee['idPlante']; ?>" class="bouton__modifier">
                    <img src="assets/img/edit.png" alt="Modifier" class="bouton__modifier-icon">
                </a>
            </div>
            <div class="dreamplante__plante-contenu">
                <p>Type : <?= ($planteSelectionnee['typePlante']); ?></p>
                <p>Acquise le : <?= ($planteSelectionnee['dateAcquisition']); ?></p>
                <p>Âge : <?= ($ageTexte); ?></p>
            </div>

        <?php elseif (empty($plantes)): ?>
            <div class="dreamplante__aucune">
                <p>Ajouter une plante pour commencer</p>
                <a href="classes/plante/plante-create.php" class="bouton__ajouter">+</a>
            </div>
        <?php else: ?>
            <div class="dreamplante__aucune">
                <p>Sélectionnez une plante dans la navigation</p>
            </div>
        <?php endif; ?>
    </section>

    <section class="dreamplante__evenements boite">
        <div class="dreamplante__entete">
            <h2 class="dreamplante__evenements-titre">Événements</h2>
            <a href="classes/evenements/evenements-create.php" class="bouton__ajouter">+</a>
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
