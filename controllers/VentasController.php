<?php

require_once 'Controller.php';

class VentasController extends Controller
{
    public function __construct()
    {
       // $this->middleware('login');
    }

    public function solicitar()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();

        return $this->view->make('ventas.vender')
        ->render();
    }

    public function VerVentas()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $request = $this->request;
        $date = $request->date;
        if($date != "")
        {
            $ventas = $db->prepare("SELECT * FROM ventas WHERE fecha = :fecha");
            $ventas->execute(array(
                ':fecha' => $date
            ));
            $ventas = $ventas->fetchAll();
            return $this
            ->view
            ->make('ventas.verVentas')
            ->with(array(
                'ventas' => $ventas,
            ))
            ->render();
        }else
        {
            $ventas = $db->prepare("SELECT * FROM ventas");
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
        return $this->view->make('solicitudes.cuentas')
        ->render();
    }

    public function AgregarProductoVenta()
    {


    }

    public function RealizarVenta()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        date_default_timezone_set('America/Santiago');
        $date = date('Y-m-d', time());
        $hora = date('H:i:s', time());
        $personal_rut = $_SESSION['auth']['rut'];
        //$idproductos = $_POST["productos[]"];
        //$cantidades = $_POST["cantidades[]"];
        $cantidades = array("2","2","3","3");
        $idproductos = array("1","2","3","4");
        $longitud = count($idproductos);
        $productos = array();

        for ($i=0; $i < $longitud ; $i++) { 
            $selecproducto = $db->prepare(
                "SELECT * FROM productos WHERE idProducto = :idproducto"
            );
            $selecproducto->execute(array(
                ':idproducto' => $idproductos[$i],
            ));
            $selecproducto = $selecproducto->fetchAll();
            foreach($selecproducto as $productoselec){
                $producto = new StdClass();
                $producto->id = $productoselec->idProducto;
                $producto->nombre = $productoselec->nombre;
                $producto->precio = $productoselec->precio;
                $producto->cantidad = $cantidades[$i];
                $productos[] = $producto;
                $update = $db->prepare(
                    "UPDATE productos 
                    SET stock = stock - :cantidad
                    WHERE idProducto = :idproducto"
                );
                $update->execute(array(
                    ':idproducto' => $producto->id,
                    ':cantidad' => $cantidades[$i],
                ));
            }
        }
        $idventa = $db->prepare(
            "SELECT MAX(idVenta) AS idVenta FROM ventas"
        );
        $idventa->execute();
        $idventa = $idventa->fetch();
        $idventa=$idventa->idVenta+1;

        $insert = $db->prepare(
            "INSERT INTO detalles_venta
            (
                idventa, idproducto, cantidad, precio
            )
             VALUES
            (
                :idventa, :idproducto, :cantidad, :precio
            )"
        );

        foreach($productos as $producto) { 

            $precio = $producto->precio;
            $cantidad = $producto->cantidad;
            $total = $precio*$cantidad;
            $totalfinal = $totalfinal + $total;
            $insert->execute(array(
                ':idventa' => $idventa,
                ':idproducto' => $producto->id,
                ':cantidad' => $producto->cantidad,
                ':precio' => $total,
            ));
        }

        $insert = $db->prepare(
            "INSERT INTO ventas
            (
                fecha, hora, total, personal_rut
            )
             VALUES
            (
                :fecha, :hora, :total, :personal_rut
        )");

        $insert = $insert->execute(array(
            ':fecha' => $date,
            ':hora' => $hora,
            ':total' => $totalfinal,
            ':personal_rut' => $personal_rut,
        ));

        if($insert)
        {
            return $this->redirect('/');
        }        
    }

    public function VerCuentaDiaria()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        date_default_timezone_set('America/Santiago');
        $actual = date('Y-m-d', time());
        //$request = $this->request;
        $dia = $db->prepare("SELECT * FROM ventas WHERE fecha = :fecha");
        $dia->execute(array(
            ':fecha' => $actual
        ));
        $dia = $dia->fetchAll();
        return $this->view->make('ventas.cuentadiaria')->with(array(
            'cuenta' => $dia,
        ))
        ->render();
    }
}