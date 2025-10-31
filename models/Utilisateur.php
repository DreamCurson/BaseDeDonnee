<?php
namespace App\Models;
use App\Models\CRUD;

class Utilisateur extends CRUD{
    protected $table = "utilisateur";
    protected $primaryKey = "idUtilisateur";
    // idUtilisateur, nomUtilisateur, email, motDePasse, dateInscription
    protected $fillable = ['nomUtilisateur', 'email', 'motDePasse']; 

    public function hashPassword($motDePasse, $cost= 10){
         $options = [ 
            'cost' => $cost
        ];

        return password_hash($motDePasse, PASSWORD_BCRYPT, $options);
    }
}

?>