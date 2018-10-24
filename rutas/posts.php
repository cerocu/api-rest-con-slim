<?php

$app->post('/empresas/:id/empresa', function($id) use($app, $db){
  $res = $app->response;
  $req = $app->request;
  
 $sql = $db->prepare('select id from Empresa where id ='.$id);
 $sql->execute();
   if ($sql->execute())
    {
    $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
   
     if(count($datos) !== 0){
       return $res->status(412);
      }
  }
  $body=[];
  if($req->headers->get('Content-type')==='application/xml'){
   // echo "ff";
    // echo $req->getContentType();
    try {
     $body= simplexml_load_string($req->getBody());
    } catch (Exception $e) {
       return $res->status(400);
       }
  }else
  $body = json_decode($req->getBody(), true);
//print_r($body);
  if(count($body)==0)
  {
  return  $res->status(400);
  }
  $sql = $db->prepare(
     'insert into Empresa(id, nom_estab, raz_social, codigo_act, per_ocu, telefono, correoelec, www, tipounieco, fecha_alta) 
     values (:id, :nom_estab, :raz_social, :codigo_act, :per_ocu, :telefono, :correoelec, :www, :tipounieco, :fecha_alta)'
    );
  $sql->execute(
   array(
      "id" => $body["id"],
      "nom_estab" => $body["nombre_estab"],
      "raz_social" => $body["raz_social"],
      "codigo_act" => $body["codigo_act"],
      "per_ocu" => $body["per_ocu"],
      "telefono" => $body["telefono"],
      "correoelec" => $body["correoelec"],
      "www" => $body["www"],
      "tipounieco" => $body["tipounieco"],
      "fecha_alta" => $body["fecha_alta"]));

    
  $res->status(201);
});


$app->post('/empresas/:id/actividad/', function($id) use($app, $db){
  $res = $app->response;
  $req = $app->request;

 
  $body = json_decode($req->getBody(), true);
  $sql = $db->prepare(
    'insert into Actividad(codigo_act, nombre_act) 
     values (:codigo_act, :nombre_act)'
    );
 
 
  $sql->execute(
   array(
      "codigo_act" => $body["id"],
      "nombre_act" => $body["nombre"]));

      
  $res->status(201);
});



?>