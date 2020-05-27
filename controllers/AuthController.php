<?php 
include 'Controller.php';

class AuthController extends Controller
{
    public function login()
    {
        return $this->view->make('auth.login')
        ->render();
    }

    public function doLogin(){
        
        if($this->request->exists(array('usuario','password'))){
            require_once '../classes/Conexion.php';
            $db = Conexion::retornar();
            $usuarios = $db
            ->prepare('SELECT * FROM Usuario 
                WHERE usuario = :usuario 
                AND pass = :clave'
            );
            $usuarios->execute(array(
                ':usuario' => $this->request->usuario,
                ':clave'=> $this->request->password,
            ));
            $usuario = $usuarios->fetch();
            
            if($usuario){
                $_SESSION['auth']['id'] = $usuario->idUsuario;
                $_SESSION['auth']['nombre'] = $usuario->usuario;
                $_SESSION['auth']['rut'] = $usuario->Personal_Rut;
            }

        }else{
            $this->session()->flash(array(
                'danger' => 'Error de acceso, los datos ingresados son incorrectos'
            ));
            print "error";
            return $this->redirect('auth/login');
        }
       return $this->redirect('/');
    }

    public function logout()
	{
		unset($_SESSION['auth']);
		return $this->redirect('/');
	}
}
