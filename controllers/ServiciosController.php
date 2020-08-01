<?php

require_once 'Controller.php';

class ServiciosController extends Controller 
{

    public function __construct()
    {
        $this->middleware('login');
    }

    public function AgregarServicio()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $servicio = $data->servicio;
        $insert = $db->prepare(
            "INSERT INTO servicios
            (
                DescripcionServicio, ValorNeto, ValorIVA, ValorTotal
            )
            VALUES 
            (
                :descripcion, :ValorNeto, :ValorIVA, :ValorTotal
            )"
        );
        $insert->execute(
            ':descripcion' => $servicio->descripcion,
            ':ValorNeto' => $servicio->ValorNeto,
            ':ValorIva' => $servicio->ValorIVA,
            ':ValorTotal' = $servicio->ValorTotal,
        );
        

    }



}