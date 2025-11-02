<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Utilisateur;
use App\Providers\Validator;

class ConnexionController{

    public function index(){
        return View::render("connexion/index");
    }

    public function inscription(){
        return View::render("connexion/create");
    }

    public function store($data){
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
                return view::redirect('connexion');
            }else{
                return view::render('error');
            }
        }else{
            $errors = $validator->getErrors();
            return view::render('connexion/create', ['errors'=>$errors, 'utilisateur' =>$data]);
        }

    }

    public function validate($data){
        $validator = new Validator;
        $validator->field('nomUtilisateur', $data['nomUtilisateur'])->min(2)->max(50);
        $validator->field('motDePasse', $data['motDePasse'])->min(3)->max(25);

        if($validator->isSuccess()){
            $utilisateur = new Utilisateur;
            $checkuser = $utilisateur->checkUser($data['nomUtilisateur'], $data['motDePasse']);

            if($checkuser){
                // var_dump($_SESSION);
                return View::redirect('dreamplante');
            }else{
                $errors['message'] = 'Informations de connexion invalide !';
                // var_dump($errors);
                return View::render('connexion/index', ['errors'=>$errors, 'utilisateur'=>$data]);
            }
        }else{
            $errors = $validator->getErrors();
            // var_dump($errors);
            return View::render('connexion/index', ['errors'=>$errors, 'utilisateur'=>$data]);
        }
    }

    public function edit($data = []){
        if(isset($data['id']) && $data['id']!=null){
            $utilisateur = new Utilisateur;
            $selectId = $utilisateur->selectId($data['id']);
            if($selectId){
                return View::render("connexion/edit", ['utilisateur' => $selectId]);
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
                    return View::redirect('dreamplante');
                } else {
                    return View::render('error', ['msg'=>'Modification impossible pour le moment']);
                }
            } else {
                $errors = $validator->getErrors();
                return View::render('connexion/edit', ['errors'=>$errors, 'utilisateur'=>$data]);
            }
        }
    }



    public function delete($data){
        // print_r($data);
        $utilisateur = new Utilisateur;
        $delete = $utilisateur->delete($data['id']);
        if($delete){
            return View::redirect('connexion');
        }else{
            return View::render('error', ['msg'=>'Could not delete!']);
        }
    }

    public function logout(){
        session_start();
        session_destroy();
        return View::redirect('connexion');
    }

}

?>