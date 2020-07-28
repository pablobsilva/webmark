<?php 
class Request
{
	public $atributos;

	public function capture($metodo)
	{
		switch (strtoupper($metodo)) {
			case 'GET':
				$this->atributos = $_GET;
				break;
			case 'POST':
				$this->atributos = $_POST;
				break;
			case 'OPTIONS':
				http_response_code(200);
				die();	
		}
	}

	public function __get($nombre)
	{
		if (isset($this->atributos[$nombre])) {
			return $this->atributos[$nombre];
		} else {
			return null;
		}
	}

	public function exists($name)
	{
		if (is_string($name)) {
			return array_key_exists($name, $this->atributos);
		} else if (is_array($name)) {
			foreach ($name as $value) {
				if (!array_key_exists($value, $this->atributos)) return false;
			}
		}
		return true;
	}
}