<?php

require_once 'Controller.php';

class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function solicitar()
    {
        return $this->view->make('solicitudes.venta')
        ->render();
    }

    public function verCuentas()
    {
        return $this->view->make('solicitudes.cuentas')
        ->render();
    }
    
}