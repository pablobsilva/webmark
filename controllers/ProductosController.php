<?php

require_once 'Controller.php';

class ProductosController extends Controller 
{


    /*
    * @return el resultado de verificar si existe una sesión iniciada en el navegador
      si existe te deja ingresar a la vista productos, sino te redirecciona al home
    */
    public function __construct()
    { 
        $this->middleware('login');
    }

    /*
    * @return la vista para visualizar todos los productos junto con los datos de los productos y las categorias
    */
    public function productos()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			http_response_code(200);
        }
        $data = json_decode(file_get_contents("php://input"));
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $productos = $db->prepare('SELECT productos.idProducto, productos.nombre, productos.precio, productos.codigodebarra, productos.stock, categorias.nombre as categoria
        FROM productos
        INNER JOIN categorias ON productos.idCategoria=categorias.idCategoria
        WHERE rut_empresa = :rut_empresa'
        );
        $productos->execute(
            array(':rut_empresa' => $data->rut_empresa
        ));
        $productos = $productos->fetchAll();
        echo json_encode(
            array(
                "producto" => $productos,
            )
        );
    }

    public function datediff()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $datediff = $db->prepare(
            "SELECT DATEDIFF(:fecha_actual, :fecha_vencimiento)"
        );
        $datediff->execute(array(
            ':fecha_vencimiento' => '2020-07-10',
            ':fecha_actual' =>'2020-06-26'
        ));
        $datediff = $datediff->fetch();
        echo json_encode(
            array(
                "datediff" => $datediff,
            )
        );
    }
    /*
     *@param todos los parametros son rescatados por la clase request
     *@return el resultado de la inserción de la información a la base de datos, si es exitosa te redirecciona a la vista de productos denuevo
    */
    public function AgregarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			http_response_code(200);
		}
        $data = json_decode(file_get_contents("php://input"));
        $empresa = $data->rut_empresa;
        $producto = $data->producto;
        $nombre = $producto->nombre;
        $precio = $producto->precio;
        $codigodebarra = $producto->codigodebarra;
        $categoria = $producto->categoria;
        $stock = $producto->stock;

        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();

        $insert = $db->prepare( 
            'INSERT INTO productos
            (
                nombre, precio, codigodebarra, stock, idCategoria, rut_empresa 
            )
             VALUES
            (
                :nombre, :precio, :codigodebarra, :stock, :idcategoria, :rut_empresa
        )');

        $insert = $insert->execute(array(
                ':nombre' => $nombre,
                ':precio' => $precio,
                ':codigodebarra' => $codigodebarra,
                ':stock' => $stock,
                ':rut_empresa' => $empresa,
                ':idcategoria' => $categoria,
        ));
        if($insert)
        {
            echo json_encode(true);
        }
        else
        {
            echo json_encode("Error");
        }
    }
    /*
     *@param todos los parametros son rescatados por la clase request
     *@return el producto según su id, ya sea para poder editarlo o para eliminarlo
    */
    public function EditarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			http_response_code(200);
		}
        $data = json_decode(file_get_contents("php://input"));
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $producto = $data->producto;
        $idproducto = $producto->idProducto;
        $nombre = $producto->nombre;
        $precio = $producto->precio;
        $codigodebarra = $producto->codigodebarra;
        $categoria = $producto->categoria;
        $stock = $producto->stock;
        $insert = $db->prepare(
            "UPDATE productos
            
               SET nombre = :nombre, precio = :precio, codigodebarra = :codigodebarra, idCategoria = :idcategoria, stock = :stock
               
               WHERE idProducto = :idproducto
        ");
        $insert = $insert->execute(array(
                ':nombre' => $nombre,
                ':precio' => $precio,
                ':codigodebarra' => $codigodebarra,
                ':idcategoria' => $categoria,
                ':stock' => $stock,
                ':idproducto' => $idproducto,
        ));
        if($insert)
        {
            echo json_encode(true);
        }
        else
        {
            echo json_encode("Error al editar");
        }
    }
    /*
     *@param todos los parametros son rescatados por la clase request
     *@return el resultado de si un producto es eliminado, si es exitosa la eliminacion te redirige a la vista productos
    */
    public function EliminarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			http_response_code(200);
		}
        $data = json_decode(file_get_contents("php://input"));
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $idproducto = $data->idProducto;    
        $delete = $db ->prepare("DELETE FROM productos WHERE idProducto = :idproducto");
        $delete = $delete->execute(array(
            ':idproducto' => $idproducto,
        ));
        if($delete)
        {
            echo json_encode(true);
        }
        else
        {
            echo json_encode("Error al eliminar");
        }
    }
    /*
     *@param todos los parametros son rescatados por POST
     *@return el resultado de la inserción de información a la tabla stock
    */
    public function AgregarStock()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();     
        $idproducto = $_POST["idproducto"];
        $cantidad = $_POST["cantidad"];
        $fechaingreso = $_POST["fechaingreso"];
        $fechavencimiento = $_POST["fechavencimiento"];

        $update = $db->prepare(
            "UPDATE productos 
            SET stock = stock + :cantidad
            WHERE idProducto = :idproducto"
        );
        $update = $update->execute(array(
            ':cantidad' => $cantidad,
            ':idproducto' => $idproducto,
        ));
        $insert = $db->prepare(
            "INSERT INTO Stock
            (
                idProducto, fechaingreso, fechavencimiento
            )
             VALUES
            (
                :idproducto, :fechaingreso, :fechavencimiento
        )");
        $insert = $insert->execute(array(
            ':idproducto' => $idproducto,
            ':fechaingreso' => $fechaingreso,
            ':fechavencimiento' => $fechavencimiento,
        ));
        if($insert && $update)
        {
            return $this->redirect('/');
        }
    }
    /*
     *@param todos los parametros son rescatados por POST
     *@return el resultado de la inserción a la tabla compras y detalle_compras
    */
    public function RegistrarCompra()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();  
        $cantidades = $_POST["cantidades[]"];
        $distribuidor = $_POST["distribuidor"];
        $idproductos = $_POST["idproductoscompra[]"];
        $longitud = count($idproductos);
        $idcompra = $db->prepare(
            "SELECT MAX(idCompra) AS idCompra FROM compras"
        );
        $idcompra->execute();
        $idcompra = $idcompra->fetch();
        $idcompra=$idcompra->idCompra+1;

        $insertproductos = $db->prepare(
            "INSERT INTO detalles_compra
            (
                idcompra, idproducto, preciounitario, cantidad, preciototal
            )
            VALUES
            (
                :idcompra, :idproducto, :preciounitario, :cantidad, :preciototal
            )"
        );
        $totalfinal = 0;
        for($i=0; $i<$longitud; $i++)
        {
            $selecproducto = $db->prepare(
                "SELECT * FROM productos WHERE idProducto = :idproducto"
            );
            $selecproducto->execute(array(
                ':idproducto' => $idproductos[$i],
            ));
            $selecproducto = $selecproducto->fetch();
            $producto = new StdClass();
            $producto->id = $selecproducto->idProducto;
            $producto->nombre = $selecproducto->nombre;
            $producto->precio = $selecproducto->precio;
            $producto->cantidad = $cantidades[$i];
            $productos[] = $producto;
            $precio = $selecproducto->precio;
            $cantidad = $cantidades[$i];
            $total = $precio*$cantidad;
            $totalfinal = $totalfinal + $total;                
            $insertproductos->execute(array(
                ':idcompra' => $idcompra,
                ':idproducto' => $selecproducto->idProducto,
                ':preciounitario' => $selecproducto->precio,
                ':cantidad' => $producto->cantidad,
                ':preciototal' => $total,
            ));
            $update = $db->prepare(
                "UPDATE productos 
                SET stock = stock + :cantidad
                WHERE idProducto = :idproducto"
            );
            $update->execute(array(
                ':idproducto' => $producto->id,
                ':cantidad' => $cantidades[$i],
            ));    
            
        }

        $insertcompra = $db->prepare(
            "INSERT INTO compras
            (
                preciototal, distribuidor, fechayhora
            )
             VALUES
            (
                :preciototal, :distribuidor, :fechayhora
            )"
        );
        date_default_timezone_set('America/Santiago');
        $date = date('Y-m-d', time());
        //$hora = date('H:i:s', time());
        print $date;
        $insertcompra = $insertcompra->execute(array(
            ':preciototal' => $totalfinal,
            ':distribuidor' => $distribuidor,
            ':fechayhora' => $date,
        ));
        if($insertcompra)
        {
            return $this->redirect('/');
        }
    }
    /*
     *@param todos los parametros son rescatados por request
     *@return el resultado de la consulta a la tabla productos, si es exitosa devuelve los datos del producto por su codigo de barra
    */
    public function ProductoPorCodigoBarra()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $producto = $db->prepare(
            "SELECT p.idProducto, p.nombre, p.precio, p.codigodebarra, p.stock, p.rut_empresa, c.nombre as categoria
            FROM productos p 
            INNER JOIN categorias c 
                ON p.idCategoria = c.idCategoria 
            WHERE codigodebarra = :codigodebarra 
                AND rut_empresa = :rut_empresa");
        $producto->execute(array(
            ':codigodebarra' => $data->codigodebarra,
            ':rut_empresa' => $data->rut_empresa
        ));
        if($producto)
        {
            $producto = $producto->fetch();
            echo json_encode(array(
                'resultado' => true,
                'producto' => $producto,
            ));
        }
    }

    public function ProductoPorId()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			http_response_code(200);
		}
        $data = json_decode(file_get_contents("php://input"));
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $producto = $db->prepare("SELECT * FROM productos WHERE idProducto  = :id");
        $producto->execute(array(
            ':id' => $data->idProducto,
        ));
        if($producto)
        {
            $producto = $producto->fetch();
            echo json_encode($producto);
        }
    }

    public function AvisoVencimiento()
    {
        $fecha = date('Y-m-d', time());
        $data = json_decode(file_get_contents("php://input"));
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $stocks = $db->prepare(
            "SELECT * FROM stocks WHERE rut_empresa = :rut_empresa");
        $stocks->execute(array(
            'rut_empresa' => $data->rut_empresa
        ));
        $stocks = $stocks->fetchAll();
        $productos_por_vencer = array();

        foreach($stocks as $stock)
        {
            //SACAR PRODUCTOS 
            $producto = $db->prepare(
                "SELECT * FROM productos WHERE idProducto = :idproducto"
            );
            $producto->execute(array(
                ':idproducto' => $stock->idProducto
            ));
            $producto = $producto->fetch();
            //CALCULAR DÍAS CERCANOS A FECHA DE VENCIMIENTO
            $datediff = $db->prepare(
                "SELECT DATEDIFF(:fecha_vencimiento, :fecha_actual ) as dias"
            );
            $datediff->execute(array(
                ':fecha_vencimiento' => $stock->fechavencimiento,
                ':fecha_actual' =>$fecha
            ));
            $datediff = $datediff->fetch();

            if($datediff->dias<30)
            {
                $productos_por_vencer[] = $producto;
            }
        }
        if(count($productos_por_vencer)>=1)
        {
            echo json_encode(array(
                'respuesta' => true,
                'productos' => $productos_por_vencer
            ));
        }
        else
        {
            echo json_encode(array(
                'respuesta' => false
            ));
        }
    }


}
