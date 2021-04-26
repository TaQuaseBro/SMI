<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Accessing Web Services using PHP - Client Process</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
  </head>

  <body>

    <?php
      if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
        $_INPUT_METHOD = INPUT_POST;
      } else {
        $_INPUT_METHOD = INPUT_GET;
      }
      
      $flags[] = FILTER_NULL_ON_FAILURE;

      $wsdl = filter_input( $_INPUT_METHOD, 'wsdl', FILTER_SANITIZE_URL, $flags);

      if ( $wsdl===null ) {
        echo "Invalid arguments.";
        echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
        exit();
      }
      
      if ( !filter_var( $wsdl, FILTER_VALIDATE_URL ) ) {
        echo "Invalid WSDL format.";
        echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
        exit();
      }
      
      $options = array(
          'cache_wsdl' => WSDL_CACHE_NONE,
      );

      try {
        $proxy = new SoapClient( $wsdl, $options);

        $functions = $proxy->__getFunctions();
        echo "Functions available:\n<br>";
        foreach ($functions as $func => $funcName) {
          echo "$func: $funcName<br>\n";
        }

        $types = $proxy->__getTypes();
        echo "Types available:\n<br>";
        foreach ($types as $type => $typeName) {
          echo "$type: $typeName<br>\n";
        }
      }
      catch (SoapFault $e) {
        echo "Could not execute WS. Cause:<br>\n";
        echo $e->faultstring . "<br>\n";
        echo $e->getTraceAsString() . "<br>\n";
      }
    ?>

    <br><hr><a href="javascript: history.go(-1)">Back</a>

  </body>
</html>