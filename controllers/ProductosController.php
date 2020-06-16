<?php

require_once 'Controller.php';
class ProductosController extends Controller 
{
    
    public function __construct()
    {
        $this->middleware('login');
    }

    public function solicitar($idcategoria = "")
    {
        if($idcategoria != "")
        {
            require_once '../classes/Conexion.php';
            $db = Conexion::retornar();
            $productos = $db->prepare('SELECT * 
               FROM Producto 
               WHERE Categoria_idCategoria = :idCategoria'
            );
   
            $productos->execute(array(
                ':idCategoria' => $idcategoria
            ));
            $listado = $productos->fetchAll();

        }else
        {
            require_once '../classes/Conexion.php';
            $db = Conexion::retornar();
            $productos = $db->prepare('SELECT * 
               FROM Producto'
            );
            $productos->execute();
            $productos = $productos->fetchAll();
            //print_r($productos);
            //exit;
            return $this
            ->view
            ->make('productos.ver')
            ->with(array(
                'productos' => $productos
            ))
            ->render();
        }
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
            "INSERT INTO Producto
            (
                nombre, empresa, categoria_idCategoria
            )
             VALUES
            (
                :nombre, :empresa, :idcategoria
            )");

        $insert = $insert->execute(array(
                ':nombre' => $nombre,
                ':empresa' => $empresa,
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
            "UPDATE Producto
            
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
        $delete = $db ->prepare("DELETE FROM Producto WHERE idProducto = :idproducto");
        $delete = $delete->execute(array(
            ':idproducto' => $idproducto,
        ));
        if($delete)
        {
            return $this->redirect('/');
        }
        
    }
}

