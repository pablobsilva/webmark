<?php

require_once 'Controller.php';
class UsuariosController extends Controller 
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function FormularioRegistrarPersonal()
    {
        return $this->view->make('auth.registrarpersonal')
        ->render();
    }

    public function navegar()
    {
        return $this->view->make('usuario.navegar')
        ->render();
    }
    public function navegarPersonal()
    {
        return $this->view->make('personal.navegar')
        ->render();
    }
    public function RegistrarPersonal()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $rut = $_POST["rut"];
        $nombre = $_POST["nombre"];
        $pass = $_POST["password"];
        $insert = $db->prepare(
            "INSERT INTO Usuario 
            (
                rut, nombre, pass, tipoUsuario
            )
             VALUES
            (
                :rut, :nombre, :pass, :tipousuario
            )");

        $insert = $insert->execute(array(
                ':rut' => $rut,
                ':nombre' => $nombre,
                ':pass' => $pass,
                ':tipousuario' => "2",
            ));
        if($insert)
        {
            return $this->redirect('/');
        }
        else
        {
           // return $this->redirect('auth/registrarse');
        }    
    }


}