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

    public function indexAdmin()
    {
        return $this->view->make('administrador.index')
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

    public function verpersonal()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $personal = $db->prepare("SELECT rut, nombre, apellidoPaterno, apellidoMaterno FROM personal WHERE rut_empresa = :rut_empresa");
        $personal->execute(array(
            ':rut_empresa' => $data->rut_empresa
        ));
        $personal = $personal->fetchAll();
        if($personal)
        {
            echo json_encode(array(
                'resultado' => true,
                'personal' => $personal,
            ));
        }
        else
        {
            echo json_encode(array(
                'mensaje_error' => "error al mostrar personal",
            ));
        }
    }    



    function exists_empresa($empresa)
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $empresas = $db->prepare(
            'SELECT * FROM empresas WHERE rut_empresa = :rut_empresa'
        );
        $empresas = $empresas->execute(array(
            ':rut_empresa' => $empresa->rut_empresa
        ));
        if($empresas == false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function updateEmpresa()
    {
        require_once '../classes/Conexion.php';
        $data = json_decode(file_get_contents("php://input"));
        $empresa = $data->empresa;
        $db = Conexion::retornar();
        $existe = $this->exists_empresa($empresa);
        if(!$existe)
        {
            $insert = $db->prepare(
                "INSERT INTO empresas
                (
                    rut_empresa, nombre, direccion, giro, correo, telefono
                )
                 VALUES
                (
                    :rut_empresa, :nombre, :direccion, :giro, :correo, :telefono
                )");
            $insert = $insert->execute(array(
                    ':rut_empresa' => $empresa->rut_empresa,
                    ':nombre' => $empresa->nombre,
                    ':direccion' => $empresa->direccion,
                    ':giro' => $empresa->giro,
                    ':correo' => $empresa->correo,
                    ':telefono' => $empresa->telefono
            ));
            $update = $db->prepare(
                "UPDATE usuarios
                
                   SET rut_empresa = :rut_empresa
                   
                   WHERE rut = :rut"
            );
            $update = $update->execute(
                array(
                    ':rut_empresa' => $empresa->rut_empresa,
                    ':rut' => $data->rut,
            ));
            if($update)
            {
                echo json_encode(array(
                    'resultado' => true,
                    'rut_empresa' => $empresa->rut_empresa
                ));
            }
            else
            {
                echo json_encode(array(
                    'mensaje_error' => "Error al ingresar",
                ));
            }       
        }
        else
        {
            echo json_encode(array(
                'mensaje_error' => "Rut ya registrado en el sistema",
            ));
        }
        
    }

    public function agregarPersonal()
    {
        require_once '../classes/Conexion.php';
        $data = json_decode(file_get_contents("php://input"));
        $personal = $data->personal;
        $db = Conexion::retornar();
        $rut = $personal->rut;
        $nombre = $personal->nombre;
        $pass = $personal->password;
        $encrypted = md5($pass);
        $tipousuario = 2;
        $insert = $db->prepare(
            "INSERT INTO usuarios
            (
                rut, nombre, pass, tipoUsuario, rut_empresa
            )
             VALUES
            (
                :rut, :nombre, :pass, :tipousuario, :rut_empresa
        )");

        $insert = $insert->execute(array(
                ':rut' => $personal->rut,
                ':nombre' => $personal->nombre,
                ':pass' => $encrypted,
                ':tipousuario' => $tipousuario,
                ':rut_empresa' => $data->rut_empresa
        )); 

        $personaladd = $db->prepare(
            'INSERT INTO personal
            (
                rut, nombre, apellidoPaterno, apellidoMaterno, rut_empresa
            )    
            VALUES
            (
                :rut, :nombre, :apellidopaterno, :apellidomaterno, :rut_empresa
        )');

        $personaladd->execute(array(
            ':rut' => $personal->rut,
            ':nombre' => $personal->nombre,
            ':apellidopaterno' => $personal->apellidoPaterno,
            ':apellidomaterno' => $personal->apellidoMaterno,
            ':rut_empresa' => $data->rut_empresa
        ));    

        if($insert)
        {
            echo json_encode(true);
        }
        else
        {
            echo json_encode(array(
                'mensaje_error' => "Error al ingresar",
            ));
        }       
    }

    public function updatePersonal()
    {
        require_once '../classes/Conexion.php';
        $data = json_decode(file_get_contents("php://input"));
        $personal = $data->personal;
        $db = Conexion::retornar();
        $rut = $personal->rut;
        $nombre = $personal->nombre;
        $update = $db->prepare(
            "UPDATE personal 
            SET nombre = :nombre, apellidoPaterno = :apellidopaterno, apellidoMaterno = :apellidomaterno
            WHERE rut= :rut");

        $update = $update->execute(array(
                ':rut' => $personal->rut,
                ':nombre' => $personal->nombre,
                ':apellidopaterno' => $personal->apellidoPaterno,
                ':apellidomaterno' => $personal->apellidoMaterno,
        )); 
        if($update)
        {
            echo json_encode(true);
        }
        else
        {
            echo json_encode(array(
                'mensaje_error' => "Error al actualizar personal",
            ));
        }  
    }

    public function deletePersonal()
    {
        require_once '../classes/Conexion.php';
        $data = json_decode(file_get_contents("php://input"));
        $db = Conexion::retornar();
        $delete = $db->prepare(
            "DELETE FROM personal WHERE rut = :rut"
        );
        $delete = $delete->execute(array(
            ':rut' => $data->rut
        ));
        if($delete)
        {
            echo json_encode(array(
                'resultado' => true,
            ));
        }
        else
        {
            echo json_encode(array(
                'mensaje_error' => "Error al eliminar",
            ));
        }
    }

    public function personalPorRut()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $personal = $db->prepare("SELECT rut, nombre, apellidoPaterno, apellidoMaterno FROM personal WHERE rut = :rut AND rut_empresa = :rut_empresa ");
        $personal->execute(array(
            ':rut' => $data->rut,
            ':rut_empresa' => $data->rut_empresa
        ));
        $personal = $personal->fetch();
        if($personal)
        {
            echo json_encode(array(
                'resultado' => true,
                'personal' => $personal,
            ));
        }
        else
        {
            echo json_encode(array(
                'mensaje_error' => "error al ingresar",
            ));
        }
    }
}
