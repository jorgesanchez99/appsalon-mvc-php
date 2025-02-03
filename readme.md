# App Salon PHP MVC JS SASS

Este es un proyecto de una aplicación de salón de belleza desarrollado con PHP 8, utilizando el patrón de diseño MVC, SASS para estilos y Gulp para la automatización de tareas.

## Características

- **PHP 8**: Utilizado para la lógica del servidor.
- **MVC**: Patrón de diseño Modelo-Vista-Controlador para una mejor organización del código.
- **SASS**: Preprocesador CSS para escribir estilos más eficientes y mantenibles.
- **Gulp**: Herramienta de automatización de tareas para compilar SASS, minificar archivos, etc.
- **JavaScript**: Utilizado para la interacción en el lado del cliente.
- **PHPMailer**: Librería para el envío de correos electrónicos.
- **dotenv**: Manejo de variables de entorno.


## Instalación

1. Clona el repositorio:
    ```sh
    git clone https://github.com/jorgesanchez99/appsalon-mvc-php.git
    ```

2. Navega al directorio del proyecto:
    ```sh
    cd appsalon-mvc-php
    ```

3. Instala las dependencias de Composer:
    ```sh
    composer install
    ```

4. Instala las dependencias de npm:
    ```sh
    npm install
    ```

5. Configura las variables de entorno en el archivo `.env`, puedes crearlo en la carpeta `includes`.


6. Compila los archivos SASS y JavaScript:
    ```sh
    npm run dev
    ```

## Uso

- Para iniciar el servidor, puedes usar el servidor embebido de PHP:
    ```sh
    php -S localhost:3000
    ```

- Accede a la aplicación en tu navegador:
    ```
    http://localhost:3000
    ```

