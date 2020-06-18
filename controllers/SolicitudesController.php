<?php

require_once 'Controller.php';

class SolicitudesController extends Controller 

{

    public function __construct()
    {
        $this->middleware('login');
    }

    public function gestionar()
    {
        return $this->view->make('solicitudes.gestionar')
        ->render();
    }

    
}