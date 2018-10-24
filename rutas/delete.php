<?php



$app->delete('/municipios/:idMun/empresas', function($clave_municipio)use($app, $db){
   $res = $app->response;
   $req = $app->request;
  
  
  
    $sql=$db->prepare("select id FROM Municipio 
						inner join Ubicacion using(cve_mun)  where cve_mun=:idMun group by id");

     $sql->execute(array( "idMun" => $clave_municipio,
                         ));                  
   $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
   

   foreach ($datos as &$valores) {
      
          foreach ($valores as &$dato) {
         echo $dato;
         $sql=$db->prepare("delete   FROM Empresa  where id=".$dato);
     $sql->execute();    
}
}
   $res->status(200);
   //  print_r($sql);
  
  //$res->setBody($contenido);
});




?>