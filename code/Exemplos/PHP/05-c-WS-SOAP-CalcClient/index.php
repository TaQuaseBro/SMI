<?php
  header( 'Cache-Control: no-cache');
  
  $schema = "http";
  $host = "localhost";
  $port = 8084;
  $webApp = "/04-WebAppCalc-C-Scientifc/";
  $serviceName = "CalcServiceScientific?WSDL";
    
  $wsdl = $schema . "://" . $host . ":" . $port . $webApp . $serviceName;
?>

<h1>Scientific calculator (SOAP Web Service) client</h1>
<h2>Service location: <?php echo $wsdl; ?></h2>
<?php
  try {
    /*
    class PhpComplexNumber {
      public $realPart;
      public $imaginaryPart;
    }
    $op1AsComplex = new PhpComplexNumber();
    $op2AsComplex = new PhpComplexNumber();
    
    $options = array( 
        "cache_wsdl" => WSDL_CACHE_NONE,
        'classmap' => array('complexNumber' => 'PhpComplexNumber')
    );
    */
    
    class complexNumber {
      //public $realPart;
      //public $imaginaryPart;
    }
    $op1AsComplex = new complexNumber();
    $op2AsComplex = new complexNumber();
    
    $options = array( 
        "cache_wsdl" => WSDL_CACHE_NONE
    );
    
    $proxy = new SoapClient( $wsdl, $options);

    // ------------------------------------------------
    $types = $proxy->__getTypes();
    echo "\n<hr>Available types/structs:\n<br>";
    foreach ($types as $key => $value) {
      echo "$key: $value<br>\n";
    }
    
    // ------------------------------------------------ 
    $functions = $proxy->__getFunctions();
    echo "\n<hr>Available functions/methods:\n<br>";
    foreach ($functions as $key => $value) {
      echo "$key: $value<br>\n";
    }
    
    // ------------------------------------------------ 
    echo "\n<hr>Invoking simple calc operations:\n<br>";
    
    $op1AsNumber = 4.3;
    $op2AsNumber = 5.8;
     
    $op1AsComplex->realPart = 3;
    $op1AsComplex->imaginaryPart = 2;
    
    $op2AsComplex->realPart = 4;
    $op2AsComplex->imaginaryPart = -3;
    
    $simpleOperations = array( 
        "+" => "add", 
        "-" => "sub", 
        "*" => "mul", 
        "/" => "div" );
    
    print_r( $proxy->add( array( "op2" => $op2AsNumber, "op1" => $op1AsNumber ) ) );
    echo "\n<br>";
    print_r( $proxy->add( array( "op1" => $op1AsNumber, "op2" => $op2AsNumber ) ) );
    echo "\n<br>";
    
    foreach ($simpleOperations as $key => $value) {
        $resultAsOject;
        $resultAsOject = $proxy->$value( array( "op1" => $op1AsNumber, "op2" => $op2AsNumber) );
        
        print_r( $resultAsOject );
        
        $result = $resultAsOject->return;
        
        printf( 
                "%5.2f %s %5.2f = %5.2f", 
                $op1AsNumber, $key, $op2AsNumber, $result );
        
        echo "\n<br>";
    }
    
    // ------------------------------------------------ 
    echo "\n<hr>Invoking complex calc operations:\n<br>";
        
    $complexOperations = array( 
        "+" => "addComplex", 
        "-" => "subComplex", 
        "*" => "mulComplex", 
        "/" => "divComplex" );
    
    foreach ($complexOperations as $key => $value) {
        $resultAsOject;
        $resultAsOject = $proxy->$value( 
                array( "op1" => $op1AsComplex, "op2" => $op2AsComplex) );
        
        print_r( $resultAsOject );
        
        $resultAsComplex = $resultAsOject->return;
        
        printf( 
                "(%5.2f,%5.2fi)%s(%5.2f,%5.2fi)=(%5.2f,%5.2fi)",
                $op1AsComplex->realPart, $op1AsComplex->imaginaryPart,
                $key,
                $op2AsComplex->realPart, $op2AsComplex->imaginaryPart,
                $resultAsComplex->realPart, $resultAsComplex->imaginaryPart );
        
        echo "\n<br>";
    }
  }
  catch (SoapFault $e) {
    echo "Could not execute WS. Cause:<br>\n";
    echo $e->faultstring . "<br>\n";
    echo $e->getTraceAsString() . "<br>\n";
  }  
?>
