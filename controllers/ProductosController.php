<?php

require_once 'Controller.php';
class ProductosController extends Controller 
{
    
    public function __construct()
    { 
       // $this->middleware('login');
    }

    public function productos()
    {
        require_once '../classes/Conexion.php';
            $db = Conexion::retornar();
            $productos = $db->prepare('SELECT * 
               FROM productos'
            );
            $productos->execute();
            $productos = $productos->fetchAll();

            $categorias = $db->prepare('SELECT * FROM categorias');
            $categorias->execute();
            $categorias = $categorias->fetchAll();
            $tamaño = count($productos);
            foreach ($productos as $producto) { 
                foreach($categorias as $categoria) { 
                    if($producto->categoria == $categoria->idCategoria)
                    {
                        $producto->categoria = $categoria->Nombre;
                    }
                }
            }
            return $this
            ->view
            ->make('administrador.producto/productos')
            ->with(array(
                'productos' => $productos
            ))
            ->render();
    }

    public function FormularioEditar(){

        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $categorias = $db->prepare('SELECT * FROM Categoria');
        $categorias->execute();
        $categorias = $categorias->fetchAll();
        
        $db = Conexion::retornar();
        $productos = $db->prepare('SELECT * FROM Producto');
        $productos->execute();
        $productos = $productos->fetchAll();
        // devuelve las categorias para poder elegir una nueva en el caso que sea así. 
        return $this
        ->view
        ->make('productos.editar')
        ->with(array(
            'categorias' => $categorias,
            'productos' => $productos,
        ))
        ->render();
    }

    public function FormularioAgregar(){

        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $categorias = $db->prepare('SELECT * FROM Categoria');
        $categorias->execute();
        $categorias = $categorias->fetchAll();
        return $this
        ->view
        ->make('productos.agregar')
        ->with(array(
            'categorias' => $categorias
        ))
        ->render();
    }

    public function AgregarProducto()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $codigodebarra = $_POST["codigodebarra"];
        $empresa = $_SESSION['auth']['nombre'];
        $categoria = $_POST["categoria"];

        $insert = $db->prepare(
            "INSERT INTO productos
            (
                nombre, precio, empresa, codigodebarra, categoria_idCategoria
            )
             VALUES
            (
                :nombre, :precio, :empresa, :codigodebarra, :idcategoria
            )");

        $insert = $insert->execute(array(
                ':nombre' => $nombre,
                ':precio' => $precio,
                ':empresa' => $empresa,
                ':codigodebarra' => $codigodebarra,
                ':idcategoria' => $categoria,
            ));
        if($insert)
        {
            return $this->redirect('/');
        }
    }
    
    public function EditarProducto()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $idproducto = $_POST["idproducto"];
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $codigodebarra = $_POST["codigodebarra"];
        $categoria = $_POST["categoria"];
        $insert = $db->prepare(
            "UPDATE productos
            
               SET nombre = :nombre, precio = :precio, codigodebarra = :codigodebarra, categoria_idCategoria = :idcategoria
               
               WHERE idProducto = :idproducto
               ");

        $insert = $insert->execute(array(
                ':nombre' => $nombre,
                ':precio' => $precio,
                ':codigodebarra' => $codigodebarra,
                ':idcategoria' => $categoria,
                ':idproducto' => $idproducto,
            ));
        if($insert)
        {
            return $this->redirect('/');
        }
    }

    public function EliminarProducto()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $idproducto = $_POST["idproducto"];    
        $delete = $db ->prepare("DELETE FROM productos WHERE idProducto = :idproducto");
        $delete = $delete->execute(array(
            ':idproducto' => $idproducto,
        ));
        if($delete)
        {
            return $this->redirect('/');
        }
        
    }

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

    public function RegistrarCompra()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();  
        $cantidades = $_POST["cantidades[]"];
        $distribuidor = $_POST["distribuidor"];
        $idproductos = $_POST["idproductoscompra[]"];
        //$cantidades = array("2","3");
        //$idproductos = array("1","4");
        //$distribuidor = "carlos pinto";
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

    public function ProductoPorCodigoBarra()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $request = $this->request;
        //echo "<script>console.log( 'Debug Objects: " . $request->codigodebarra . "' );</script>";
        $producto = $db->prepare("SELECT * FROM productos WHERE codigodebarra = :codigodebarra");
        $producto->execute(array(
            ':codigodebarra' => $request->codigodebarra,
        ));
        $producto = $producto->fetch();
        echo json_encode($producto);
    }


}

