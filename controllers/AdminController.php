<?php
namespace App\Controllers;

use App\Providers\View;

class AdminController {
    public function connexion(){
        return View::render("connexion/index-admin");
    }
}
