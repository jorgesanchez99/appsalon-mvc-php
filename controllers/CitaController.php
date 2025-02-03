<?php

namespace Controllers;

use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {
        session_start();
        
        $nombre = $_SESSION['nombre'] ?? null;
        $id = $_SESSION['id'] ?? null;
        isAuth();

        $router->render('cita/index',[
            'nombre' => $nombre,
            'id' => $id
        ]);
    }
}