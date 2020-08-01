<?php
session_start();
require_once '../classes/Router.php';
$router = Router::getInstance();

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
$router->get('categorias', 'CategoriasController@Categorias');
$router->get('productos/registrarventa','VentasController@VerCuentaDiaria');// accion de registrar una venta de la empresa

$router->post('productos/editar','ProductosController@productoPorId'); //sacar la informacion del producto para el formulario editar
$router->post('productos/update','ProductosController@EditarProducto');//endpoint para hacer el update al producto
$router->post('productos/eliminar','ProductosController@EliminarProducto'); // eliminar el producto
$router->post('productos/codigodebarra','ProductosController@ProductoPorCodigoBarra'); //obtener información segun el codigo de barra del producto

$router->post('auth/login', 'AuthController@doLogin'); //logear en el sistema
$router->post('auth/registrar', 'AuthController@doRegister');//accion de registrarse
$router->post('auth/token', 'AuthController@validate_token');
$router->post('productos/agregar','ProductosController@AgregarProducto');//agregar un producto al sistema
$router->post('categorias/agregar','CategoriasController@AgregarCategoria');
$router->post('auth/registrarpersonal','UsuariosController@RegistrarPersonal'); //registrar un personal dentro de la empresa registrada
$router->post('productos/registrarcompra','ProductosController@RegistrarCompra');// accion de registrar una compra de productos de la empresa

$router->options('auth/login', 'AuthController@doLogin');
$router->options('auth/registrar', 'AuthController@doRegister');
$router->options('categorias', 'CategoriasController@Categorias');
$router->options('productos', 'ProductosController@productos');
$router->options('productos/agregar', 'CategoriasController@Categorias');
$router->options('producto', 'ProductosController@ProductoPorId');
$router->options('productos/update','ProductosController@EditarProducto');
$router->options('productos/eliminar','ProductosController@EliminarProducto');
$router->options('productos/codigodebarra','ProductosController@ProductoPorCodigoBarra');
$router->options('empresa/crear','UsuariosController@updateEmpresa');
$router->options('personal/agregar','UsuariosController@agregarPersonal');
$router->options('personal/obtener','UsuariosController@personalPorRut');
$router->options('personal/ver','UsuariosController@verpersonal');
$router->options('personal/update','UsuariosController@updatePersonal');
$router->options('personal/eliminar','UsuariosController@deletePersonal');
$router->options('ventas/registrar','VentasController@RealizarVenta');
$router->options('ventas/ver','VentasController@VerVentas');
$router->options('ventas/eliminar','VentasController@eliminarVenta');
$router->options('ventas/verdetalles','VentasController@ventaPorId');
$router->options('ventas/dia','VentasController@VerVentasDelDia');
$router->options('compras/registrar','ComprasController@RegistrarCompra');
$router->options('compras/ver','ComprasController@VerCompras');
$router->options('compras/verdetalles','ComprasController@compraPorId');
$router->options('compras/eliminar','ComprasController@eliminarcompra');
$router->options('compras/dia','ComprasController@VerComprasDelDia');
$router->options('distribuidores/ver','SolicitudesController@verDistribuidores');
$router->options('compras/eliminar','ComprasController@eliminarcompra');
$router->options('empresa/check','UsuariosController@empresaCheck');
$router->options('ventas/excell','SolicitudesController@empresaCheck');
$router->options('empresa','UsuariosController@empresaPorRut');
$router->options('empresa/sumarlike','UsuariosController@sumarLikes');
$router->options('empresa/verlikes','UsuariosController@verLikes');
$router->options('publicidad/empresas','UsuariosController@verEmpresas');
$router->options('datediff','ProductosController@datediff');
$router->options('pagos/registrar','SolicitudesController@RegistrarPago');
$router->options('productos/porvencer','ProductosController@AvisoVencimiento');
$router->options('personal/ventas','VentasController@ventasPorTrabajador');
$router->options('pagos/diario','SolicitudesController@verPagosDia');

$router->post('productos', 'ProductosController@productos');
$router->post('producto', 'ProductosController@ProductoPorId');
$router->post('productos/porvencer','ProductosController@AvisoVencimiento');
$router->post('empresa/crear','UsuariosController@updateEmpresa');
$router->post('personal/obtener','UsuariosController@personalPorRut');
$router->post('personal/ver','UsuariosController@verpersonal');
$router->post('personal/update','UsuariosController@updatePersonal');
$router->post('personal/eliminar','UsuariosController@deletePersonal');
$router->post('personal/agregar','UsuariosController@agregarPersonal');
$router->post('personal/ventas','VentasController@ventasPorTrabajador');
$router->post('ventas/registrar','VentasController@RealizarVenta');
$router->post('ventas/ver','VentasController@VerVentas');
$router->post('ventas/eliminar','VentasController@eliminarVenta');
$router->post('ventas/verdetalles','VentasController@ventaPorId');
$router->post('ventas/dia','VentasController@VerVentasDelDia');
$router->post('ventas/excell','SolicitudesController@exportExcel');
$router->post('compras/registrar','ComprasController@RegistrarCompra');
$router->post('compras/ver','ComprasController@VerCompras');
$router->post('compras/verdetalles','ComprasController@verCompraPorId');
$router->post('compras/eliminar','ComprasController@eliminarcompra');
$router->post('compras/dia','ComprasController@VerComprasDelDia');
$router->post('distribuidores/ver','SolicitudesController@verDistribuidores');
$router->post('deconexion','AuthController@registrarDesconexion');
$router->post('empresa/check','UsuariosController@empresaCheck');
$router->post('empresa/sumarlike','UsuariosController@sumarLikes');
$router->post('empresa/verlikes','UsuariosController@verLikes');
$router->post('empresa','UsuariosController@empresaPorRut');
$router->post('datediff','ProductosController@datediff');
$router->post('pagos/registrar','SolicitudesController@RegistrarPago');
$router->post('pagos/diario','SolicitudesController@verPagosDia');
$router->post('publicidad/empresas','UsuariosController@verEmpresas');




$router->response();
