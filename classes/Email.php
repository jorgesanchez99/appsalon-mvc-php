<?php

namespace Classes;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // Crear el objeto de PHPMailer    
        $mail = new PHPMailer();
    
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = $_ENV['EMAIL_HOST'];
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
    
            // Remitente y destinatario
            $mail->setFrom('cuentas@appsalon.com', 'AppSalon');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com'); // Asegúrate de que el correo sea válido
    
            // Asunto del correo
            $mail->Subject = 'Confirma tu cuenta';
    
            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
    
            // Contenido del correo
            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . htmlspecialchars($this->email) . "</strong>, has creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace:</p>";
            $contenido .= "<p>Presiona aquí: <a href='".$_ENV['APP_URL']."/confirmar-cuenta?token=" . urlencode($this->token) . "'>Confirmar cuenta</a></p>";
            $contenido .= "<p>Si tú no creaste esta cuenta, ignora este mensaje.</p>";
            $contenido .= "</html>";
            $mail->Body = $contenido;
    
            // Enviar el email
            if (!$mail->send()) {
                throw new Exception("Error al enviar el correo: " . $mail->ErrorInfo);
            }
    
    
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: " . $e->getMessage();
        }
    }

    public function enviarInstrucciones()
    {

        // Crear el objeto de PHPMailer    
        $mail = new PHPMailer();

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '338aee6210d2aa';
            $mail->Password = '2124c8dd8229d8';
    
            // Remitente y destinatario
            $mail->setFrom('cuentas@appsalon.com', 'AppSalon');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com'); // Asegúrate de que el correo sea válido
    
            // Asunto del correo
            $mail->Subject = 'Reestablecer contraseña';
    
            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
    
            // Contenido del correo
            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . htmlspecialchars($this->nombre) . "</strong>. Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo:</p>";
            $contenido .= "<p>Presiona aquí: <a href='".$_ENV['APP_URL']."/confirmar-cuenta?token=" . urlencode($this->token) . "'>Reestablecer contraseña</a></p>";
            $contenido .= "<p>Si no solicitaste este cambio, ignora este mensaje.</p>";
            $contenido .= "</html>";
            $mail->Body = $contenido;
    
            // Enviar el email
            if (!$mail->send()) {
                throw new Exception("Error al enviar el correo: " . $mail->ErrorInfo);
            }
    
    
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: " . $e->getMessage();
        }

    }

}