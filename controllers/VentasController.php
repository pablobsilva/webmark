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

    public function VerVentas()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->fecha))
        {
            $ventas = $db->prepare("SELECT * FROM ventas WHERE fecha = :fecha AND rut_empresa = :rut_empresa");
            $ventas->execute(array(
                ':fecha' => $data->fecha,
                ':rut_empresa' => $data->rut_empresa
            ));
            $ventas = $ventas->fetchAll();
            if($ventas)
            {
                echo json_encode(array(
                    'resultado' => true,
                    'ventas' => $ventas
                ));
            }
            else
            {
                echo json_encode(array(
                    'resultado' => false,
                    'mensaje_error' => "Error al buscar ventas"
                ));
            }
        }
        else
        {
            $ventas = $db->prepare("SELECT * FROM ventas WHERE rut_empresa = :rut_empresa");
            $ventas->execute(array(
                ':rut_empresa' => $data->rut_empresa
            ));
            $ventas = $ventas->fetchAll();
            if($ventas)
            {
                echo json_encode(array(
                    'resultado' => true,
                    'ventas' => $ventas
                ));
            }
            else
            {
                echo json_encode(array(
                    'resultado' => false,
                    'mensaje_error' => "Error al buscar ventas"
                ));
            }
        }
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
        $data = json_decode(file_get_contents("php://input"));
        $productos = $data->productos;
        $productosventa = array();

        //INSERT VENTA

        $insert_venta = $db->prepare(
            "INSERT INTO ventas
            (
                fecha, hora, total, personal_rut, rut_empresa
            )
             VALUES
            (
                :fecha, :hora, :total, :personal_rut, :rut_empresa
        )");

        $insert_venta = $insert_venta->execute(array(
            ':fecha' => $date,
            ':hora' => $hora,
            ':total' => 0,
            ':personal_rut' => $data->rut,
            ':rut_empresa' => $data->rut_empresa,
        ));
        foreach($productos as $producto)
        {
            $selec = $db->prepare(
                'SELECT * FROM productos WHERE idProducto = :idproducto'
            );
            $selec->execute(array(
                ':idproducto' => $producto->idProducto
            ));
            $selec = $selec->fetch();
            $productonew = new Stdclass();
            $productonew->idProducto = $selec->idProducto;
            $productonew->nombre = $selec->nombre;
            $productonew->precio = $selec->precio;
            $productonew->cantidad = $producto->stock;
            $productosventa[] = $productonew;
        }

        // INSERT DETALLE_VENTAS

        $insert_detalle_venta = $db->prepare(
            "INSERT INTO detalles_venta
            (
                idventa, idproducto, cantidad, precio, rut_empresa
            )
             VALUES
            (
                :idventa, :idproducto, :cantidad, :precio, :rut_empresa
            )"
        );

        $idventa = $db->prepare(
            "SELECT MAX(idVenta) AS idVenta FROM ventas"
        );
        $idventa->execute();
        $idventa = $idventa->fetch();
        $totalfinal = 0;
        $total = 0;

        foreach($productosventa as $productoh) { 

            $total = $productoh->precio*$productoh->cantidad;
            $totalfinal = $totalfinal + $total;
            $insert_detalle_venta->execute(array(
                ':idventa' => $idventa->idVenta,
                ':idproducto' => $productoh->idProducto,
                ':cantidad' => $productoh->cantidad,
                ':precio' => $total,
                ':rut_empresa' => $data->rut_empresa,
            ));
        }

        $insertotal = $db->prepare(
            "UPDATE ventas
            
            SET total = :total
            
            WHERE idVenta = :idventa"
        );
        $insertotal->execute(array(
            ':total' => $totalfinal,
            ':idventa' =>$idventa->idVenta
        ));
        if($insert_detalle_venta)
        {
            echo json_encode(array(
                'resultado' => true,
            ));
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

    public function eliminarVenta()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $eliminar = $db->prepare(
            'DELETE FROM ventas WHERE idVenta = :idventa'
        );
        $eliminar->execute(array(
            ':idventa' => $data->idventa
        ));
        //$eliminar = $eliminar->fetch();
        if($eliminar)
        {
            echo json_encode(array(
                'resultado' => true,
            ));
        }
        else
        {
            echo json_encode(array(
                'resultado' => false,
                'mensaje_error' => "error al eliminar"
            ));
        }

    }

    public function ventaPorId()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $ventas = $db->prepare(
            'SELECT  productos.idProducto, productos.nombre, productos.codigodebarra, detalles_venta.precio, detalles_venta.cantidad, categorias.Nombre
            FROM ((productos 
            INNER JOIN detalles_venta ON productos.idProducto = detalles_venta.idproducto)
            INNER JOIN categorias ON productos.categoria = categorias.idCategoria)
            WHERE idventa = :idventa'
        );
        $ventas->execute(array(
            ':idventa' => $data->idventa
        ));
        $ventas = $ventas->fetchAll();
        if($ventas)
        {
            echo json_encode(array(
                'resultado' => true,
                'ventas' => $ventas
            ));
        }
        else
        {
            echo json_encode(array(
                'resultado' => false,
                'mensaje_error' => "error al eliminar"
            ));
        }

    }
}
