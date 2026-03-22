<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {

        $data = array_merge($this->data, [
            'title'         => 'Dashboard Page'
        ]);
        return view('pages/commons/dashboard', $data);
    }
}
