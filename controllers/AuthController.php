<?php 
include 'Controller.php';

class AuthController extends Controller
{
    public function home()
    {
        return $this->view->make('home.home')
        ->render();
    }

    public function uwu()
    {
        return $this->view->make('test.uwu')
        ->render();
    }

    public function login()
    {
        return $this->view->make('home.login/login')
        ->render();
    }

    public function registrar()
    {
        return $this->view->make('home.login/register')
        ->render();
    }

    public function doLogin(){
        
        if($this->request->exists(array('usuario','password')))
        {
            require_once '../classes/Conexion.php';
            $db = Conexion::retornar();
            $usuarios = $db
            ->prepare('SELECT * FROM usuarios
                WHERE rut = :usuario 
                AND pass = :clave'
            );
            $usuarios->execute(array(
                ':usuario' => $this->request->usuario,
                ':clave'=> $this->request->password,
            ));
            $usuario = $usuarios->fetch();
            
            if($usuario)
            {
                $_SESSION['auth']['rut'] = $usuario->rut;
                $_SESSION['auth']['nombre'] = $usuario->nombre;
                $_SESSION['auth']['tipo'] = $usuario->tipoUsuario;
            }

        }
        else
        {
            $this->session()->flash(array(
                'danger' => 'Error de acceso, los datos ingresados son incorrectos'
            ));
            print "error";
            return $this->redirect('auth/login');
        }
       return $this->redirect('/');
    }

    public function doRegister()
    {
        require_once '../classes/Conexion.php';
        $db = Conexion::retornar();
        $request = $this->request;
        $rut = $request->rut;
        $nombre = $request->nombre;
        $pass = $request->password;
        $tipousuario = 1;
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
                ':tipousuario' => $tipousuario,
            ));
        if($insert)
        {
            return $this->redirect('/');
        }
        else
        {
            return $this->redirect('auth/registrarse');
        }       
    }

    public function logout()
	{
		unset($_SESSION['auth']);
		return $this->redirect('/');
	}
}
