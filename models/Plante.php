<?php
namespace App\Models;
use App\Models\CRUD;

class Plante extends CRUD {
    protected $table = "plante";
    protected $primaryKey = "idPlante";
    // idPlante, nom, typePlante, dateAcquisition, utilisateur_idUtilisateur
    protected $fillable = ['nom', 'typePlante', 'dateAcquisition', 'utilisateur_idUtilisateur']; 
}


?>