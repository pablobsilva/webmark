<?php 
include 'Controller.php';
use \Firebase\JWT\JWT;
class AuthController extends Controller
{        
    
    /* 
    * Este metodo se encarga de devolver la vista home principal del sistema
    * @return la vista home
    */
    public function home()
    {
        return $this->view->make('home.home')
        ->render();
    }
        /* 
        * Este metodo se encarga de devolver la vista para iniciar sesion en el sistema
        * @return la vista login para iniciar sesion
        */
    public function login()
    {
        return $this->view->make('home.login/login')
        ->render();
    }
        /* 
        * Este metodo se encarga de devolver la vista para registrarse en el sistema
        * @return la vista para registrarse en el sistema
        */
    public function registrar()
    {

        return $this->view->make('home.login/register')
        ->render();
    }
    /*
    * El metodo doLogin es el que se encarga de hacer la acción de login dentro del sistema
    * con el usuario y la password consulta en la tabla si existen estos datos, y si existen
    * inicia una sesión con los datos del usuario ingresado
    * @param los datos de ingresos son obtenidos por la clase request. 
    * @return el resultado del login, si es exitoso al dashboard principal, sino al inicio de sesion nuevamente
    */
    public function doLogin(){

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			http_response_code(200);
		}
        $data = json_decode(file_get_contents("php://input"));
        $rut = $data->rut;
        $password = $data->password;

        if(isset($rut))
        {
            require_once '../classes/Conexion.php';
            $db = Conexion::retornar();
            $usuarios = $db
            ->prepare('SELECT * FROM usuarios
                WHERE rut = :rut 
                AND pass = :clave'
            );
            $encrypted = md5($password);
            require_once 'config/core.php';
            require_once 'libs/php-jwt-master/src/BeforeValidException.php';
            require_once 'libs/php-jwt-master/src/ExpiredException.php';
            require_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
            require_once '/var/www/WebMarketTest/controllers/libs/php-jwt-master/src/JWT.php'; 
            $usuarios->execute(array(
                ':rut' => $rut,
                ':clave'=> $encrypted,
            ));
            $usuario = $usuarios->fetch();
            if($usuario)
            {
                // se genera el token
                $token = array(
                    "iss" => $iss,
                    "aud" => $aud,
                    "iat" => $iat,
                    "nbf" => $nbf,
                    "exp" => $exp + (1800),
                    "data" => array(
                        "rut" => $usuario->rut,
                        "firstname" => $usuario->nombre,
                        "tipoUsuario" => $usuario->tipoUsuario,
                        "rut_empresa" => $usuario->rut_empresa,
                    )
                 );
                http_response_code(200); 
                $jwt = JWT::encode($token, $key);
                echo json_encode(
                        array(
                            "jwt" => $jwt,
                            "tipoUsuario" => $usuario->tipoUsuario,
                            "rut" => $usuario->rut,
                            "nombre" => $usuario->nombre,
                            "rut_empresa" => $usuario->rut_empresa,
                        ));
                exit;
            }
            else
            {
                http_response_code(401);
                echo json_encode(array("message" => "Login failed."));
                exit;
            }
        }
        else
        {
            http_response_code(401);
            echo json_encode(array("message" => "Login failed."));
            exit;
        }
        http_response_code(401);
        echo json_encode(array("message" => "Login failed."));
        exit;
    }

    /*
    * Este metodo realizar la acción de registrarse en el sistema
    * @param los datos de ingresos son obtenidos por la clase request. 
    * @return el resultado del registro al sistema, redirecciona al dashboard principal si es exitoso el registro 
    */

    public function doRegister()
    {
        require_once '../classes/Conexion.php';
        $data = json_decode(file_get_contents("php://input"));
        $usuario = $data->usuario;
        $db = Conexion::retornar();
        $rut = $usuario->rut;
        $nombre = $usuario->nombre;
        $pass = $usuario->password;
        $encrypted = md5($pass);
        $tipousuario = $usuario->tipoUsuario;
        $insert = $db->prepare(
            "INSERT INTO usuarios 
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
                ':pass' => $encrypted,
                ':tipousuario' => $tipousuario,
        )); 
        if($insert)
        {
            echo json_encode(true);
        }
        else
        {
            echo json_encode("Error al registrar");
        }       
    }
    /*
    * Este metodo se encarga de eliminar la variable auth de la session del cliente
    * @return la vista home después de eliminar la sesión activa del usuario
    */
    public function logout()
	{
		unset($_SESSION['auth']);
		return $this->redirect('/');
    }
    
    public function eslip()
    {
        sleep(15);
        echo "hola";
    }

    public function usuarioPorRut()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $usuarios = $db
        ->prepare('SELECT * FROM usuarios
            WHERE rut = :rut'
        );
        $usuarios->execute();
        $usuarios = $usuarios->fetch();
        if($usuarios)
        {
            echo json_encode($usuarios);
        }
        else
        {
            echo json_encode("Usuario no encontrado");
        }      

    }

    public function validate_token()
    {
        header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication/");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        include_once 'config/core.php';
        include_once 'libs/php-jwt-master/src/BeforeValidException.php';
        include_once 'libs/php-jwt-master/src/ExpiredException.php';
        include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
        include_once 'libs/php-jwt-master/src/JWT.php';
        
        $authHeader = apache_request_headers(); //en caso de que sea ubuntu el server.
        $authHeader = array_combine(array_map('ucwords', array_keys($authHeader)), array_values($authHeader));
        
        $arr = explode(" ", $authHeader['Authorization']);
        $jwt=$arr[1];
     
        if($jwt){
         
            // if decode succeed, show user details
            //echo "<br>stoy aki";
            try {
                // decode jwt

                $decoded = JWT::decode($jwt, $key, array('HS256'));
         
                // set response code
                http_response_code(200);
         
                // show user details
                echo json_encode(array(
                    "message" => "Access granted.",
                    "data" => $decoded->data
                ));
                //return true;
                exit;
         
            }catch (Exception $e){
         
            // set response code
            http_response_code(401);
         
            // tell the user access denied  & show error message
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage()
            ));
            return false;
            exit;
            }
        }
        else{
            // set response code
            http_response_code(401);
            // tell the user access denied
            echo json_encode(array("message" => "Access denied."));
            return false;
            exit;
        }
    }
}
