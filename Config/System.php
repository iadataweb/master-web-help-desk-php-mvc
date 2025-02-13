<?php 
	const BASE_URL = "http://localhost/master-web-help-desk-php-mvc";

	//Zona horaria
	date_default_timezone_set('America/Lima');

	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "help_desk";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "utf8";

	//MÓDULOS
	const MODULE_DASHBOARD = 1;
	const MODULE_USER_MANAGEMENT = 2;
	const MODULE_ROLE_MANAGEMENT = 3;
	const MODULE_TICKET_MANAGEMENT = 4;
	const MODULE_CATEGORY_MANAGEMENT = 5;
	const MODULE_SUBCATEGORY_MANAGEMENT = 6;
	const MODULE_PRIORITY_MANAGEMENT = 7;

	//USUARIO SUPER ADMINISTRADOR
	const USER_SUPER_ADMINISTRATOR = 1;

	//ROLES
	const ROLE_SUPER_ADMINISTRATOR = 1;
	const ROLE_ADMINISTRATOR = 2;
	const ROLE_SUPPORT = 3;
	const ROLE_END_USER = 4;

?>