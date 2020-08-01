<?php

require_once 'Controller.php';
class UsuariosController extends Controller 
{
    public function __construct()
    {
        //$this->middleware('login');
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
        if($existe)
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
                rut, nombres, apellidos, pass, tipoUsuario, rut_empresa
            )
             VALUES
            (
                :rut, :nombres, :apellidos, :pass, :tipousuario, :rut_empresa
        )");

        $insert = $insert->execute(array(
                ':rut' => $personal->rut,
                ':nombres' => $personal->nombre,
                ':apellidos' => $personal->apellidoPaterno." ".$personal->apellidoMaterno,
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

    public function empresaCheck()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $rut = $data->rut_empresa;
        
        $empresas = $db->prepare(
            'SELECT * FROM empresas WHERE rut_empresa = :rut_empresa'
        );
        $empresas->execute(array(
            ':rut_empresa' => $rut->rut_empresa
        ));
        $empresaX = $empresas->fetch();

        //json_encode("SOY EL YOYO MAXIMO");

        //json_encode($empresa);

        if($empresaX)
        {
            echo json_encode(array(
                'respuesta' => true,
            ));
        }
        else
        {
            echo json_encode(array(
                'respuesta' => false,
            ));
        }
    }

    public function empresaPorRut()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $empresa = $db->prepare(
            "SELECT * FROM empresas WHERE rut_empresa = :rut_empresa"
        );
        $empresa->execute(array(
            ':rut_empresa' => $data->rut_empresa,
        ));
        $empresa = $empresa->fetch();
        if($empresa)
        {
            echo json_encode(array(
                'respuesta' => true,
                'empresa' => $empresa,
            ));
        }
        else
        {
            echo json_encode(array(
                'respuesta' => false,
            ));
        }
    }

    public function sumarLikes()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $like = $db->prepare(
            "UPDATE empresas SET likes = likes+:likes WHERE rut_empresa = :rut_empresa"
        );
        $like = $like->execute(array(
            ':rut_empresa' => $data->rut_empresa,
            ':likes' => 1,
        ));
        if($like)
        {
            echo json_encode(array(
                'respuesta' => true,
            ));
        }
        else
        {
            echo json_encode(array(
                'respuesta' => false,
            ));
        }
    }

    public function verLikes()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $data = json_decode(file_get_contents("php://input"));
        $likes = $db->prepare(
            "SELECT likes FROM empresas WHERE rut_empresa = :rut_empresa"
        );
        $likes->execute(array(
            ':rut_empresa' => $data->rut_empresa
        ));
        $likes = $likes->fetch(); 
        if($likes)
        {
            echo json_encode(array(
                'respuesta' => true,
                'likes' => $likes,
            ));
        }
        else
        {
            echo json_encode(array(
                'respuesta' => false,
            ));
        }
    }

    public function verEmpresas()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $empresas = $db->prepare(
            "SELECT * FROM empresas"
        );
        $empresas->execute();
        $empresas = $empresas->fetchAll();
        if($empresas)
        {
            echo json_encode(array(
                'empresas' => $empresas,
            ));
        }
        else
        {
            echo json_encode(array(
                'respuesta' => "Error al buscar empresas",
            ));
        }
    }
}

