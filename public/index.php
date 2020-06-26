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
$router->get('productos/comprar', 'ProductosController@comprar'); //vista para registrar productos en el sistema
$router->get('solicitudes/cuentas', 'VentasController@verCuentas'); //ruta para ver las cuentas de ventas
$router->get('productos/agregar','ProductosController@FormularioAgregar'); //endpoint para agregar el producto

$router->post('productos/editar','ProductosController@productoPorId'); //sacar la informacion del producto para el formulario editar
$router->post('productos/update','ProductosController@EditarProducto');//endpoint para hacer el update al producto
$router->post('productos/eliminar','ProductosController@EliminarProducto'); // eliminar el producto
$router->post('productos/codigodebarra','ProductosController@ProductoPorCodigoBarra'); //obtener información segun el codigo de barra del producto


$router->post('auth/login', 'AuthController@doLogin'); //logear en el sistema
$router->post('auth/registrar', 'UsuariosController@doRegister');//accion de registrarse
$router->post('productos/agregar','ProductosController@AgregarProducto');//agregar un producto al sistema
$router->post('categorias/agregar','CategoriasController@AgregarCategoria');
$router->post('auth/registrarpersonal','UsuariosController@RegistrarPersonal'); //registrar un personal dentro de la empresa registrada
$router->post('productos/registrarcompra','ProductosController@RegistrarCompra');// accion de registrar una compra de productos de la empresa
$router->get('productos/registrarventa','VentasController@VerCuentaDiaria');// accion de registrar una venta de la empresa




$router->response();