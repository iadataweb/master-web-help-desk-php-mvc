<?php 
    /* 
    * Archivo de Ejemplo de Configuración del Sistema
    * Renombrar este archivo a System.php y completar con sus valores reales
    */

    // Configuración de url base del Sistema Web
    const BASE_URL = "";

    // Configuración de Zona Horaria
    date_default_timezone_set('America/Lima');

    // Configuración de Conexión a Base de Datos
    const DB_HOST = "";      // Host de la base de datos (ej., localhost)
    const DB_NAME = "";      // Nombre de la base de datos
    const DB_USER = "";      // Usuario de la base de datos
    const DB_PASSWORD = "";  // Contraseña de la base de datos
    const DB_CHARSET = "";   // Charset de la base de datos (ej., utf8)

    // Configuración de Módulos del Sistema
    const MODULE_DASHBOARD = 1;
    const MODULE_USER_MANAGEMENT = 2;
    const MODULE_ROLE_MANAGEMENT = 3;
    const MODULE_TICKET_MANAGEMENT = 4;
    const MODULE_CATEGORY_MANAGEMENT = 5;
    const MODULE_SUBCATEGORY_MANAGEMENT = 6;
    const MODULE_PRIORITY_MANAGEMENT = 7;

    // Identificador del Usuario Super Administrador
    const USER_SUPER_ADMINISTRATOR = 1;

    // Roles del Sistema
    const ROLE_SUPER_ADMINISTRATOR = 1;
    const ROLE_ADMINISTRATOR = 2;
    const ROLE_SUPPORT = 3;
    const ROLE_END_USER = 4;
?>