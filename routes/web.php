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
    Route::get('users', 'UserController@index')->name('users');
    Route::get('users/{user}', 'UserController@show')->name('users.show');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
    Route::get('permissions', 'PermissionController@index')->name('permissions');
    Route::get('permissions/{user}/repeat', 'PermissionController@repeat')->name('permissions.repeat');
    Route::get('dashboard/log-chart', 'DashboardController@getLogChartData')->name('dashboard.log.chart');
    Route::get('dashboard/registration-chart', 'DashboardController@getRegistrationChartData')->name('dashboard.registration.chart');


    //Validaciones para cliente
    Route::post('cliente/validar/rut', 'ClienteController@validarRut')->name('cliente.validar.rut'); //Permite validar si un rut existe en la base de datos

    //Ingreso cliente nuevo
    Route::get('cliente/nuevo', 'ClienteController@nuevoForm')->name('cliente.nuevo');
    Route::post('cliente/nuevo', 'ClienteController@nuevoStore')->name('cliente.nuevo.store');

    //Listado de Clientes
    Route::get('cliente/lista', 'ClienteController@lista')->name('cliente.lista');
    Route::get('cliente/lista/tabla', 'ClienteController@listaTabla')->name('cliente.lista.tabla');

    //Editar cliente
    Route::get('cliente/editar', 'ClienteController@editarForm')->name('cliente.editar');
    Route::post('cliente/editar', 'ClienteController@editarUpdate')->name('cliente.editar.update');

    //Habilitar cliente
    Route::get('cliente/habilitar', 'ClienteController@habilitar')->name('cliente.habilitar');

    //DesHabilitar cliente
    Route::get('cliente/deshabilitar', 'ClienteController@deshabilitar')->name('cliente.deshabilitar');



    //Ingreso medidor nuevo
    Route::get('medidor/nuevo', 'MedidorController@nuevoForm')->name('medidor.nuevo');
    Route::post('medidor/nuevo', 'MedidorController@nuevoStore')->name('medidor.nuevo.store');

    //Listado de medidores
    Route::get('medidor/lista', 'MedidorController@lista')->name('medidor.lista');
    Route::get('medidor/lista/tabla', 'MedidorController@listaTabla')->name('medidor.lista.tabla');

    //Editar medidor
    Route::get('medidor/editar', 'MedidorController@editarForm')->name('medidor.editar');
    Route::post('medidor/editar', 'MedidorController@editarUpdate')->name('medidor.editar.update');



    //Ingreso cuenta nuevo
    Route::get('cuenta/nuevo', 'CuentaController@nuevoForm')->name('cuenta.nuevo');
    Route::post('cuenta/nuevo', 'CuentaController@nuevoStore')->name('cuenta.nuevo.store');

    //Listado de cuentas
    Route::get('cuenta/lista', 'CuentaController@lista')->name('cuenta.lista');
    Route::get('cuenta/lista/tabla', 'CuentaController@listaTabla')->name('cuenta.lista.tabla');

    // Habilitar Cuenta
    Route::get('cuenta/habilitar/{id}', 'CuentaController@habilitar')->name('cuenta.habilitar');

    // Suspender Cuenta
    Route::get('cuenta/suspender/{id}', 'CuentaController@suspender')->name('cuenta.suspender');

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

    // Activar periodo
    Route::get('periodo/activar/{id}', 'PeriodoController@habilitar')->name('periodo.activar');


    //Mantenedores
    Route::resource('cuentaestado', 'CRUD\CuentaEstadoController');
    Route::resource('estadopago', 'CRUD\EstadoPagoController');
    Route::resource('medidormodelo', 'CRUD\MedidorModeloController');
    Route::resource('proyecto', 'CRUD\ProyectoController');
    Route::resource('servicio', 'CRUD\ServicioController');



    //Ingreso lectura nuevo
    Route::get('lectura/ingresar', 'LecturaController@nuevoForm')->name('lectura.nuevo');

    //Calculo manual periodo
    Route::get('periodo/calcular', 'PeriodoController@calcular')->name('periodo.calcular');//muestra el priodo y dá la opcion de calcular
    Route::post('periodo/calcular', 'PeriodoController@calcularGuardar')->name('periodo.calcular.guardar'); //crea las boletas

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
    Route::get('membership', 'MembershipController@index')->name('membership')->middleware('protection:' . config('protection.membership.product_module_number') . ',protection.membership.failed');
    Route::get('membership/access-denied', 'MembershipController@failed')->name('membership.failed');
    Route::get('membership/clear-cache/', 'MembershipController@clearValidationCache')->name('membership.clear_validation_cache');
});

