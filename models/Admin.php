<?php
namespace App\Models;
use App\Models\CRUD;

class Admin extends CRUD{
    protected $table = "admin";
    protected $primaryKey = "idAdmin";
    // idAdmin, nomUtilisateur, motDePasse
    // protected $fillable = ['nomUtilisateur', 'motDePasse']; 
}

?>