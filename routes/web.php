<?php

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


/**
 * Auth routes
 */
Route::group(['namespace' => 'Auth'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    if (config('auth.users.registration')) {
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    }

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    // Confirmation Routes...
    if (config('auth.users.confirm_email')) {
        Route::get('confirm/{user_by_code}', 'ConfirmController@confirm')->name('confirm');
        Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
    }

    // Social Authentication Routes...
    Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
    Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    //Users
    Route::get('users/nuevo', 'UserController@create')->name('users.create');
    Route::post('users/nuevo', 'UserController@store')->name('users.store');
    Route::get('users/lista', 'UserController@lista')->name('users.lista');
    Route::get('users/lista/tabla', 'UserController@listaTabla')->name('users.lista.tabla');
    Route::get('users', 'UserController@index')->name('users');
    Route::get('users/{user}', 'UserController@show')->name('users.show');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
    Route::get('permissions', 'PermissionController@index')->name('permissions');
    Route::get('permissions/{user}/repeat', 'PermissionController@repeat')->name('permissions.repeat');
    Route::get('dashboard/log-chart', 'DashboardController@getLogChartData')->name('dashboard.log.chart');
    Route::get('dashboard/registration-chart', 'DashboardController@getRegistrationChartData')->name('dashboard.registration.chart');


    //Validaciones
    Route::post('validar/db', 'ValidarController@validarDB')->name('validar.db'); //Permite validar si un valor existe en la base de datos



    //Ingreso cliente nuevo
    Route::get('cliente/nuevo', 'ClienteController@nuevoForm')->name('cliente.nuevo');
    Route::post('cliente/nuevo', 'ClienteController@nuevoStore')->name('cliente.nuevo.store');

    //Listado de Clientes
    Route::get('cliente/lista', 'ClienteController@lista')->name('cliente.lista');
    Route::get('cliente/lista/tabla', 'ClienteController@listaTabla')->name('cliente.lista.tabla');

    //Listado de boletas
    Route::get('cliente/boleta/{id}', 'ClienteController@boleta')->name('cliente.boleta');
    Route::get('cliente/boleta/lista/{id}', 'ClienteController@boletaLista')->name('cliente.boleta.lista');

    //Editar cliente
    Route::get('cliente/editar', 'ClienteController@editarForm')->name('cliente.editar');
    Route::get('cliente/editar/{id}', 'ClienteController@editarForm')->name('cliente.editar');
    Route::post('cliente/editar/guardar', 'ClienteController@editarUpdate')->name('cliente.editar.update');

    //Eliminar cliente
    Route::get('cliente/eliminar/{id}', 'ClienteController@eliminar')->name('cliente.eliminar');

    //Habilitar cliente
    Route::get('cliente/habilitar/{id}', 'ClienteController@habilitar')->name('cliente.habilitar');

    //DesHabilitar cliente
    Route::get('cliente/deshabilitar/{id}', 'ClienteController@deshabilitar')->name('cliente.deshabilitar');

    //Detalle de cliente
    Route::post('cliente/detalle/', 'ClienteController@detalle')->name('cliente.detalle');

    //Detalle de proyectos
    Route::post('cliente/detalle/proyectos', 'ClienteController@detalleProyectos')->name('cliente.detalle.proyectos');


    //Ingreso medidor nuevo
    Route::get('medidor/nuevo', 'MedidorController@nuevoForm')->name('medidor.nuevo');
    Route::post('medidor/nuevo', 'MedidorController@nuevoStore')->name('medidor.nuevo.store');

    //Detalle de medidor
    Route::post('medidor/detalle/', 'MedidorController@detalle')->name('medidor.detalle');

    //Listado de medidores
    Route::get('medidor/lista', 'MedidorController@lista')->name('medidor.lista');
    Route::get('medidor/lista/tabla', 'MedidorController@listaTabla')->name('medidor.lista.tabla');
    Route::get('medidor/lista/auto', 'MedidorController@listadoAutocomplete')->name('medidor.lista.auto');



    //Editar medidor
    Route::get('medidor/editar', 'MedidorController@editarForm')->name('medidor.editar');
    Route::get('medidor/editar/{id}', 'MedidorController@editarForm')->name('medidor.editar');
    Route::post('medidor/editar/guardar', 'MedidorController@editarUpdate')->name('medidor.editar.update');


    //Ingreso cuenta nuevo
    Route::get('cuenta/nuevo', 'CuentaController@nuevoForm')->name('cuenta.nuevo');
    Route::post('cuenta/nuevo', 'CuentaController@nuevoStore')->name('cuenta.nuevo.store');
    Route::get('cuenta/lista/clientes/tabla', 'CuentaController@listaClientesTabla')->name('cuenta.lista.clientes.tabla');


    //Listado de cuentas
    Route::get('cuenta/lista', 'CuentaController@lista')->name('cuenta.lista');
    Route::get('cuenta/lista/tabla', 'CuentaController@listaTabla')->name('cuenta.lista.tabla');

    //Editar cuenta
    Route::get('cuenta/editar', 'CuentaController@editarForm')->name('cuenta.editar');
    Route::get('cuenta/editar/{id}', 'CuentaController@editarForm')->name('cuenta.editar');
    Route::post('cuenta/editar/guardar', 'CuentaController@editarUpdate')->name('cuenta.editar.update');

    //Listado de boletas
    Route::get('cuenta/boleta/{id}', 'CuentaController@boleta')->name('cuenta.boleta');
    Route::get('cuenta/boleta/lista/{id}', 'CuentaController@boletaLista')->name('cuenta.boleta.lista');

    //Listado de servicios
    Route::get('cuenta/servicio/{id}', 'CuentaController@servicio')->name('cuenta.servicio');
    Route::get('cuenta/servicio/lista/{id}', 'CuentaController@servicioLista')->name('cuenta.servicio.lista');


    // Habilitar Cuenta
    Route::get('cuenta/habilitar/{id}', 'CuentaController@habilitar')->name('cuenta.habilitar');

    // Suspender Cuenta
    Route::get('cuenta/suspender/{id}', 'CuentaController@suspender')->name('cuenta.suspender');

    // Cuenta
    Route::get('cuenta/estado/cambiar/{id}/{estado}', 'CuentaController@cambioEstado')->name('cuenta.estado.cambiar');



    //Retirar Cuenta
    Route::get('cuenta/retirar/{id}', 'CuentaController@retirar')->name('cuenta.retirar');

    //Ver historial de cuenta
    Route::get('cuenta/lista/historial', 'CuentaController@listaHistorial')->name('cuenta.lista.historial');

    //Ver boletas de cuenta
    Route::get('cuenta/lista/boletas', 'CuentaController@listaBoletas')->name('cuenta.lista.boletas');



    //Ingreso periodo nuevo
    Route::get('periodo/nuevo', 'PeriodoController@nuevoForm')->name('periodo.nuevo');
    Route::post('periodo/nuevo', 'PeriodoController@nuevoStore')->name('periodo.nuevo.store');

    //Listado de medidores
    Route::get('periodo/lista', 'PeriodoController@lista')->name('periodo.lista');
    Route::get('periodo/lista/tabla', 'PeriodoController@listaTabla')->name('periodo.lista.tabla');

    //Editar periodos
    Route::get('periodo/editar', 'PeriodoController@editarForm')->name('periodo.editar');
    Route::get('periodo/editar/{id}', 'PeriodoController@editarForm')->name('periodo.editar');
    Route::post('periodo/editar/guardar', 'PeriodoController@editarUpdate')->name('periodo.editar.update');

    //Listado de boletas
    Route::get('periodo/boleta/{id}', 'PeriodoController@boleta')->name('periodo.boleta');
    Route::get('periodo/boleta/lista/{id}', 'PeriodoController@boletaLista')->name('periodo.boleta.lista');


    // Activar periodo lectura
    Route::get('periodo/activar/lectura/{id}', 'PeriodoController@habilitarLectura')->name('periodo.activar.lectura');

    // Activar periodo
    Route::get('periodo/activar/facturacion/{id}', 'PeriodoController@habilitarFacturacion')->name('periodo.activar.facturacion');


    //Mantenedores
    Route::resource('cuentaestado', 'CRUD\CuentaEstadoController');
    Route::resource('estadopago', 'CRUD\EstadoPagoController');
    Route::resource('medidormodelo', 'CRUD\MedidorModeloController');
    Route::resource('proyecto', 'CRUD\ProyectoController');
    Route::resource('servicio', 'CRUD\ServicioController');



    //Ingreso lectura nuevo
    Route::get('lectura/ingresar', 'LecturaController@nuevoForm')->name('lectura.nuevo');
    Route::post('lectura/ingresar', 'LecturaController@nuevoStore')->name('lectura.nuevo.store');
    Route::post('lectura/periodo/detalle', 'LecturaController@detallePeriodo')->name('lectura.periodo.detalle');



    //Calculo manual periodo
    Route::get('periodo/facturar', 'PeriodoController@facturar')->name('periodo.facturar');//muestra el priodo y dá la opcion de calcular
    Route::post('periodo/facturar', 'PeriodoController@facturarGuardar')->name('periodo.facturar.guardar'); //crea las boletas

    //Ingresar recaudacion manual
    Route::get('reacaudacion/ingresar', 'RecaudacionController@nuevoForm')->name('recaudacion.nuevo'); // formulario para ingresar la recaudacion
    Route::post('reacaudacion/ingresar', 'RecaudacionController@nuevoForm')->name('recaudacion.nuevo.store'); //procesar el formulario de recaudacion


    //Informe de cuentas atrasadas
    Route::get('cobranza/lista', 'CobranzaController@lista')->name('cobranza.lista');
    Route::get('cobranza/lista/tabla', 'CobranzaController@listaTabla')->name('cobranza.lista.tabla');


});


Route::get('/', 'HomeController@index');

/**
 * Membership
 */
Route::group(['as' => 'protection.'], function () {
    Route::get('cliente/perfil', 'MembershipController@index')->name('cliente.perfil')->middleware('protection:' . config('protection.membership.product_module_number') . ',protection.membership.failed');
    Route::get('cliente/pagar', 'MembershipController@index')->name('cliente.pagar')->middleware('protection:' . config('protection.membership.product_module_number') . ',protection.membership.failed');
    Route::get('cliente/historial', 'MembershipController@index')->name('cliente.historial')->middleware('protection:' . config('protection.membership.product_module_number') . ',protection.membership.failed');



    Route::get('membership/access-denied', 'MembershipController@failed')->name('membership.failed');
    Route::get('membership/clear-cache/', 'MembershipController@clearValidationCache')->name('membership.clear_validation_cache');
});
