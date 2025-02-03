<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{

    public static function index(Router $router){
        session_start();
        isAdmin();
        $servicios = Servicio::all();
        $nombre = $_SESSION['nombre'];
        $router-> render('servicios/index',[
            'nombre' => $nombre,
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router){
        session_start();
        isAdmin();
        $nombre = $_SESSION['nombre'];

        $servicio = new Servicio();
        $alertas = [];
      
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio -> sincronizar($_POST);
            $alertas = $servicio -> validar();
            if(empty($alertas)){
                $servicio -> guardar();
                header('Location: /servicios');
            }
        }
        $router-> render('servicios/crear',[
            'nombre' => $nombre,
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
        
    }

    public static function actualizar(Router $router){
        session_start();
        isAdmin();
        $nombre = $_SESSION['nombre'];
        $id = $_GET['id'];
        if(!validarORedireccionar($id)){
            header('Location: /servicios');
        };
        $servicio = Servicio::find($id);
        if(!$servicio){
            header('Location: /servicios');
        }

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio -> sincronizar($_POST);
            $alertas = $servicio -> validar();
            if(empty($alertas)){
                $servicio -> guardar();
                header('Location: /servicios');
            }
        }
        $router-> render('servicios/actualizar',[
            'nombre' => $nombre,
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){
        session_start();
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            if(!validarORedireccionar($id)){
                header('Location: /servicios');
            };
            $servicio = Servicio::find($id);
            if(!$servicio){
                header('Location: /servicios');
            }
            $servicio -> eliminar();
            header('Location: /servicios');
        }
    }
  
}