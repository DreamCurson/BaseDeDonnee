<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Admin;
use App\Providers\Validator;
use App\Models\Plante;
use App\Models\Utilisateur;
use App\Models\Note;
use App\Models\Evenement;
use App\Models\TypeEvenement;
use App\Models\Icon;

class AdminController {
    public function connexion(){
        return View::render("connexion/index-admin");
    }

    public function validate($data){
        $validator = new Validator;
        $validator->field('nomUtilisateur', $data['nomUtilisateur'])->min(2)->max(50);
        $validator->field('motDePasse', $data['motDePasse'])->min(3)->max(25);

        if($validator->isSuccess()){
            $admin = new Admin;
            $checkuser = $admin->checkAdmin($data['nomUtilisateur'], $data['motDePasse']);

            if($checkuser){
                var_dump($_SESSION);
                return View::redirect('admin');
            }else{
                $errors['message'] = 'Informations de connexion invalide !';
                return View::render('connexion/index-admin', ['errors'=>$errors, 'admin'=>$data]);
            }
        }else{
            $errors['message'] = 'Informations de connexion invalide !';
            // var_dump($errors);
            return View::render('connexion/index-admin', ['errors'=>$errors, 'admin'=>$data]);
        }
    }

    public function index() {
        session_start();

        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        $planteModel = new Plante();
        $utilisateurModel = new Utilisateur();
        $iconModel = new Icon();

        $plantes = $planteModel->select();
        $utilisateurs = $utilisateurModel->select();
        $icons = $iconModel->select();

        foreach ($plantes as &$plante) {
            $idUtilisateur = $plante['utilisateur_idUtilisateur'];
            $utilisateur = $utilisateurModel->selectId($idUtilisateur);
            $plante['utilisateur_nomUtilisateur'] = $utilisateur ? $utilisateur['nomUtilisateur'] : 'Utilisateur inconnu';
        }

        // Convert icon BLOBs to base64
        foreach ($icons as &$icon) {
            $icon['iconBase64'] = base64_encode($icon['iconData']);
        }

        return View::render('admin/index', [
            'plantes' => $plantes,
            'utilisateurs' => $utilisateurs,
            'icons' => $icons
        ]);
    }



    // --------- UTILISATEUR ---------
    public function addUser(){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }
        
