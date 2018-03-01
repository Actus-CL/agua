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
    Route::get('cliente/validar/rut', 'ClienteController@validarRut')->name('cliente.validar.rut');

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



Route::group(['as' => 'admin'], function () {
    /**
     *
     */


    Route::get('salida', 'BodegaController@salidaForm')->name('bodega.salida');
    Route::post('salida/cilindro/agregar', 'BodegaController@entradaCrear')->name('bodega.entrada.crear');
    Route::post('salida/cilindro/eliminar', 'BodegaController@entradaCrear')->name('bodega.entrada.crear');
    Route::post('salida', 'BodegaController@salida')->name('bodega.salida.crear');

    Route::get('inventario', 'BodegaController@formInventario')->name('bodega.inventario.create');
    Route::post('inventario/comenzar', 'BodegaController@comenzarInventario')->name('bodega.inventario.comenzar');
    Route::post('inventario/cilindro/agregar', 'BodegaController@inventario')->name('bodega.inventario.comenzar');
    Route::post('inventario/finalizar', 'BodegaController@finalizarInventario')->name('bodega.inventario.finalizar');
});