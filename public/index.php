<?php
session_start();
require_once '../classes/Router.php';
$router = new Router;


$router->get('', 'HomeController@index');
$router->get('uwu', 'AuthController@uwu');
$router->get('home', 'AuthController@home');
$router->get('auth/login', 'AuthController@login');
$router->get('auth/registrarse', 'AuthController@registrar');
$router->get('auth/logout', 'AuthController@logout');
$router->get('auth/registrarpersonal','UsuariosController@FormularioRegistrarPersonal');

$router->get('usuario/navegar', 'UsuariosController@navegar');
$router->get('personal/navegar', 'UsuariosController@navegarPersonal');

$router->get('gestionar', 'SolicitudesController@gestionar');
$router->get('ventas/vender', 'VentasController@solicitar');
$router->get('solicitudes/cuentas', 'VentasController@verCuentas');
$router->get('productos/ver', 'ProductosController@solicitar');
$router->get('productos/agregar','ProductosController@FormularioAgregar');


$router->post('auth/login', 'AuthController@doLogin');
$router->post('auth/registrar', 'UsuariosController@doRegister');
$router->post('productos/agregar','ProductosController@AgregarProducto');
$router->post('categorias/agregar','CategoriasController@AgregarCategoria');
$router->post('auth/registrarpersonal','UsuariosController@RegistrarPersonal');
$router->post('productos/registrarcompra','ProductosController@RegistrarCompra');
$router->get('productos/registrarventa','VentasController@RealizarVenta');


$router->response();