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
        print_r($data);
        // Array ( [nomUtilisateur] => test [motDePasse] => 123 )

    }

}

?>