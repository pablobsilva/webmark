<?php
class Middleware 
{
	public function login()
	{
		if (!isset($_SESSION['auth']['rut'])) {
			Helper::redirect('home');
			exit;
		}
	}

	public function facturador()
	{
		if ($_SESSION['auth']['perfil'] != 2 && $_SESSION['auth']['perfil'] != 99) {
			Helper::redirect('/');
			exit;
		}
	}
}