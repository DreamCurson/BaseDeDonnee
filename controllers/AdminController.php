<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Admin;
use App\Providers\Validator;
use App\Models\Plante;
use App\Models\Utilisateur;

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

        $plantes = $planteModel->select();
        $utilisateurs = $utilisateurModel->select();

        foreach ($plantes as &$plante) {
            $idUtilisateur = $plante['utilisateur_idUtilisateur'];

            $utilisateur = $utilisateurModel->selectId($idUtilisateur);

            if ($utilisateur) {
                $plante['utilisateur_nomUtilisateur'] = $utilisateur['nomUtilisateur'];
            } else {
                $plante['utilisateur_nomUtilisateur'] = 'Utilisateur inconnu';
            }
        }

        return View::render('admin/index', [
            'plantes' => $plantes,
            'utilisateurs' => $utilisateurs
        ]);
    }

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

}
