<?php
use \Firebase\JWT\JWT;
class Middleware 
{
	public function login()
	{

		header('Access-Control-Allow-Origin: *');
		header("Content-Type: application/json; charset=utf-8");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Allow: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			http_response_code(200);
			die();
		}

		include_once '../controllers/config/core.php';
		include_once '../controllers/libs/php-jwt-master/src/BeforeValidException.php';
		include_once '../controllers/libs/php-jwt-master/src/ExpiredException.php';
		include_once '../controllers/libs/php-jwt-master/src/SignatureInvalidException.php';
		include_once '../controllers/libs/php-jwt-master/src/JWT.php';
		include_once '../controllers/config/database.php';

		$authHeader = apache_request_headers(); //en caso de que sea ubuntu el server.
		$authHeader = array_combine(array_map('ucwords', array_keys($authHeader)), array_values($authHeader));

		$arr = explode(" ", $authHeader['Authorization']);

		$jwt=$arr[1];
		if ($jwt) {
			try {
				// decode jwt
				$decoded = JWT::decode($jwt, $key, array('HS256'));

				http_response_code(200);
		 
				// show user details
				/*echo json_encode(array(
					"message" => "Access granted.",
					"data" => $decoded->data
				));*/
		 
			}
			catch (Exception $e){
		 
			// set response code
			http_response_code(401);
		 
			// tell the user access denied  & show error message
			echo json_encode(array(
				"message" => "Access denied.",
				"error" => $e->getMessage()
			));
			exit;
		   }
		}
		else
		{
			http_response_code(401);
			echo json_encode(array("message" => "Login failed."));
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