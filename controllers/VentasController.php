<?php

require_once 'Controller.php';

class VentasController extends Controller
{
    public function __construct()
    {
       $this->middleware('login');
    }

    public function VerVentas()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->fecha))
        {
            $ventas = $db->prepare("SELECT * FROM ventas 
            WHERE fecha = :fecha 
            AND rut_empresa = :rut_empresa 
            ORDER BY date(fecha) desc,hora desc");
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
            $ventas = $db->prepare("SELECT * FROM ventas WHERE rut_empresa = :rut_empresa ORDER BY date(fecha) desc, hora desc");
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
            $productonew->cantidad = $producto->cantidad;
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

        $update = $db->prepare(
            "UPDATE productos SET stock = stock-:stock WHERE idProducto = :idproducto"
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
            $update->execute(array(
                ':stock' => $productoh->cantidad,
                ':idproducto' => $productoh->idProducto
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
            'SELECT  p.idProducto, p.nombre, p.codigodebarra, dv.precio, dv.cantidad, c.nombre as categoria
            FROM productos p 
            INNER JOIN detalles_venta dv 
                ON p.idProducto = dv.idproducto
            INNER JOIN categorias c
                ON p.idCategoria = c.idCategoria
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
                'mensaje_error' => "error al mostrar venta"
            ));
        }
    }

    public function VerVentasDelDia()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $fecha = date('Y-m-d', time());
        $ventas = $db->prepare(
            'SELECT * FROM ventas WHERE fecha = :fecha AND rut_empresa = :rut_empresa'
        );
        $ventas->execute(array(
            ':rut_empresa' => $data->rut_empresa,
            ':fecha' => $fecha
        ));
        $ventas = $ventas->fetchAll();
        if($ventas)
        {
            echo json_encode(array(
                'ventas' => $ventas,
            ));
        }
    }

    public function ventasPorTrabajador()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $personal = $db->prepare(
            "SELECT * FROM personal WHERE rut_empresa = :rut_empresa"
        );
        $personal->execute(array(
            ':rut_empresa' => $data->rut_empresa
        ));
        $personal = $personal->fetchAll();

        foreach($personal as $perso)
        {
            $ventas = $db->prepare(
                "SELECT * FROM ventas WHERE personal_rut = :rut"
            );
            $ventas->execute(array(
                ':rut' => $perso->rut
            ));
            $ventas = $ventas->fetchAll();
            $perso->ventas = $ventas;
        }
        if($personal)
        {
            echo json_encode(array(
                'personal' => $personal,
            ));
        }
        else
        {
            echo json_encode(array(
                'respuesta' => false,
            ));
        }
    }



}
