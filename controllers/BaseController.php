<?php
namespace App\Controllers;
use App\Providers\View;
use App\Models\Plante;
use App\Models\Evenement;
use App\Models\TypeEvenement;
use App\Models\Note;

class BaseController {
    public function __construct() {
        session_start();

        if(!isset($_SESSION['nomUtilisateur'])){
            View::redirect('connexion');
            exit;
        }
    }

    public function index() {
        $nomUtilisateur = $_SESSION['nomUtilisateur'];
        $idUtilisateur = $_SESSION['idUtilisateur'];

        // Fetch all plants for the user
        $plantes = new Plante;
        $plantesUtilisateur = $plantes->selectBy('utilisateur_idUtilisateur', $idUtilisateur);

        // Check if there's a selected plant (from session or from request)
        $planteSelectionnee = $_SESSION['planteSelectionnee'] ?? null;

        // Initialize empty arrays for events and notes
        $evenements = [];
        $notes = [];

        // If a plant is selected (from session or passed via POST), load its details
        if ($planteSelectionnee) {
            $idPlante = $planteSelectionnee['idPlante'];

            // Get events for the selected plant
            $evenementModel = new Evenement();
            $evenements = $evenementModel->selectBy('idPlante', $idPlante);

            // Get event types and add them to the events
            $typeModel = new TypeEvenement();
            foreach ($evenements as &$evenement) {
                $type = $typeModel->selectId($evenement['idTypeEvenement']);
                $evenement['typeNom'] = $type['typeEvenement'] ?? 'Type inconnu';
                $evenement['typeClass'] = strtolower(str_replace(' ', '', $evenement['typeNom']));
            }

            // Get notes for the selected plant
            $noteModel = new Note();
            $notes = $noteModel->selectBy('idPlante', $idPlante);

            // Calculate plant age (like in the select method)
            if (!empty($planteSelectionnee['dateAcquisition'])) {
                $dateAcquisition = new \DateTime($planteSelectionnee['dateAcquisition']);
                $aujourdhui = new \DateTime();
                $interval = $dateAcquisition->diff($aujourdhui);
                $ageParts = [];

                if ($interval->y > 0) {
                    $ageParts[] = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');
                }
                if ($interval->m > 0) {
                    $ageParts[] = $interval->m . ' mois';
                }
                if ($interval->d > 0 && $interval->y === 0) {
                    $ageParts[] = $interval->d . ' jour' . ($interval->d > 1 ? 's' : '');
                }

                $planteSelectionnee['ageTexte'] = !empty($ageParts) ? implode(' ', $ageParts) : "moins d’un jour";
            } else {
                $planteSelectionnee['ageTexte'] = "Date inconnue";
            }
        }

        return View::render('base/index', [
            'planteSelectionnee' => $planteSelectionnee,
            'nomUtilisateur' => $nomUtilisateur,
            'idUtilisateur' => $idUtilisateur,
            'plantesUtilisateur' => $plantesUtilisateur,
            'evenements' => $evenements,
            'notes' => $notes
        ]);
    }


    public function select() {
        $idUtilisateur = $_SESSION['idUtilisateur'];
        $nomUtilisateur = $_SESSION['nomUtilisateur'];

        $planteModel = new Plante();
        $plantesUtilisateur = $planteModel->selectBy('utilisateur_idUtilisateur', $idUtilisateur);

        $idPlante = $_POST['idPlante'] ?? null;
        $planteSelectionnee = null;
        $evenements = [];
        $notes = [];

        if ($idPlante) {
            $planteSelectionnee = $planteModel->selectId($idPlante);
            $_SESSION['planteSelectionnee'] = $planteSelectionnee; 

            if (!empty($planteSelectionnee['dateAcquisition'])) {
                $dateAcquisition = new \DateTime($planteSelectionnee['dateAcquisition']);
                $aujourdhui = new \DateTime();
                $interval = $dateAcquisition->diff($aujourdhui);
                $ageParts = [];

                if ($interval->y > 0) {
                    $ageParts[] = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');
                }
                if ($interval->m > 0) {
                    $ageParts[] = $interval->m . ' mois';
                }
                if ($interval->d > 0 && $interval->y === 0) {
                    $ageParts[] = $interval->d . ' jour' . ($interval->d > 1 ? 's' : '');
                }

                $planteSelectionnee['ageTexte'] = !empty($ageParts) ? implode(' ', $ageParts) : "moins d’un jour";
            } else {
                $planteSelectionnee['ageTexte'] = "Date inconnue";
            }

            $evenementModel = new Evenement();
            $evenements = $evenementModel->selectBy('idPlante', $idPlante);

            $typeModel = new TypeEvenement();
            foreach ($evenements as &$evenement) {
                $type = $typeModel->selectId($evenement['idTypeEvenement']);
                $evenement['typeNom'] = $type['typeEvenement'] ?? 'Type inconnu';
                $evenement['typeClass'] = strtolower(str_replace(' ', '', $evenement['typeNom']));
            }

            $noteModel = new Note();
            $notes = $noteModel->selectBy('idPlante', $idPlante);
        }

        return View::render('base/index', [
            'nomUtilisateur' => $nomUtilisateur,
            'idUtilisateur' => $idUtilisateur,
            'plantesUtilisateur' => $plantesUtilisateur,
            'idPlante' => $idPlante,
            'planteSelectionnee' => $planteSelectionnee,
            'evenements' => $evenements,
            'notes' => $notes
        ]);
    }
}

