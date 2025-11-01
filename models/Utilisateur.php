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
    
    public function checkUser($nomUtilisateur, $motDePasse){
        $sql = "SELECT * FROM $this->table WHERE nomUtilisateur = :nomUtilisateur";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':nomUtilisateur', $nomUtilisateur);
        $stmt->execute();
        $utilisateur = $stmt->fetch();

        if($utilisateur && password_verify($motDePasse, $utilisateur['motDePasse'])){
            session_regenerate_id();
            session_start();
            $_SESSION['idUtilisateur'] = $utilisateur['idUtilisateur'];
            $_SESSION['nomUtilisateur'] = $utilisateur['nomUtilisateur'];
            $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
            return true;
        }else{
            return false;
        }
    }

}

?>