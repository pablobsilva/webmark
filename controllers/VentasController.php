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
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();

        return $this->view->make('ventas.vender')
        ->render();
    }

    public function verCuentas()
    {
        return $this->view->make('solicitudes.cuentas')
        ->render();
    }

    public function RealizarVenta()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $fecha = $_SERVER['REQUEST_TIME'];
        $hora = $_SERVER['REQUEST_TIME_FLOAT'];
        $total = $_POST["total"];
        $productos = $_POST["productos"];
        $precio = $_POST["precio"];
        $cantidad = $_POST["cantidad"];

        $insert = $db->prepare(
            "INSERT INTO VentaProductos
            (
                fecha, hora, total
            )
             VALUES
            (
                :fecha, :hora, :total
        )");

        $insert = $insert->execute(array(
                ':fecha' => $fecha,
                ':hora' => $hora,
                ':total' => $total,
        ));


        $productos = $db->prepare(
            "INSERT INTO ProductosVenta
            (
                producto, precio, cantidad
            )
             VALUES
            (
                :producto, :precio, :cantidad
        )");
        

        if($insert)
        {
            return $this->redirect('/');
        }        
    }

    public function VerVentas()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $ventas = $db->prepare('SELECT * FROM VentaProductos');
        $ventas->execute();
        $ventas = $ventas->fetchAll();
        return $this
        ->view
        ->make('ventas.verVentas')
        ->with(array(
            'ventas' => $ventas,
        ))
        ->render();
    }

}