<?php
namespace App\Models;

use App\Models\CRUD;

class Icon extends CRUD {

    protected $table = "icons";
    protected $primaryKey = "idIcon";
    protected $fillable = ['iconData'];

    public $iconData;

    public function store() {
        if (isset($_FILES['fileToUpload'])) {
            $fileContent = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
            
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "C'est un image - " . $check["mime"] . ".";
            } else {
                echo "Ceci n'est pas un image.";
                return;
            }

            $this->iconData = $fileContent;

            $data = [
                'iconData' => $this->iconData
            ];

            $insertId = $this->insert($data);

            if ($insertId) {
                echo "Réussite avec ID: " . $insertId;
            }
        } else {
            echo "Erreur.";
        }
    }
}
?>
