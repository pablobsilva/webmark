<?php
require_once 'Controller.php';

class CategoriasController extends Controller
{
	public function __construct()
	{
		$this->middleware('login');
    }

    public function AgregarCategoria()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $nombre = $_POST["nombre"];
        $insert = $db->prepare(
            "INSERT INTO Categoria (nombre) VALUES (:nombre)");
        $insert = $insert->execute(array(
                ':nombre' => $nombre,
            ));
        if($insert)
        {
            return $this->redirect('/');
        }            

    }

    public function FormularioCategoria()
    {
        return $this->view->make('categorias.agregar')
        ->render();
    }

    public function EliminarCategoria()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $nombre = $_POST["idcategoria"];
        $delete = $db ->prepare("DELETE FROM Categoria WHERE idCategoria = :idpcategoria");
        $delete = $delete->execute(array(
            ':idcategoria' => $idcategoria,
        ));
        if($delete)
        {
            return $this->redirect('/');
        }
    }

    public function Categorias()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $select = $db->prepare(
            "SELECT * FROM categorias");
        $select->execute();
        $select = $select->fetchAll();
        if($select)
        {
            echo json_encode(array(
                'respuesta' => true,
                'categorias' => $select,
            ));
        }           
    }
}


