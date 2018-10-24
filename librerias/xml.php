<?php
function toXml($array, $xml) {
  foreach($array as $key => $value) {
    if(is_array($value)) {
      if(!is_numeric($key)){
        $subnode = $xml->addChild("$key");
        toXml($value, $subnode);
      }else{
        $subnode = $xml->addChild("item$key");
        toXml($value, $subnode);
      }
    }else {
        $xml->addChild("$key",htmlspecialchars("$value"));
    }
  }
}
?>