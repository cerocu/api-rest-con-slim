
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
