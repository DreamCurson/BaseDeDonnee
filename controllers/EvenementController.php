<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Plante;
use App\Models\Evenement;
use App\Models\TypeEvenement;
use App\Providers\Validator;

class EvenementController {
    public function __construct() {
        session_start();

        if(!isset($_SESSION['nomUtilisateur'])){
            View::redirect('connexion');
            exit;
        }
    }

    public function add($id) {
        if (is_array($id)) {
            $id = $id['idPlante'] ?? null;
        }

        $typeModel = new TypeEvenement();
        $typesEvenement = $typeModel->select();

        $planteSelectionnee = null;
        if ($id) {
            $planteModel = new Plante();
            $planteSelectionnee = $planteModel->selectId($id);
        }

        return View::render('evenement/create', [
            'typesEvenement' => $typesEvenement,
            'planteSelectionnee' => $planteSelectionnee
        ]);
    }

    public function store($data){
        $validator = new Validator;
        $validator->field('commentaire', $data['commentaire'])->required()->min(3)->max(200);
        $validator->field('idTypeEvenement', $data['idTypeEvenement'], 'typeEvenement')->required()->int();

        if($validator->isSuccess()){
            $evenement = new Evenement;
            $insert = $evenement->insert($data);
            return View::redirect('dreamplante');
        }else{
            $errors = $validator->getErrors();
            $typeEvenements = new TypeEvenement;
            $select = $typeEvenements->select('typeevenement');

            return View::render('evenement/create', ['errors'=>$errors, 'typesEvenement'=>$select, 'evenement'=>$data]);
        }
    }

    public function edit($data = []) {
        if (isset($data['id']) && $data['id'] != null) {
            $evenementModel = new Evenement();
            $evenement = $evenementModel->selectId($data['id']);

            if ($evenement) {
                $typeModel = new TypeEvenement();
                $typesEvenement = $typeModel->select();

                return View::render("evenement/edit", [
                    'evenement' => $evenement,
                    'typesEvenement' => $typesEvenement,
                    'idPlante' => $evenement['idPlante']
                ]);
            } else {
                return View::render('connexion/index');
            }
        } else {
            return View::render('connexion/index');
        }
    }


    public function update($data = [], $get = []) {
        if(isset($get['id']) && $get['id'] != null){
            $validator = new Validator;
            $validator->field('commentaire', $data['commentaire'])->required()->min(3)->max(200);
            $validator->field('idTypeEvenement', $data['idTypeEvenement'], 'Type d\'événement')->required()->int();

            if($validator->isSuccess()){
                $evenement = new Evenement();
                $update = $evenement->update($data, $get['id']);

                if($update){
                    return View::redirect('dreamplante');
                } else {
                    return View::render('error', ['msg'=>'Modification impossible pour le moment']);
                }
            } else {
                $typeModel = new TypeEvenement();
                $typesEvenement = $typeModel->select();

                if(!isset($data['idPlante'])){
                    $evenementModel = new Evenement();
                    $original = $evenementModel->selectId($get['id']);
                    $data['idPlante'] = $original['idPlante'];
                }

                $errors = $validator->getErrors();
                return View::render('evenement/edit', [
                    'errors' => $errors,
                    'evenement' => $data,
                    'typesEvenement' => $typesEvenement
                ]);
            }
        }
    }


    public function delete($data){
        $evenement = new Evenement;
        $delete = $evenement->delete($data['id']);
        if($delete){
            return View::redirect('dreamplante');
        }else{
            return View::render('error', ['msg'=>'Could not delete!']);
        }
    }

}
