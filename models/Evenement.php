<?php
namespace App\Models;
use App\Models\CRUD;

class Evenement extends CRUD {
    protected $table = "evenement";
    protected $primaryKey = "idEvenement";
    // idEvenement, commentaire, idPlante, idTypeEvenement, date
    protected $fillable = ['commentaire', 'date', 'idTypeEvenement', 'idPlante']; 
}


?>