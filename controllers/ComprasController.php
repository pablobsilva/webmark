<?php 

require_once 'Controller.php';
class ComprasController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function RegistrarCompra()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $compra = $data->compra;
        $productos = $data->productos;
        date_default_timezone_set('America/Santiago');
        $date = date('Y-m-d', time());
        $productoscompra = array();
        $insert_compra = $db->prepare(
            "INSERT INTO compras
            (
                preciototal, distribuidor, fecha, rut_empresa, rut_empleado
            )
             VALUES
            (
                :preciototal, :distribuidor, :fecha, :rut_empresa, :rut_empleado
        )");
        $insert_compra = $insert_compra->execute(array(
        ':preciototal' => $compra->preciototal,
        ':distribuidor' => $compra->distribuidor,
        ':fecha' => $date,
        ':rut_empresa' => $data->rut_empresa,
        ':rut_empleado' => $data->rut,
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
            $productoscompra[] = $productonew;
        }
        $insert_detalle_compra = $db->prepare(
            "INSERT INTO detalles_compra
            (
                idcompra, idproducto, preciounitario, cantidad, preciototal
            )
             VALUES
            (
                :idcompra, :idproducto, :preciounitario, :cantidad, :preciototal
            )"
        );
        $idcompra = $db->prepare(
            "SELECT MAX(idCompra) AS idCompra FROM compras"
        );
        $idcompra->execute();
        $idcompra = $idcompra->fetch();
        $totalfinal = 0;
        $total = 0;

        $update = $db->prepare(
            "UPDATE productos SET stock = stock+:stock WHERE idProducto = :idproducto"
        );

        foreach($productoscompra as $producto) { 
            $total = $producto->precio*$producto->cantidad;
            $totalfinal = $totalfinal + $total;
            $insert_detalle_compra->execute(array(
                ':idcompra' => $idcompra->idCompra,
                ':idproducto' => $producto->idProducto,
                ':preciounitario' => $producto->precio,
                ':cantidad' => $producto->cantidad,
                ':preciototal' => $total,
            ));
            $update->execute(array(
                ':stock' => $producto->cantidad,
                ':idproducto' => $producto->idProducto
            ));
        }
        if($insert_detalle_compra)
        {
            echo json_encode(array(
                'resultado' => true,
            ));
        }
    }

    public function VerCompras()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->fecha))
        {
            $compras = $db->prepare("SELECT * FROM compras 
            WHERE fecha = :fecha 
            AND rut_empresa = :rut_empresa 
            ORDER BY fecha desc, idCompra");
            $compras->execute(array(
                ':fecha' => $data->fecha,
                ':rut_empresa' => $data->rut_empresa
            ));
            $compras = $compras->fetchAll();
            if($compras)
            {
                echo json_encode(array(
                    'resultado' => true,
                    'compras' => $compras
                ));
            }
            else
            {
                echo json_encode(array(
                    'resultado' => false,
                    'mensaje_error' => "Error al buscar compras"
                ));
            }
        }
        else
        {
            $compras = $db->prepare("SELECT * FROM compras WHERE rut_empresa = :rut_empresa ORDER BY fecha desc, idCompra desc");
            $compras->execute(array(
                ':rut_empresa' => $data->rut_empresa
            ));
            $compras = $compras->fetchAll();
            if($compras)
            {
                echo json_encode(array(
                    'resultado' => true,
                    'compras' => $compras
                ));
            }
            else
            {
                echo json_encode(array(
                    'resultado' => false,
                    'mensaje_error' => "Error al buscar compras"
                ));
            }
        }
    }

    public function verCompraPorId()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $compras = $db->prepare(
            'SELECT  p.idProducto, p.nombre, p.codigodebarra, dc.preciounitario, dc.cantidad, dc.preciototal, c.Nombre AS categoria
            FROM productos p 
            INNER JOIN detalles_compra dc 
                ON p.idProducto = dc.idproducto
            INNER JOIN categorias c 
                ON p.idCategoria = c.idCategoria
            WHERE idcompra = :idcompra'
        );
        $compras->execute(array(
            ':idcompra' => $data->idCompra
        ));
        $compras = $compras->fetchAll();

        $compra = $db->prepare(
            "SELECT * FROM compras WHERE idCompra = :idcompra"
        );
        $compra->execute(array(
            ':idcompra' => $data->idCompra
        ));
        $compra = $compra->fetch();
        if($compras)
        {
            echo json_encode(array(
                'resultado' => true,
                'detalle_compra' => $compras,
                'compra' => $compra,
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

    public function eliminarcompra()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $eliminar = $db->prepare(
            'DELETE FROM compras WHERE idCompra = :idcompra'
        );
        $eliminar->execute(array(
            ':idcompra' => $data->idCompra,
        ));
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

    public function VerComprasDelDia()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $fecha = date('Y-m-d', time());
        $compras = $db->prepare(
            'SELECT * FROM compras WHERE fecha = :fecha AND rut_empresa = :rut_empresa'
        );
        $compras->execute(array(
            ':fecha' => $fecha,
            ':rut_empresa' => $data->rut_empresa
        ));
        $compras = $compras->fetchAll();
        if($compras)
        {
            echo json_encode(array(
                'compras' => $compras,
            ));
        }
    }
}