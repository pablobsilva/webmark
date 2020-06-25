<?php

require_once '../classes/Middleware.php';
require_once '../classes/Request.php';
require_once '../classes/Helper.php';
require_once '../classes/Conexion.php';
require_once '../classes/Session.php';

Class Controller 
{
    public $view;
    public $request;
    
    public function session()
	{
		return new Session;
	}

	protected function middleware($ejecutar)
	{
		$middleware = new Middleware;
		return $middleware->$ejecutar();
	}

	public function redirect($location)
	{
		print("<b>LOCATION: ".$location);
		return Helper::redirect($location);
	}
}