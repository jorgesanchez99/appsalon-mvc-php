<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        session_start();
        if(isset($_SESSION['login'])) {
            if($_SESSION['admin'] === '1') {
                header('Location: /dashboard');
            }else{
                header('Location: /cita');
            }
        }

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas= $auth->validarLogin();
            if(empty($alertas)){
                //* Verificar si el usuario existe
                $usuario = Usuario::findPor('email', $auth->email);
                if($usuario) {
                    //* Verificar si el password es correcto
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //* Autenticar el usuario
                        session_start();
                        $_SESSION['id'] = $usuario->id;   
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;  
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //* Redireccionar
                        if($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /dashboard');
                        }else{
                            header('Location: /cita');
                        }
                        
                    }
                }else{
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas' => $alertas
        ]);
    }
    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router)
    {
        $alertas=[];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth -> validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::findPor('email', $auth->email);
                if($usuario && $usuario->confirmado === '1') {
                    //* Crear un token
                    $usuario->crearToken();
                    //* Guardar el token en la base de datos
                    $usuario->guardar();
                    //* alerta Exito
                    Usuario::setAlerta('exito', 'Se ha enviado un email a tu cuenta para recuperar tu password');
                    //* Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    //* Redireccionar
                    // header('Location: /mensaje');
                }else{
                    Usuario::setAlerta('error', 'El email no existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router-> render('auth/olvide-password',[
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas =[];
        $error = false;
        $token = s($_GET['token']) ?? null;
        if(empty($token)) {
            header('Location: /');
        }
        //* Buscar usuario por su token
        $usuario = Usuario::findPor('token', $token);
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            if(empty($alertas)) {
                $usuario -> password = null;
                $usuario -> password = $password->password;
                //* Guardar el nuevo password
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router -> render('auth/recuperar-password',[
            'alertas'=> $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario(); 
        // $alertas = Usuario::getAlertas();
        $alertas =[];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)) {
                //* Verificar si el usuario ya existe
                $resultado = $usuario -> existeUsuario();
                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                }else{
                    //* Crear la cuenta
                    $usuario->hashPassword();
                    //*Generar un token unico
                    $usuario->crearToken();

                    //* Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarConfirmacion();

                    //* Guardar el usuario en la base de datos
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        //* Redireccionar
                        header('Location: /mensaje');
                    }


                }
            }

        }
        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token  = s($_GET['token']) ?? null;
        $usuario = Usuario::findPor('token', $token);
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
        }else{
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada, ya puedes iniciar sesión');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta',[
            'alertas'=> $alertas]);
    }
   
}   
