<?php
namespace App\Controllers;
use App\Providers\View;

class BaseController {
    public function index() {
        return View::render('base/index');
    }
}
