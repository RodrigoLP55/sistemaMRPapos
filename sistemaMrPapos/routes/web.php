<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/index', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




/*
|--------------------------------------------------------------------------
| COMIENZA LA SECCION DE LAS RUTAS UTILIZADAS                              
|--------------------------------------------------------------------------
*/


/*--------------------------------CALZADO-------------------------------- */
/**Mostrar calzado */
Route::get('/auth/Calzado/calzadoList', [App\Http\Controllers\CalzadoController::class, 'getCalzados'])->name('calzadoList'); 

/**Mostrar calzado de NIÑO*/
Route::get('/auth/Calzado/calzadoNinio', [App\Http\Controllers\CalzadoController::class, 'getCalzadosNinio'])->name('calzadoNinio');
/**Mostrar calzado de NIÑA*/
Route::get('/auth/Calzado/calzadoNinia', [App\Http\Controllers\CalzadoController::class, 'getCalzadosNinia'])->name('calzadoNinia');
/**Mostrar calzado de CABALLERO*/
Route::get('/auth/Calzado/calzadoCaballero', [App\Http\Controllers\CalzadoController::class, 'getCalzadosCaba'])->name('calzadoCaba');
/**Mostrar calzado de DAMA*/
Route::get('/auth/Calzado/calzadoDama', [App\Http\Controllers\CalzadoController::class, 'getCalzadosDama'])->name('calzadoDama');
/**Buscar Calzado*/
Route::post('/auth/Calzado/calzadobuscado', [App\Http\Controllers\CalzadoController::class, 'getCalzadosBuscado'])->name('calzadoBusc');

/**Formulario Calzado*/
Route::get('/auth/Calzado/nuevoProductos', [App\Http\Controllers\CalzadoController::class, 'setForm'])->name('vistaFormuCalzado');

/**Crear nuevo calzado*/
Route::post('/auth/Calzado/guardar', [App\Http\Controllers\CalzadoController::class, 'createCalzado'])->name('addCalzado');

/**Continuar para reabastecer */
/*confirmacion */
Route::get('/auth/Calzado/NuevoCalzado/continuarReabastecer', [App\Http\Controllers\ConfirmacionController::class, 'reabastecerOCancelar'])->name('reabastecerOCancel');

Route::get('/auth/Calzado/nuevoCalzado/reabastecerCalzado', [App\Http\Controllers\CalzadoController::class, 'continuarReabastecer'])->name('continuarR');
/*cancelar */
Route::get('/auth/Calzado/nuevoCalzado/cancelar', [App\Http\Controllers\ConfirmacionController::class, 'cancelarReabastecerCalzado'])->name('cancelarRCalzado');


/** ---------Eliminar calzado------------- */
/*confirmacion */
Route::get('/auth/Calzado/calzadoListDelete/{id_calzado}/confirmar', [App\Http\Controllers\ConfirmacionController::class, 'confirmarCalzado'])->name('confirmarECalzado');
/*eliminar */
Route::get('/auth/Calzado/calzadoList/{id_calzado}/delete', [App\Http\Controllers\CalzadoController::class, 'deleteCalzado'])->name('eliminarCalzado');
/*cancelar */
Route::get('/auth/Calzado/calzadoList/cancelar', [App\Http\Controllers\ConfirmacionController::class, 'cancelarECalzado'])->name('cancelarECalzado');

/**Editar Clazado */
Route::get('/auth/Calzado/calzadoList/{id_calzado}/edit', [App\Http\Controllers\CalzadoController::class, 'editCalzado'])->name('editarCalzado');

Route::put('/auth/Calzado/calzadoList/{id_calzado}', [App\Http\Controllers\CalzadoController::class, 'updateCalzado'])->name('actualizarCalzado');

/**Mostrar Clazado */
Route::get('/auth/Calzado/calzadoList/{calzado}', [App\Http\Controllers\CalzadoController::class, 'show'])->name('detallesCalzado');

/**CREAR NUEVO COLOR */
/**Formulario Color*/
Route::get('/auth/Color/nuevoColor', [App\Http\Controllers\ColorController::class, 'viewFormColor'])->name('formColor');
/**Crear Color */
Route::post('/auth/Color/guardar', [App\Http\Controllers\ColorController::class, 'createColor'])->name('addColor');

//oute::get('/Calzado/productos', [App\Http\Controllers\CalzadoController::class, 'viewProductos'])->name('vistaFormuCalzado');



