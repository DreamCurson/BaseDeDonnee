<?php
session_start();

// Vérifie que l'utilisateur est connecté, sinon redirige vers la page de connexion
if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: index.php');
    exit;
}

require_once('classes/CRUD.php');
$crud = new CRUD;

// Récupération des infos de l'utilisateur connecté
$nomUtilisateur = $_SESSION['nomUtilisateur'];
$idUtilisateur = $_SESSION['idUtilisateur'];

// Récupère toutes les plantes appartenant à l'utilisateur
$plantes = $crud->selectWhere('plante', 'utilisateur_idUtilisateur', $idUtilisateur);

// Récupère la plante sélectionnée (si une plante a été choisie précédemment dans la navigation)
$idPlante = $_SESSION['planteSelectionnee'] ?? null;
$planteSelectionnee = null;

if ($idPlante) {
    $planteSelectionnee = $crud->selectId('plante', $idPlante, 'idPlante');
}

// Calcule l’âge de la plante sélectionnée à partir de sa date d’acquisition
if (!empty($planteSelectionnee['dateAcquisition'])) {
    $dateAcquisition = new DateTime($planteSelectionnee['dateAcquisition']);
    $aujourdhui = new DateTime();
    $interval = $dateAcquisition->diff($aujourdhui);
    $ageParts = [];

    // Si la plante a au moins 1 an
    if ($interval->y > 0)
    $ageParts[] = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');

    // Si la plante a au moins 1 mois
    if ($interval->m > 0)
    $ageParts[] = $interval->m . ' mois';

    // Si la plante a moins d’un an mais au moins 1 jour
    if ($interval->d > 0 && $interval->y === 0)
    $ageParts[] = $interval->d . ' jour' . ($interval->d > 1 ? 's' : '');

    $ageTexte = implode(' ', $ageParts);

    // Si aucun âge calculable, indique "moins d’un jour"
    if (empty($ageTexte)) $ageTexte = "moins d’un jour";

} else {
    $ageTexte = "Date inconnue";
}

// Récupère tous les événements associés à la plante sélectionnée (triés par date décroissante)
$evenements = [];
if ($idPlante) {
    $evenements = $crud->selectByDate('evenement', 'idPlante', $idPlante, 'date', 'DESC');
}

// Vérifie s’il y a un message d’erreur
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
        <!-- Fenêtre d’avertissement en cas d’erreur de suppression -->
        <dialog open id="warningDialog">
            <p>Échec lors de la suppression d'une plante ou d'un événement</p>
            <form method="dialog">
                <button>Fermer</button>
            </form>
        </dialog>
    <?php endif; ?>

    <nav class="dreamplante__nav">
        <div class="dreamplante__nav-gauche">
            <?php if (empty($plantes)): ?>
                <!-- Aucune plante trouvé -->
                <div class="dreamplante__nav_aucune">
                </div>
            <?php else: ?>
                <!-- Liste des plantes appartenant à l’utilisateur -->
                <?php foreach ($plantes as $plante): ?>
                    <form action="classes/plante/plante-select.php" method="post" style="display:inline;">
                        <input type="hidden" name="idPlante" value="<?= ($plante['idPlante']) ?>">
                        <button type="submit" class="dreamplante__plante-nom">
                            <?= ($plante['nom']) ?>
                        </button>
                    </form>
                <?php endforeach; ?>
            <?php endif; ?>
            <!-- Bouton pour ajouter une nouvelle plante -->
            <a href="classes/plante/plante-create.php" class="bouton__ajouter">+</a>
        </div>

        <!-- Zone utilisateur : nom, modifier, déconnexion -->
        <div class="dreamplante__nav-droite">
            <span class="dreamplante__utilisateur-nom"><?= ($nomUtilisateur) ?></span>
            <a class="dreamplante__modifier" href="classes/utilisateur/utilisateur-edit.php">Modifier</a>
            <a class="dreamplante__deconnexion" href="classes/utilisateur/utilisateur-deconnexion.php">Déconnexion</a>
        </div>
    </nav>

    <main class="dreamplante__conteneur">
        <section class="dreamplante__plante boite">
            <?php if ($idPlante && $planteSelectionnee): ?>
                <!-- Détails de la plante sélectionnée -->
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

        <section class="dreamplante__evenements boite">
            <?php if ($idPlante && $planteSelectionnee): ?>
                <div class="dreamplante__entete">
                    <h2 class="dreamplante__evenements-titre">Événements</h2>
                    <!-- ajouter un nouvel événement -->
                    <a href="classes/evenements/evenements-create.php" class="bouton__ajouter">+</a>
                </div>

                <?php if (!empty($evenements)): ?>
                    <!-- Liste des événements -->
                    <div class="dreamplante__evenements-contenu">
                        <?php foreach ($evenements as $evenement): ?>
                            <?php
                            // Récupère le type d’événement
                            $type = $crud->selectId('typeEvenement', $evenement['idTypeEvenement'], 'idTypeEvenement');
                            $typeNom = $type ? $type['typeEvenement'] : 'Type inconnu';
                            // Modifie le nom de l'évémement en enlevant les espaces et les majuscules pour l'utiliser en css
                            $typeClass = strtolower(str_replace(' ', '', $typeNom));
                            ?>
                            <div class="dreamplante__evenement <?= ($typeClass); ?>">
                                <div class="dreamplante__evenement_contenu">
                                    <p><strong><?= ($typeNom); ?></strong></p>
                                    <p><?= ($evenement['date']); ?></p>
                                    <p><?= ($evenement['commentaire']); ?></p>
                                </div>
                                <div class="dreamplante__evenement_bouton">
                                    <!-- Modifier l’événement -->
                                    <a href="classes/evenements/evenements-edit.php?id=<?= $evenement['idEvenement']; ?>" class="bouton__modifier_petit">
                                    <img src="assets/img/edit.png" alt="Modifier" class="bouton__modifier-icon">
                                    </a>
                                    <!-- Supprimer l’événement -->
                                    <a href="classes/evenements/evenements-delete.php?id=<?= $evenement['idEvenement']; ?>" class="bouton__retirer">-</a>
                                </div>              
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Aucun événement trouvé -->
                    <div class="dreamplante__aucune">
                        <p>Aucun événement pour cette plante</p>
                    </div>
            <?php endif; ?>

            <?php elseif (empty($plantes)): ?>
                <!-- Aucune plante = aucun événement possible -->
                <div class="dreamplante__aucune">
                    <p>Ajouter une plante pour créer des événements</p>
                </div>
            <?php else: ?>
                <!-- Aucune plante sélectionnée -->
                <div class="dreamplante__aucune">
                    <p>Sélectionnez une plante pour voir ses événements</p>
                </div>
            <?php endif; ?>
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
