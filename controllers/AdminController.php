<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Admin;
use App\Providers\Validator;

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

    public function index(){
        echo "allo";
    }
}
