<?php
session_start();
require_once '../classes/Router.php';
$router = new Router;


$router->get('', 'HomeController@index');
$router->get('auth/login', 'AuthController@login');
$router->get('auth/logout', 'AuthController@logout');
$router->post('auth/login', 'AuthController@doLogin');


$router->get('gestionar', 'SolicitudesController@gestionar');

$router->get('solicitudes/venta', 'VentasController@solicitar');
$router->get('solicitudes/cuentas', 'VentasController@verCuentas');
$router->get('solicitudes/productos', 'ProductosController@solicitar');


$router->response();