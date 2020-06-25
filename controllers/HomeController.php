<?php
require_once 'Controller.php';

class HomeController extends Controller
{
	public function __construct()
	{
		$this->middleware('login');
	}

	public function index()
	{

		$tipo = $_SESSION['auth']['tipo'];
		if($tipo == "1")
		{
			return $this->redirect('dashboard');
			
		}elseif($tipo == "2")
		{
			return $this->redirect('personal/navegar');
		}
		else
		{
			return $this->redirect('usuario/navegar');
		}

		
	}
}