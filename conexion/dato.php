
<?php

define('BD_SERVIDOR', '127.0.0.1');
define('BD_NOMBRE', 'hpw');
define('BD_USUARIO', 'root');
define('BD_PASSWORD', '12345');
$db = new PDO("mysql:host=".BD_SERVIDOR.";dbname=".BD_NOMBRE.";charset=utf8",BD_USUARIO,BD_PASSWORD);
// $db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );   
/*
$connect = new PDO(
  "mysql:host=$host;dbname=$db", 
  $user, 
  $pass, 
  array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
  )
);
*/
?>