/*--------------------------------MODULO DE REABASTECIMIENTO-------------------------------- */
/**Mostrar calzado */
Route::get('/auth/Calzado/calzadoListReabastecer', [App\Http\Controllers\CalzadoController::class, 'getCalzadosReabastecer'])->name('calzadoListReabastecer'); 

/**Mostrar calzado de NIÑO*/
Route::get('/auth/Calzado/calzadoNinioReabastecer', [App\Http\Controllers\CalzadoController::class, 'getCalzadosNinioReabastecer'])->name('calzadoNinioReabastecer');
/**Mostrar calzado de NIÑA*/
Route::get('/auth/Calzado/calzadoNiniaReabastecer', [App\Http\Controllers\CalzadoController::class, 'getCalzadosNiniaReabastecer'])->name('calzadoNiniaReabastecer');
/**Mostrar calzado de CABALLERO*/
Route::get('/auth/Calzado/calzadoCaballeroReabastecer', [App\Http\Controllers\CalzadoController::class, 'getCalzadosCabaReabastecer'])->name('calzadoCabaReabastecer');
/**Mostrar calzado de DAMA*/
Route::get('/auth/Calzado/calzadoDamaReabastecer', [App\Http\Controllers\CalzadoController::class, 'getCalzadosDamaReabastecer'])->name('calzadoDamaReabastecer');
/**Buscar Calzado*/
Route::post('/auth/Calzado/calzadobuscadoReabastecer', [App\Http\Controllers\CalzadoController::class, 'getCalzadosBuscadoReabastecer'])->name('calzadoBuscReabastecer');


/**Formulario Reabastecer*/
Route::get('/auth/Calzado/calzadoListReabastecer/{id_calzado}/reabasteciendo', [App\Http\Controllers\CalzadoController::class, 'setFormReabastecer'])->name('formReabastecer');


/**Reabastecer calzado*/
Route::put('/auth/Calzado/calzadoNuevoListReabastecerComplete/{id_calzado}/{id_tipo_c}', [App\Http\Controllers\CalzadoController::class, 'reabastecerCalzado'])->name('reabastecerCalzado');

/**Reabastecer calzado Nuevo*/
Route::put('/auth/Calzado/calzadoListReabastecerComplete/{id_calzado}/{id_tipo_c}', [App\Http\Controllers\CalzadoController::class, 'reabastecerCalzadoNuevo'])->name('reabastecerCalzadoNuevo');


/*--------------------------------USUARIOS-------------------------------- */
Route::get('/auth/Users/profile', [App\Http\Controllers\UserCompleteController::class, 'viewProfile'])->name('perfilUsuario');
Route::get('/auth/Users', [App\Http\Controllers\UserCompleteController::class, 'userWhithTel'])->name('usuariosList');
Route::get('/users/formulario', [App\Http\Controllers\DireccionController::class, 'view'])->name('vistaFormu');

Route::post('/users', [App\Http\Controllers\UserCompleteController::class, 'createUser'])->name('regUser');

/*--------------------------------PROVEEDORES-------------------------------- */
Route::post('/regProveedores', [App\Http\Controllers\ProveedorController::class, 'createProveedor'])->name('regProveedor');

Route::get('/proveedores', [App\Http\Controllers\ProveedorController::class, 'getProveedores'])->name('obtenerProveedores');
Route::get('/registrarProveedor', [App\Http\Controllers\ProveedorController::class, 'viewFormuProveedores'])->name('formularioProveedores');




/*--------------------------------VENTA-------------------------------- */
/**Mostrar ventas */
Route::get('/auth/Ventas/ventas', [App\Http\Controllers\VentaController::class, 'getVentas'])->name('listVentas'); 

/**Primer Formulario Ventas*/
Route::get('/auth/Venta/comenzar', [App\Http\Controllers\VentaController::class, 'setFormVenta'])->name('inicioVenta');

/**Crear nuevA VENTA*/
Route::post('/auth/Venta/guardar', [App\Http\Controllers\VentaController::class, 'createVenta'])->name('inicventa');

/**LISTAR PRODUCTOS PARA AGREGAR A VENTA */
Route::get('/auth/Venta/calzadoList', [App\Http\Controllers\VentaController::class, 'getCalzados'])->name('calzadoListV'); 

