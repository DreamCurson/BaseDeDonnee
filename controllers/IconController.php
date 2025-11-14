<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Icon;

class IconController {

    public function __construct() {
        session_start();

        if(!isset($_SESSION['nomUtilisateur'])){
            View::redirect('connexion');
            exit;
        }
    }

    public function store() {
        if (isset($_FILES['fileToUpload'])) {
            $fileContent = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);

            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                // echo "C'est un image - " . $check["mime"] . ".";
            } else {
                // echo "C'est pas un image.";
                return;
            }

            $icon = new Icon();

            $icon->iconData = $fileContent;

            $icon->store();
        } else {
            echo "Erreur.";
        }
    }
}
?>
