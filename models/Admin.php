<?php
namespace App\Models;
use App\Models\CRUD;

class Admin extends CRUD{
    protected $table = "admin";
    protected $primaryKey = "idAdmin";
    // idAdmin, nomUtilisateur, motDePasse
    protected $fillable = ['nomUtilisateur', 'motDePasse']; 

    public function checkAdmin($nomUtilisateur, $motDePasse){
        $sql = "SELECT * FROM $this->table WHERE nomUtilisateur = :nomUtilisateur";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':nomUtilisateur', $nomUtilisateur);
        $stmt->execute();
        $admin = $stmt->fetch();

        // l'adresse IP, la date
        if($admin && password_verify($motDePasse, $admin['motDePasse'])){
            session_start();
            $_SESSION['idUtilisateurAdmin'] = $admin['idAdmin'];
            $_SESSION['nomUtilisateurAdmin'] = $admin['nomUtilisateur'];
            $_SESSION['fingerPrintAdmin'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
            return true;
        }else{
            return false;
        }
    }
}

?>