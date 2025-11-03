<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Plante;
use App\Models\Note;

use App\Providers\Validator;

class NoteController {
    public function add($id) {
        return View::render('note/create', [
            'idPlante' => $id['idPlante']
        ]);
    }

    public function store($data){
        $validator = new Validator;
        $validator->field('titre', $data['titre'])->required()->min(3)->max(200);

        if($validator->isSuccess()){
            $note = new Note;
            $insert = $note->insert($data);
            return View::redirect('dreamplante');
        }else{
            $errors = $validator->getErrors();

            return View::render('note/create', ['errors'=>$errors, 'note'=>$data, 'idPlante' => $data['idPlante']]);
        }
    }

    public function edit($data = []) {
        if (isset($data['id']) && $data['id'] != null) {
            $note = new Note;
            $selectId = $note->selectId($data['id']);
            
            $plante = new Plante;
            $planteId = $plante->selectId($selectId['idPlante']);
            
            if ($selectId) {
                return View::render("note/edit", ['note' => $selectId, 'plante' => $planteId]);
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
            $validator->field('titre', $data['titre'])->required()->min(3)->max(200);
        
            if($validator->isSuccess()){
                $note = new Note;
                $update = $note->update($data, $get['id']);

                if($update){
                    return View::redirect('dreamplante');
                } else {
                    return View::render('error', ['msg'=>'Modification impossible pour le moment']);
                }
            } else {
                $errors = $validator->getErrors();
                return View::render('note/edit', ['errors'=>$errors, 'note'=>$data]);
            }
        }
    }

    public function delete($data){
        $note = new Note;
        $delete = $note->delete($data['id']);
        if($delete){
            return View::redirect('dreamplante');
        }else{
            return View::render('error', ['msg'=>'Could not delete!']);
        }
    }
}
