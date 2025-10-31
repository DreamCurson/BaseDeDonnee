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
        print_r($data);
        // Array ( [name] => [username] => [password] => [email] => [privilege_id] => 1 )
    //     $validator = new Validator;
    //     $validator->field('name', $data['name'])->min(2)->max(50);
    //     $validator->field('username', $data['username'])->required()->max(50)->email();
    //     $validator->field('password', $data['password'])->min(6)->max(20);
    //     $validator->field('email', $data['email'])->required()->max(50)->email();
    //     $validator->field('privilege_id', $data['privilege_id'], 'privilege')->required()->int();

    //     if($validator->isSuccess()){
    //         $user = new User;
    //         $data['password'] = $user->hashPassword($data['password']);
    //         // print_r($data);
    //         // die();
    //        $insert = $user->insert($data);
    //        if($insert){
    //             return view::redirect('login');
    //        }else{
    //             return view::render('error');
    //        }

    //     }else{
    //         $errors = $validator->getErrors();
    //         $privilege = new Privilege;
    //         $privileges = $privilege->select('privilege');
    //         return view::render('user/create', ['errors'=>$errors, 'privileges' => $privileges, 'user' =>$data]);
    //     }
    }

    public function validate($data){
        // print_r($data);
        // Array ( [nomUtilisateur] => test [motDePasse] => 123 )

    }

}

?>