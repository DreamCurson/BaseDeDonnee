<?php
session_start();

if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../../index.php');
    exit;
}

if (!isset($_SESSION['planteSelectionnee'])) {
    header('Location: ../../dreamplante.php');
    exit;
}

require_once('../CRUD.php');
$crud = new CRUD;

$idPlante = $_SESSION['planteSelectionnee'];

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DreamPlante | Ajouter une note</title>
        <link rel="stylesheet" href="../../assets/css/style.css">
    </head>
    
    <body class="formulaire__background">

        <div class="formulaireUtilisateur">
            <h1 class="formulaireUtilisateur__title">Ajouter une note</h1>
            <form class="formulaireUtilisateur__form" action="notes-store.php" method="post">
                <input type="hidden" name="idPlante" value="<?= $idPlante; ?>">

                <label class="formulaireUtilisateur__label">
                    Titre de la note
                    <input 
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
                        placeholder="Ajoutez ici vos observations..."
                        required
                    ></textarea>
                </label>

                <button type="submit" class="formulaireUtilisateur__button">Enregistrer</button>
            </form>

            <p class="formulairePlante__texte">
                Annuler la création <a href="../../dreamplante.php" class="formulairePlante__lien">Annuler</a>
            </p>
        </div>

    </body>
</html>
