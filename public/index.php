<?php
session_start();
require_once '../classes/Router.php';
$router = new Router;


$router->get('', 'HomeController@index'); //redirecciona al dashboard si hay sesión, sino al login para iniciar
$router->get('uwu', 'AuthController@uwu');
$router->get('home', 'AuthController@home'); //redireccione al home principal
$router->get('auth/login', 'AuthController@login'); // para logear
$router->get('auth/registrarse', 'AuthController@registrar'); // para registrarse
$router->get('auth/logout', 'AuthController@logout'); // cerrar sesión 
$router->get('auth/registrarpersonal','UsuariosController@FormularioRegistrarPersonal'); // formulario para registrar al personal

$router->get('usuario/navegar', 'UsuariosController@navegar');
$router->get('personal/navegar', 'UsuariosController@navegarPersonal');
$router->get('dashboard', 'UsuariosController@indexAdmin'); // dashboard admin 
$router->get('productos', 'ProductosController@productos'); // ver todos los productos

$router->get('gestionar', 'SolicitudesController@gestionar');
$router->get('productos/comprar', 'ProductosController@comprar');
$router->get('solicitudes/cuentas', 'VentasController@verCuentas');
$router->get('productos/ver', 'ProductosController@solicitar');
$router->get('productos/agregar','ProductosController@FormularioAgregar');

$router->post('productos/editar','ProductosController@productoPorId');
$router->post('productos/update','ProductosController@EditarProducto');
$router->post('productos/eliminar','ProductosController@EliminarProducto');
$router->post('productos/codigodebarra','ProductosController@ProductoPorCodigoBarra');


$router->post('auth/login', 'AuthController@doLogin');
$router->post('auth/registrar', 'UsuariosController@doRegister');
$router->post('productos/agregar','ProductosController@AgregarProducto');
$router->post('categorias/agregar','CategoriasController@AgregarCategoria');
$router->post('auth/registrarpersonal','UsuariosController@RegistrarPersonal');
$router->post('productos/registrarcompra','ProductosController@RegistrarCompra');
$router->post('auth/registrar','VentasController@VerVentas');
$router->get('productos/registrarventa','VentasController@VerCuentaDiaria');
$router->get('productos/registrarcompra','ProductosController@RegistrarCompra');




$router->response();