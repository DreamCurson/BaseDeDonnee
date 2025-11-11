<?php
namespace App\Models;
use App\Models\CRUD;

class Admin extends CRUD{
    protected $table = "admin";
    protected $primaryKey = "idAdmin";
    // idAdmin, nomUtilisateur, motDePasse
    // protected $fillable = ['nomUtilisateur', 'motDePasse']; 

    public function checkAdmin($nomUtilisateur, $motDePasse){
        $sql = "SELECT * FROM $this->table WHERE nomUtilisateur = :nomUtilisateur";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':nomUtilisateur', $nomUtilisateur);
        $stmt->execute();
        $utilisateur = $stmt->fetch();

        // l'adresse IP, la date
        if($utilisateur && password_verify($motDePasse, $utilisateur['motDePasse'])){
            session_start();
            $_SESSION['idUtilisateurAdmin'] = $utilisateur['idUtilisateur'];
            $_SESSION['nomUtilisateurAdmin'] = $utilisateur['nomUtilisateur'];
            $_SESSION['fingerPrintAdmin'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
            return true;
        }else{
            return false;
        }
    }
}

?>