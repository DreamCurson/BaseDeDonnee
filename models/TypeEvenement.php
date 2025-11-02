<?php
namespace App\Models;
use App\Models\CRUD;

class TypeEvenement extends CRUD {
    protected $table = "typeevenement";
    protected $primaryKey = "idTypeEvenement";
    // // idTypeEvenement, typeEvenement
    protected $fillable = ['typeEvenement']; 
}


?>