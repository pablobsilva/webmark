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
        $now = new DateTime();
        date_default_timezone_set('America/Santiago');
        $date = date('Y-m-d H:i:s', time());
        $personal_rut = $_SESSION['auth']['rut'];
        //$idproductos = $_POST["productos[]"];
        //$cantidades = $_POST["cantidades[]"];
        $cantidades = array("2","2","3","3");
        $idproductos = array("1","2","3","4");
        $longitud = count($idproductos);
        $productos = array();

        for ($i=0; $i < $longitud ; $i++) { 
            $selecproductos = $db->prepare(
                "SELECT * FROM productos WHERE idProducto = :idproducto"
            );
            $selecproductos->execute(array(
                ':idproducto' => $idproductos[$i],
            ));
            $selecproductos = $selecproductos->fetchAll();
            foreach($selecproductos as $productoselec){
                $producto = new StdClass();
                $producto->id = $productoselec->idProducto;
                $producto->nombre = $productoselec->nombre;
                $producto->precio = $productoselec->precio;
                $producto->cantidad = $cantidades[$i];
                $productos[] = $producto;
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
            /*print $total; 
            print $producto->cantidad;
            print $producto->id;
            print $idventa;*/
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
                fechayhora, total, personal_rut
            )
             VALUES
            (
                :fechayhora, :total, :personal_rut
        )");

        $insert = $insert->execute(array(
                ':fechayhora' => $date,
                ':total' => $totalfinal,
                ':personal_rut' => $personal_rut,
        ));

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