<?php

namespace Model;

class Usuario extends ActiveRecord{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido' ,'email','password', 'telefono','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }




     //* Mensajes de Alerta
     public function validarNuevaCuenta(){

        if(!$this->nombre) {
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if(!$this->apellido) {
            self::setAlerta('error', 'El apellido es obligatorio');
        }
        if(!$this->email) {
            self::setAlerta('error', 'El email es obligatorio');
        } 
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::setAlerta('error', 'El email no es válido');
        }

        if(!$this->telefono) {
            self::setAlerta('error', 'El telefono es obligatorio');
        }
        if (!preg_match('/^[0-9]{9}$/', $this->telefono)) {
            self::setAlerta('error', 'El telefono no es válido, debe ser de 9 dígitos');
        }
        if(!$this->password) {
            self::setAlerta('error', 'El password es obligatorio');
        }
        if(strlen($this->password) < 6) {
            self::setAlerta('error', 'El password debe tener al menos 6 caracteres');
        }



        return self::$alertas;
        
    }

    //* Verificar si el usuario ya existe
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        
        if($resultado->num_rows) {
            self::setAlerta('error', 'El usuario ya esta registrado');
        }

        return $resultado;
    }

    //* Hash de password
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //* Crear un token
    public function crearToken(){
        $this->token = bin2hex(random_bytes(16));
    }

    //* Verificar la autenticacion del usuario
    public function validarLogin(){
        if(!$this->email) {
            self::setAlerta('error', 'El email es obligatorio');
        }
        if(!$this->password) {
            self::setAlerta('error', 'El password es obligatorio');
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email) {
            self::setAlerta('error', 'El email es obligatorio');
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password) {
            self::setAlerta('error', 'El password es obligatorio');
        }
        if(strlen($this->password) < 6) {
            self::setAlerta('error', 'El password debe tener al menos 6 caracteres');
        }
        return self::$alertas;
    }


    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado){
            self::setAlerta('error', 'Password Incorrecto o tu cuenta no ha sido confirmada');
        } else {
            return true;
        }
    }
        
    


        



}