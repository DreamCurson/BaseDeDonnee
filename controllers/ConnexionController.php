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
        $utilisateur = new \App\Models\Utilisateur;
        // Array ( [nomUtilisateur] => a [email] => a@gmail.com [motDePasse] => a )
        $validator = new Validator;
        $validator
        ->field('nomUtilisateur', $data['nomUtilisateur'])
        ->required()
        ->min(2)
        ->max(50)
        ->unique(function ($value) use ($utilisateur) {
            return $utilisateur->valueExists('nomUtilisateur', $value);
        });

        $validator->field('motDePasse', $data['motDePasse'])->required()->min(3)->max(25);
        $validator->field('email', $data['email'])->max(50)->email();

        if($validator->isSuccess()){
            $utilisateur = new Utilisateur;
            $data['motDePasse'] = $utilisateur->hashPassword($data['motDePasse']);
           $insert = $utilisateur->insert($data);
           if($insert){
                return view::redirect('connexion');
           }else{
                return view::render('error');
           }

        }else{
            $errors = $validator->getErrors();
            // var_dump($errors);
            return view::render('connexion/create', ['errors'=>$errors, 'utilisateur' =>$data]);
        }
    }

    public function validate($data){
        $validator = new Validator;
        $validator
            ->field('nomUtilisateur', $data['nomUtilisateur'])->min(2)->max(50);
        $validator
            ->field('motDePasse', $data['motDePasse'])->min(3)->max(25);

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

    public function edit(){
        

        // return View::redirect('dreamplante');
    }

    public function logout(){
        session_destroy();
        return View::redirect('connexion');
    }

}

?>