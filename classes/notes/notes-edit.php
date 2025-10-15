<?php
session_start();

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../../index.php');
    exit;
}

require_once('../CRUD.php');
$crud = new CRUD;

if (isset($_GET['id'])) {
    $_SESSION['idNote'] = (int)$_GET['id'];
    header('Location: notes-edit.php');
    exit;
}

if (!isset($_SESSION['idNote'])) {
    header('Location: ../../dreamplante.php');
    exit;
}

$idNote = $_SESSION['idNote'];
$note = $crud->selectId('note', $idNote, 'idNote');

if (!$note) {
    header('Location: ../../dreamplante.php');
    exit;
}

extract($note);

$erreur = $_GET['erreur'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamPlante | Modifier l'événement</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script type="module" src="../../assets/script/main.js"></script>
</head>
<body class="formulaire__background">
    <div class="formulaireUtilisateur">
        <h1 class="formulaireUtilisateur__title">Modifier l'événement</h1>

        <?php if ($erreur === 'modification'): ?>
            <p class="formulaireUtilisateur__erreur">
                Une erreur est survenue lors de la modification.
            </p>
        <?php endif; ?>

        <form class="formulaireUtilisateur__form" action="notes-update.php" method="post">
            <input type="hidden" name="idPlante" value="<?= $idPlante; ?>">
            <input type="hidden" name="idNote" value="<?= $idNote; ?>">


            <label class="formulaireUtilisateur__label">
                Titre de la note
                <input 
                    value="<?= $note['titre'] ?>"
                    type="text" 
                    name="titre" 
                    class="formulaireUtilisateur__input" 
                    placeholder="Exemple : Entretien d'automne"
                    required
                >
            </label>

            <label class="formulaireUtilisateur__label">
                Contenu
                <textarea 
                    name="contenu" 
                    class="formulaireUtilisateur__input" 
                    rows="5" 
                    required
                ><?= ($note['contenu']) ?></textarea>
            </label>


            <button type="submit" class="formulaireUtilisateur__button">Enregistrer</button>
        </form>

        <div class="formulaireUtilisateur__bouton">
            <button type="button" class="formulaireUtilisateur__delete">Supprimer la note</button>
            <a href="notes-delete.php?id=<?= ($idNote); ?>" class="formulaireUtilisateur__confirmation">Vous êtes sûr ?</a>
        </div>
    </div>
</body>
</html>
