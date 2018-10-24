<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
$app->get('/empresas/:id/empresa', function($id)use($app, $db){
  
  $res = $app->response;
  $req = $app->request;
   $sql = $db->prepare("select  id, nom_estab,codigo_act from Empresa  where id = ".$id);
  
 $sql->execute();
   
   
  $datos = $sql->fetchAll(PDO::FETCH_ASSOC);

   $contenido="";//$req->headers->get('Accept');
     $res->status(406);
   if ($req->headers->get('Accept')==='application/json') 
  {
   $contenido = json_encode($datos);
   $res->status(200);
   $res->headers->set('Content-type', 'application/json');
  }
  elseif ($req->headers->get('Accept')==='application/xml')
   {
   $xml = new SimpleXMLElement('<Actividades/>');
    toXml($datos, $xml);
    $contenido = $xml->asXML();
    $res->headers->set('Content-type', 'application/xml');
  }
  $res->setBody($contenido);
});


$app->get('/empresas/:id/actividad', function($id)use($app, $db){
  $res = $app->response;
  $req = $app->request;
   $sql = $db->prepare("select   id,codigo_act,nombre_act
    from Empresa inner join Actividad using(codigo_act) where id = ".$id);

$sql->execute(array("id" => $id));
 
  $datos = $sql->fetchAll(PDO::FETCH_ASSOC);  //print_r($datos);
   $contenido="";//$req->headers->get('Accept');
    $status=406; //$res->status(406);
  if ($req->headers->get('Accept')==='application/json') 
  {  $contenido = json_encode($datos);
   $status=200;//$res->status(200);
   $res->headers->set('Content-type', 'application/json');
  }
  elseif ($req->headers->get('Accept')==='application/xml')
   {
   $xml = new SimpleXMLElement('<Actividades/>');
    toXml($datos, $xml);
    $contenido = $xml->asXML();
    $res->headers->set('Content-type', 'application/xml');
   $status=200;
  } 
//  $res->status(200);
  $res->status($status);
  $res->setBody($contenido);
});
//por terminar

$app->get('/municipios/empresas', function()use($app, $db){
  
  $res = $app->response;
  $req = $app->request;
   $sql = $db->prepare("select  id,nom_estab,raz_social from 
                                   Empresa inner join Ubicacion using(id)
                                   inner join    Municipio using(cve_mun)" );
  
  $sql->execute();
   
   $datos = [];
   $contenido="";//$req->headers->get('Accept');
     $res->status(406);
  
     if(empty($_SERVER['QUERY_STRING'])){
        $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
       if ($req->headers->get('Accept')==='application/json') 
        {
          $contenido = json_encode($datos);
          $res->status(200);
          $res->headers->set('Content-type', 'application/json');
        }
        elseif ($req->headers->get('Accept')==='application/xml')
        {
          $xml = new SimpleXMLElement('<Actividades/>');
          toXml($datos, $xml);
          $contenido = $xml->asXML();
          $res->headers->set('Content-type', 'application/xml');
        }  
     }else{
        
        $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
        $paginas=[];
          $i=1;
         $j=1;
          foreach ($datos as &$dato) {
          // print_r ($dato);
             if($i >=  $req->get("de")&&$j <=  $req->get("next")){
             $paginas[$j]=$dato;
              
               $j=$j+1;   
             }
            $i=$i+1;
           
          }
          $contenido = json_encode($paginas);
         //  print_r($paginas);

     }

   // echo $req->get("next");
   // echo $req->get("de");
  $res->setBody($contenido);
});





$app->get('/actividades/:idact/empresas', function($id)use($app, $db){
  
  $res = $app->response;
  $req = $app->request;
   $sql = $db->prepare("select   id,nom_estab,raz_social,codigo_act
    from Actividad inner join Empresa using(codigo_act) where codigo_act=".$id);

$sql->execute();
      $res->status(406);
  $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
 // print_r($datos);
   $contenido="";
  if ($req->headers->get('Accept')==='application/json') 
  {
   $contenido = json_encode($datos);
  
 $res->headers->set('Content-type', 'application/json');
  }
  elseif ($req->headers->get('Accept')==='application/xml')
   {     $res->status(200);
    
    $xml = new SimpleXMLElement('<Empresas/>');
    toXml($datos, $xml);
    $contenido = $xml->asXML();
    $res->headers->set('Content-type', 'application/xml');
  }
  $res->setBody($contenido);
});


$app->get('/actividades/:idact/empresas/:id/empresa', function($idact,$id)use($app, $db){
  $res = $app->response;
  $req = $app->request;
   $sql = $db->prepare("select   id,codigo_act,raz_social
    from Actividad inner join Empresa using(codigo_act) where Empresa.id=".$id." and Actividad.codigo_act=".$idact);

$sql->execute();
 
  $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
 // print_r($datos);
   $contenido="";
  if ($req->headers->get('Accept')==='application/json') 
  {
   $contenido = json_encode($datos);
  
 $res->headers->set('Content-type', 'application/json');
  }
  elseif ($req->headers->get('Accept')==='application/xml')
   {
    
     $xml = new SimpleXMLElement('<Empresas/>');
    toXml($datos, $xml);
    $contenido = $xml->asXML();
    $res->headers->set('Content-type', 'application/xml');
  }
  $res->setBody($contenido);
});



$app->get('/actividades/ubicacion', function()use($app, $db){
  
  $res = $app->response;
  $req = $app->request;
   $sql = $db->prepare("select  tipo_vial,nom_vial,cod_postal
    from Empresa inner join Ubicacion using(id) inner join Actividad using(codigo_act)  ");

$sql->execute();
  if(empty($_SERVER['QUERY_STRING'])){
        $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
       if ($req->headers->get('Accept')==='application/json') 
        {//echo "dddd";
          $contenido = json_encode($datos);
          $res->status(200);
          $res->headers->set('Content-type', 'application/json');
        }
        elseif ($req->headers->get('Accept')==='application/xml')
        {
          $xml = new SimpleXMLElement('<Actividades/>');
          toXml($datos, $xml);
          $contenido = $xml->asXML();
          $res->headers->set('Content-type', 'application/xml');
        }  
     }else{
        
        $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
        $paginas=[];
          $i=1;
         $j=1;
          foreach ($datos as &$dato) {
           if(strpos($dato[$req->get("filtrado_por")],$req->get("x")))
               $paginas[$i]=$dato;//$dato["nom_vial"];
             $i=$i+1;
           
          }
          $contenido = json_encode($paginas);
         //  print_r($paginas);

     }

  $res->setBody($contenido);
});




$app->get('/actividades/:idAct/ubicacion', function($id)use($app, $db){
  
  $res = $app->response;
  $req = $app->request;
   $sql = $db->prepare("select  nombre_act,tipo_vial,nom_vial
    from Empresa inner join Ubicacion using(id) inner join Actividad using(codigo_act) where codigo_act= ".$id);

$sql->execute();
 
  $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
   $contenido="";
     $res->status(406);
   //  print_r($sql);
  if ($req->headers->get('Accept')==='application/json') 
  {
   $contenido = json_encode($datos);
   $res->status(200);
 $res->headers->set('Content-type', 'application/json');
  }
  elseif ($req->headers->get('Accept')==='application/xml')
   {
    $xml = new SimpleXMLElement('<Ubicaciones/>');
    toXml($datos, $xml);
    $contenido = $xml->asXML();
    $res->headers->set('Content-type', 'application/xml');
  }
  $res->setBody($contenido);
});




$app->get('/municipios/:idMun/empresas', function($idmunicipio)use($app, $db){
    $res = $app->response;
  $req = $app->request;
   $sql = $db->prepare("select  nom_estab,razon_social
    from Empresa inner join Ubicacion using(id) inner join Actividad using(codigo_act) where codigo_act= ".$id);

$sql->execute();
 
  $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
   $contenido="";
     $res->status(406);
   //  print_r($sql);
  if ($req->headers->get('Accept')==='application/json') 
  {
   $contenido = json_encode($datos);
   $res->status(200);
 $res->headers->set('Content-type', 'application/json');
  }
  elseif ($req->headers->get('Accept')==='application/xml')
   { $xml = new SimpleXMLElement('<Empresas/>');
    toXml($datos, $xml);
    $contenido = $xml->asXML();
    $res->headers->set('Content-type', 'application/xml');
  }
  $res->setBody($contenido);
});

?>