/**Mostrar calzado de NIÑO*/
Route::get('/auth/Venta/calzadoNinio', [App\Http\Controllers\VentaController::class, 'getCalzadosNinio'])->name('calzadoNinioV');
/**Mostrar calzado de NIÑA*/
Route::get('/auth/Venta/calzadoNinia', [App\Http\Controllers\VentaController::class, 'getCalzadosNinia'])->name('calzadoNiniaV');
/**Mostrar calzado de CABALLERO*/
Route::get('/auth/Venta/calzadoCaballero', [App\Http\Controllers\VentaController::class, 'getCalzadosCaba'])->name('calzadoCabaV');
/**Mostrar calzado de DAMA*/
Route::get('/auth/Venta/calzadoDama', [App\Http\Controllers\VentaController::class, 'getCalzadosDama'])->name('calzadoDamaV');
/**Buscar Calzado*/
Route::post('/auth/Venta/calzadobuscado', [App\Http\Controllers\VentaController::class, 'getCalzadosBuscado'])->name('calzadoBuscV');

/**Escoger Clazado */
Route::get('/auth/Venta/escogerCalzado/{calzado}', [App\Http\Controllers\VentaController::class, 'showCalzadoV'])->name('escogeCalzado');

//Crear detalle de venta
Route::post('/auth/Venta/agregardetalle', [App\Http\Controllers\VentaController::class, 'createDetalleVenta'])->name('addDetalleVenta');

/**COMPLETAR VENTA*/
Route::get('/auth/Venta/calzadoListC', [App\Http\Controllers\VentaController::class, 'completeVenta'])->name('completarVenta');

//DERTALLES DE VENTA
Route::get('/auth/Venta/detallesVenta/{venta}', [App\Http\Controllers\VentaController::class, 'showVenta'])->name('detallesVent');



/*--------------------------------PEDIDO-------------------------------- */
/**Mostrar ventas */
Route::get('/auth/Pedido/pedidos', [App\Http\Controllers\PedidoController::class, 'getPedidos'])->name('listPedidos'); 

/**Primer Formulario Ventas*/
Route::get('/auth/Pedido/comenzar', [App\Http\Controllers\PedidoController::class, 'setFormPedido'])->name('inicioPedido');

/**Crear nuevA VENTA*/
Route::post('/auth/Pedido/guardar', [App\Http\Controllers\PedidoController::class, 'createPedido'])->name('inicPedido');

/**LISTAR PRODUCTOS PARA AGREGAR A VENTA */
Route::get('/auth/Pedido/calzadoList', [App\Http\Controllers\PedidoController::class, 'getCalzadosP'])->name('calzadoListP'); 

/**Mostrar calzado de NIÑO*/
Route::get('/auth/Pedido/calzadoNinio', [App\Http\Controllers\PedidoController::class, 'getCalzadosNinio'])->name('calzadoNinioP');
/**Mostrar calzado de NIÑA*/
Route::get('/auth/Pedido/calzadoNinia', [App\Http\Controllers\PedidoController::class, 'getCalzadosNinia'])->name('calzadoNiniaP');
/**Mostrar calzado de CABALLERO*/
Route::get('/auth/Pedido/calzadoCaballero', [App\Http\Controllers\PedidoController::class, 'getCalzadosCaba'])->name('calzadoCabaP');
/**Mostrar calzado de DAMA*/
Route::get('/auth/Pedido/calzadoDama', [App\Http\Controllers\PedidoController::class, 'getCalzadosDama'])->name('calzadoDamaP');
/**Buscar Calzado*/
Route::post('/auth/Pedido/calzadobuscado', [App\Http\Controllers\PedidoController::class, 'getCalzadosBuscado'])->name('calzadoBuscP');

/**Escoger Clazado */
Route::get('/auth/Pedido/escogerCalzado/{calzado}', [App\Http\Controllers\PedidoController::class, 'showCalzadoP'])->name('escogeCalzadoP');

//Crear detalle de venta
Route::post('/auth/Pedido/agregardetalle', [App\Http\Controllers\PedidoController::class, 'createDetallePedido'])->name('addDetallePedido');

/**COMPLETAR VENTA*/
Route::get('/auth/Pedido/calzadoListC', [App\Http\Controllers\PedidoController::class, 'completePedido'])->name('completarPedido');

//DERTALLES DE VENTA
Route::get('/auth/Pedido/detallesPedido/{pedido}', [App\Http\Controllers\PedidoController::class, 'showPedido'])->name('detallesPedido');