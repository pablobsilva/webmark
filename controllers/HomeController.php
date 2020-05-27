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
		return $this->redirect('gestionar');
	}
}