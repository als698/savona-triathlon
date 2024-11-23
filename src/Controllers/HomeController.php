<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->view('home/index');
    }

    public function success()
    {
        return $this->view('success');
    }
}
