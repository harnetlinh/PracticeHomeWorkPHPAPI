<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once  './vendor/autoload.php' ; // require lib
include_once './config/Database.php';
include_once './Route/Route.php';
include_once './Model/User.php';
include_once './Controller/UserController.php';

error_reporting(E_ERROR | E_PARSE); //hiden warning



$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //load file .env
$dotenv->load();

$route = new Route();
$route->proccessRouting();


?>