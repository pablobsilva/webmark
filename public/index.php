<?php
session_start();
require_once '../classes/Router.php';
$router = new Router;


$router->get('', 'HomeController@index');
$router->get('auth/login', 'AuthController@login');
$router->get('auth/registrarse', 'AuthController@registrar');
$router->get('auth/logout', 'AuthController@logout');
$router->get('usuario/navegar', 'UsuariosController@navegar');
$router->post('auth/login', 'AuthController@doLogin');
$router->post('auth/registrar', 'AuthController@doRegister');



$router->get('gestionar', 'SolicitudesController@gestionar');

$router->get('solicitudes/venta', 'VentasController@solicitar');
$router->get('solicitudes/cuentas', 'VentasController@verCuentas');
$router->get('solicitudes/productos', 'ProductosController@solicitar');
$router->get('productos/agregar','ProductosController@agregar');


$router->response();