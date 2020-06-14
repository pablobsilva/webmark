<?php
session_start();
require_once '../classes/Router.php';
$router = new Router;


$router->get('', 'HomeController@index');
$router->get('auth/login', 'AuthController@login');
$router->get('auth/registrarse', 'AuthController@registrar');
$router->get('auth/logout', 'AuthController@logout');
$router->get('usuario/navegar', 'UsuariosController@navegar');

$router->get('gestionar', 'SolicitudesController@gestionar');
$router->get('ventas/vender', 'VentasController@solicitar');
$router->get('solicitudes/cuentas', 'VentasController@verCuentas');
$router->get('productos/productosver', 'ProductosController@solicitar');
$router->get('productos/agregar','ProductosController@FormularioAgregar');

$router->post('auth/login', 'AuthController@doLogin');
$router->post('auth/registrar', 'UsuariosController@doRegister');
$router->post('productos/agregar','ProductosController@AgregarProducto');
$router->post('categorias/agregar','CategoriasController@AgregarCategoria');


$router->response();