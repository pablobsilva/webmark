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
		print_r($_SESSION['auth']);
		//exit;

		if($tipo == "1")
		{
			return $this->redirect('gestionar');
		}
		else
		{
			return $this->redirect('usuario/navegar');
		}

		
	}
}