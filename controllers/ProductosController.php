<?php

require_once 'Controller.php';
class ProductosController extends Controller 
{
    
    public function __construct()
    {
        $this->middleware('login');
    }

    public function ssolicitar()
    {
        //$this->getProductos();
       // return $this->view->make('solicitudes.productos')
        //->render();
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
            ->make('solicitudes.productos')
            ->with(array(
                'productos' => $productos
            ))
            ->render();
        }
    }

    public function agregar(){

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
    
}

