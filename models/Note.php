<?php
namespace App\Models;
use App\Models\CRUD;

class Note extends CRUD {
    protected $table = "note";
    protected $primaryKey = "idNote";
    // idNote, titre, contenu, idPlante
    protected $fillable = ['titre', 'contenu', 'idPlante']; 
}


?>