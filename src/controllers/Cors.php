<?php
//Todo: Archivode cors para permitir el llamado desde la aplicacion

//? Control de acceso
header("Access-Control-Allow-Origin: *");

//? Metodos especificados
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

//? Http Headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

//? Control de metodo OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Max-Age: 86400");
    exit(0);
}
?>