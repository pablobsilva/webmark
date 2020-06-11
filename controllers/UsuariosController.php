<?php

require_once 'Controller.php';

class UsuariosController extends Controller 

{

    public function __construct()
    {
        $this->middleware('login');
    }

    public function navegar()
    {
        return $this->view->make('usuario.navegar')
        ->render();
    }
}