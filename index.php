<?php
require 'vendor/autoload.php';
require 'librerias/xml.php';
require 'conexion/dato.php';


\Slim\Slim::registerAutoloader();   
$app = new \Slim\Slim();


$app->get('/', function () use ($app) {
    $cuerpo_de_respuesta = json_encode(
      array('mensaje' => 'Hola mundo')
    );
    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody($cuerpo_de_respuesta);
});

require 'rutas/gets.php';
require 'rutas/posts.php';
require 'rutas/puts.php';
require 'rutas/delete.php';



$app->run();

