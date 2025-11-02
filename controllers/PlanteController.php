<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Plante;
use App\Providers\Validator;

class PlanteController {
    public function select(){
        session_start();
        $idUtilisateur = $_SESSION['idUtilisateur'];

        $plantes = new Plante;
        $plantesUtilisateur = $plantes->selectBy('utilisateur_idUtilisateur', $idUtilisateur);

        $planteSelectionnee = null;
        $idPlante = $_POST['idPlante'] ?? null;

        if ($idPlante) {
            $planteSelectionnee = $plantes->selectId($idPlante);

            // Calculer l'âge de la plante
            if (!empty($planteSelectionnee['dateAcquisition'])) {
                $dateAcquisition = new \DateTime($planteSelectionnee['dateAcquisition']);
                $aujourdhui = new \DateTime();
                $interval = $dateAcquisition->diff($aujourdhui);
                $ageParts = [];

                // Si la plante a au moins 1 an
                if ($interval->y > 0) {
                    $ageParts[] = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');
                }

                // Si la plante a au moins 1 mois
                if ($interval->m > 0) {
                    $ageParts[] = $interval->m . ' mois';
                }

                // Si la plante a moins d’un an mais au moins 1 jour
                if ($interval->d > 0 && $interval->y === 0) {
                    $ageParts[] = $interval->d . ' jour' . ($interval->d > 1 ? 's' : '');
                }

                $planteSelectionnee['ageTexte'] = !empty($ageParts) ? implode(' ', $ageParts) : "moins d’un jour";
            } else {
                $planteSelectionnee['ageTexte'] = "Date inconnue";
            }
        }

        return View::render('base/index', [
            'nomUtilisateur' => $_SESSION['nomUtilisateur'],
            'idUtilisateur' => $idUtilisateur,
            'plantesUtilisateur' => $plantesUtilisateur,
            'idPlante' => $idPlante,
            'planteSelectionnee' => $planteSelectionnee
        ]);
    }


    public function add(){
        return View::render("plante/create");
    }

    public function store($data){
        $plante = new Plante;

        $validator = new Validator;
        $validator->field('nom', $data['nom'])->required()->min(3)->max(50);
        $validator->field('dateAcquisition', $data['dateAcquisition'])->required()->min(8)->max(10);

        if($validator->isSuccess()){
            session_start();
            $data['utilisateur_idUtilisateur'] = $_SESSION['idUtilisateur'];

            $insert = $plante->insert($data);            
            if($insert){
                    return view::redirect('dreamplante');
                }else{
                    return view::render('error');
                }
        }else{
            $errors = $validator->getErrors();
            return view::render('plante/create', ['errors'=>$errors, 'plante' => $data]);
        }

    }

    public function edit($data = []){
        if(isset($data['id']) && $data['id']!=null){
            $plante = new Plante;
            $selectId = $plante->selectId($data['id']);
            if($selectId){
                return View::render("plante/edit", ['plante' => $selectId]);
            }else{
                return View::render('connexion');
            }
        }else{
             return View::render('connexion');
        }
    }

    public function update($data = [], $get = []) {
        if(isset($get['id']) && $get['id'] != null){
            $validator = new Validator;
            
            $validator->field('nom', $data['nom'])->required()->min(3)->max(50);
            $validator->field('dateAcquisition', $data['dateAcquisition'])->required()->min(8)->max(10);

            if($validator->isSuccess()){
                $plante = new Plante;
                $update = $plante->update($data, $get['id']);

                if($update){
                    return View::redirect('dreamplante');
                } else {
                    return View::render('error', ['msg'=>'Modification impossible pour le moment']);
                }
            } else {
                $errors = $validator->getErrors();
                return View::render('plante/edit', ['errors'=>$errors, 'plante'=>$data]);
            }
        }
    }

    public function delete($data){
        $plante = new Plante;
        $delete = $plante->delete($data['id']);
        if($delete){
            return View::redirect('dreamplante');
        }else{
            return View::render('error', ['msg'=>'Could not delete!']);
        }
    }
}
