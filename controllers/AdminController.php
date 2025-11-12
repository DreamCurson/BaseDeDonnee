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

}