        return View::render("admin/create-user");
    }

    public function saveUser($data){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        $utilisateur = new Utilisateur;

        $validator = new Validator;
        $validator->field('nomUtilisateur', $data['nomUtilisateur'])->required()->min(2)->max(50)->unique(function($value) use ($utilisateur) {
            return $utilisateur->valueExists('nomUtilisateur', $value);
        });
        $validator->field('motDePasse', $data['motDePasse'])->required()->min(3)->max(25);
        $validator->field('email', $data['email'])->max(50)->email();

        if($validator->isSuccess()){
            $data['motDePasse'] = $utilisateur->hashPassword($data['motDePasse']);
            $insert = $utilisateur->insert($data);
            if($insert){
                return view::redirect('admin');
            }else{
                return view::render('error');
            }
        }else{
            $errors = $validator->getErrors();
            return view::render('admin/create-user', ['errors'=>$errors, 'utilisateur' =>$data]);
        }
    }

    public function editUser($data){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        if(isset($data['id']) && $data['id']!=null){
            $utilisateur = new Utilisateur;
            $selectId = $utilisateur->selectId($data['id']);
            if($selectId){
                return View::render("admin/edit-user", ['utilisateur' => $selectId]);
            }else{
                return View::render('connexion');
            }
        }
    }

    public function updateUser($data = [], $get = []) {
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        if(isset($get['id']) && $get['id'] != null){
            $validator = new Validator;
            $utilisateur = new Utilisateur;

            $validator->field('nomUtilisateur', $data['nomUtilisateur'])->required()->min(2)->max(45)
                ->unique(function($value) use ($data) {
                    session_start();
                    $utilisateur = new Utilisateur;
                    return $utilisateur->valueExists('nomUtilisateur', $value) && $value !== $_SESSION['nomUtilisateur'];
                });
            $validator->field('email', $data['email'])->email()->max(45);
            if(!empty($data['motDePasse'])) {
                $validator->field('motDePasse', $data['motDePasse'])->min(4)->max(25);
            }

            if($validator->isSuccess()){
                $utilisateur = new Utilisateur;

                if(empty($data['motDePasse'])) {
                    unset($data['motDePasse']);
                } else {
                    $data['motDePasse'] = $utilisateur->hashPassword($data['motDePasse']);
                }

                $update = $utilisateur->update($data, $get['id']);
                if($update){
                    if(isset($data['nomUtilisateur'])){
                        session_start();
                        $_SESSION['nomUtilisateur'] = $data['nomUtilisateur'];
                    }
                    return View::redirect('admin');
                } else {
                    return View::render('error', ['msg'=>'Modification impossible pour le moment']);
                }
            } else {
                $errors = $validator->getErrors();
                return View::render('admin/edit-user', ['errors'=>$errors, 'utilisateur'=>$data]);
            }
        }
    }

        public function deleteUser($data){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }
        
        $utilisateur = new Utilisateur;
        $delete = $utilisateur->delete($data['id']);

        if($delete){
            return View::redirect('admin');
        }else{
            return View::render('error', ['msg'=>'Could not delete!']);
        }
    }

    // --------- PLANTE ---------
    public function deletePlante($data){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }
        
        $plante = new Plante;
        $delete = $plante->delete($data['id']);

        if($delete){
            return View::redirect('admin');
        }else{
            return View::render('error', ['msg'=>'Could not delete!']);
        }
    }

    public function addPlante() {
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        $utilisateurModel = new Utilisateur();
        $utilisateurs = $utilisateurModel->select();

        return View::render("admin/create-plante", [
            'utilisateurs' => $utilisateurs
        ]);
    }


    public function savePlante($data){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        $plante = new Plante();

        $validator = new Validator();
        $validator->field('nom', $data['nom'])->required()->min(3)->max(50);
        $validator->field('dateAcquisition', $data['dateAcquisition'])->required()->min(8)->max(10);

        $validator->field('utilisateur_idUtilisateur', $data['utilisateur_idUtilisateur'])->required();

        if ($validator->isSuccess()) {
            $insert = $plante->insert($data);

            if ($insert) {
                return View::redirect('admin');
            } else {
                return View::render('error');
            }

        } else {
            $utilisateurModel = new Utilisateur();
            $utilisateurs = $utilisateurModel->select();

            $errors = $validator->getErrors();

            return View::render('admin/create-plante', [
                'errors' => $errors,
                'plante' => $data,
                'utilisateurs' => $utilisateurs
            ]);
        }
    }

    public function planteInfo($data) {
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        if (isset($data['id']) && $data['id'] != null) {
            $planteModel = new Plante();
            $selectId = $planteModel->selectId($data['id']);
            
            if ($selectId) {
                $utilisateurModel = new Utilisateur();
                $utilisateur = $utilisateurModel->selectId($selectId['utilisateur_idUtilisateur']);
                $selectId['nomUtilisateur'] = $utilisateur['nomUtilisateur'];

                $evenementModel = new Evenement();
                $evenements = $evenementModel->selectBy('idPlante', $data['id']);

                $typeEvenementModel = new TypeEvenement();
                foreach ($evenements as &$evenement) {
                    $type = $typeEvenementModel->selectId($evenement['idTypeEvenement']);
                    $evenement['typeEvenement'] = $type['typeEvenement'];
                }

                $noteModel = new Note();
                $notes = $noteModel->selectBy('idPlante', $data['id']);

                return View::render("admin/plante-index", [
                    'plante' => $selectId,
                    'evenements' => $evenements,
                    'notes' => $notes
                ]);
            } else {
                return View::render('connexion');
            }
        }
    }

    public function editPlante($data){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        if(isset($data['id']) && $data['id']!=null){
            $plante = new Plante;
            $selectId = $plante->selectId($data['id']);

            $utilisateurModel = new Utilisateur();
            $utilisateurs = $utilisateurModel->select();
            if($selectId){
                return View::render("admin/edit-plante", ['plante' => $selectId, 'utilisateurs' => $utilisateurs]);
            }else{
                return View::render('connexion/index');
            }
        }else{
             return View::render('connexion/index');
        }
    }

    public function updatePlante($data = [], $get = []) {
        if(isset($get['id']) && $get['id'] != null){
            $validator = new Validator;
            
            $validator->field('nom', $data['nom'])->required()->min(3)->max(50);
            $validator->field('dateAcquisition', $data['dateAcquisition'])->required()->min(8)->max(10);

            if($validator->isSuccess()){
                $plante = new Plante;
                $update = $plante->update($data, $get['id']);

                if($update){
                    return View::redirect('admin-planteInfo?id=' . $get['id']);
                } else {
                    return View::render('error', ['msg'=>'Modification impossible pour le moment']);
                }
            } else {
                $utilisateurModel = new Utilisateur();
                $utilisateurs = $utilisateurModel->select();
                $errors = $validator->getErrors();
                return View::render('admin/edit-plante', ['errors'=>$errors, 'plante'=>$data, 'utilisateurs'=>$utilisateurs]);
            }
        }
    }

    // --------- Événements ---------
    public function addEvenement($data){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        $idPlante = null;
        if (isset($data['id']) && !empty($data['id'])) {
            $idPlante = $data['id'];
        }

        $typeModel = new TypeEvenement();
        $typesEvenement = $typeModel->select();

        $planteSelectionnee = null;
        if ($idPlante) {
            $planteModel = new Plante();
            $planteSelectionnee = $planteModel->selectId($idPlante);

            if (!$planteSelectionnee) {
                return View::render('error', ['msg' => 'Plante non trouvée']);
            }
        } else {
            return View::render('error', ['msg' => 'Aucun idPlante fourni']);
        }

        return View::render('admin/create-event', [
            'typesEvenement' => $typesEvenement,
            'planteSelectionnee' => $planteSelectionnee
        ]);
    }


    public function saveEvenement($data){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        $validator = new Validator;
        $validator->field('commentaire', $data['commentaire'])->required()->min(3)->max(200);
        $validator->field('idTypeEvenement', $data['idTypeEvenement'], 'typeEvenement')->required()->int();

        if($validator->isSuccess()){
            $evenement = new Evenement;
            $insert = $evenement->insert($data);
            return View::redirect('admin-planteInfo?id=' . $data['idPlante']);
        }else{
            $errors = $validator->getErrors();
            $typeEvenements = new TypeEvenement;
            $select = $typeEvenements->select('typeevenement');

            return View::render('admin/create-event', ['errors'=>$errors, 'typesEvenement'=>$select, 'evenement'=>$data]);
        }
    }

    // --------- Notes ---------
    public function addNote($id){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        return View::render('admin/create-note', [
            'idPlante' => $id['id']
        ]);
    }

    public function saveNote($data){
        $validator = new Validator;
        $validator->field('titre', $data['titre'])->required()->min(3)->max(200);

        if($validator->isSuccess()){
            $note = new Note;
            $insert = $note->insert($data);
            return View::redirect('admin-planteInfo?id=' . $data['idPlante']);
        }else{
            $errors = $validator->getErrors();

            return View::render('admin/create-note', ['errors'=>$errors, 'note'=>$data, 'idPlante' => $data['idPlante']]);
        }
    }

    // ------------ Icon ------------ 
    public function deleteIcon($data){
        session_start();
        if (!isset($_SESSION['nomUtilisateurAdmin'])) {
            View::redirect('connexion');
            exit;
        }

        if (isset($data['idIcon'])) {
            $iconModel = new Icon();
            $deleteSuccess = $iconModel->delete($data['idIcon']);

            if ($deleteSuccess) {
                View::redirect('admin');
            } else {
                View::render('error', ['error' => 'Impossible à supprimer.']);
            }
        } else {
            View::render('error', ['error' => 'Icon ID introuvable.']);
        }
    }
}
