<?php
  header( 'Cache-Control: no-cache');
  
  $schema = "http";
  $host = "localhost";
  $port = 8084;
  $webApp = "/01-Hello/";
  
  $serviceName = "Hello?WSDL";
  #$serviceName = "GoodBy?WSDL";
    
  $wsdl = $schema . "://" . $host . ":" . $port . $webApp . $serviceName;
  $wsdlShort = $schema . "://...?WSDL";
?>

<h1>PHP Web Service (SOAP) Client</h1>
<h2>Service location: <?php echo $wsdlShort; ?></h2>
<?php
  try {
    $proxy = new SoapClient( $wsdl, array("cache_wsdl" => WSDL_CACHE_NONE) );

    $types = $proxy->__getTypes();
    echo "\n<hr><b>Available types/structs:</b>\n<br>";
    foreach ($types as $value) {
      echo "$value<br>\n";
    }
    
    // ------------------------------------------------ 
    $functions = $proxy->__getFunctions();
    echo "\n<hr><b>Available functions/methods:</b>\n<br>";
    foreach ($functions as $value) {
      echo "$value<br>\n";
    }
    
    echo "\n<hr>";
  }
  catch (SoapFault $e) {
    echo "Could not execute WS. Cause:<br>\n";
    echo $e->faultstring . "<br>\n";
    echo $e->getTraceAsString() . "<br>\n";
  }  
?>
