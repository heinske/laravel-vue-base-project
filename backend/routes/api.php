<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

# Rotas públicas para auxílio no cadastro externo de novos usuários
Route::get('/cidade/buscarCidades/{id?}', 'CidadeController@getCidades');
Route::get('/cidade/buscarCidadesPorConferencia/{id?}', 'CidadeController@getCidadesPorConferencia');
Route::get('/cidade/buscarCidadesPorUsuario/{user_id?}', 'CidadeController@getCidadesPorUsuario');
Route::get('/estado/buscarEstados', 'EstadoController@getEstados');
Route::get('/estado/buscarEstadosPorUsuario/{user_id?}', 'EstadoController@getEstadosPorUsuario');
Route::get('/estado/buscarEstadosPorRegiao/{regiao?}', 'EstadoController@getEstadosPorRegiao');

# Rotas de autenticação e validação
Route::post('/auth', 'AuthController@auth');
Route::post('/auth/recuperarSenha', 'AuthController@recuperarSenha');
Route::post('/auth/alterarSenha', 'AuthController@alterarSenha');
Route::post('/auth/validarToken', 'AuthController@validarToken');
Route::post('/auth/refresh', 'AuthController@refresh');
Route::post('/auth/validarTokenEmail', 'AuthController@validarTokenEmail');

# Rotas privadas
Route::group(['middleware' => ['jwt.auth']], function () {

    Route::resource('/recurso','RecursoController');
  
    # Rotas de controle de perfis
    Route::post('/perfil/validar', 'PerfilController@validarRecurso');
    Route::get('/perfil/buscarPerfis', 'PerfilController@buscarPerfis');
    Route::get('/perfil/buscarPerfisInterno', 'PerfilController@buscarPerfisInterno');
    Route::post('/perfil/delete/{id}', 'PerfilController@destroy');
    Route::resource('/perfil', 'PerfilController');
        
    # Rotas de controle do usuário autenticado
    Route::get('/usuario/meusDados', 'UserController@meusDados');
    Route::put('/usuario/update/{id}', 'UserController@update');
    Route::post('/usuario/alterarMeusDados', 'UserController@alterarMeusDados');
    Route::post('/usuario/alterarMinhaSenha', 'UserController@alterarMinhaSenha');
    Route::resource('/usuario', 'UserController');
    Route::get('/usuario/excluir/{id}', 'UserController@excluir');
    Route::get('/usuario/suspender/{id}', 'UserController@suspender');
    Route::get('/usuario/ativar/{id}', 'UserController@ativar');

    Route::group(['middleware' => ['auth.permission']], function () {
      

    });
});