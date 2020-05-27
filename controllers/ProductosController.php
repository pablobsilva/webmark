<?php

require_once 'Controller.php';
class ProductosController extends Controller 
{

    public function solicitar()
    {
        return $this->view->make('solicitudes.productos')
        ->render();
    }



}