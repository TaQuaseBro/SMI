<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    
    <title>Accessing Web Services using PHP - Book Store Client</title>
    
    <script type="text/javascript" src="scripts/forms.js">
    </script>
    
    <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
  </head>

  <body onload="init()">
    <p><b>Note 1:</b></p>
<?php
require_once( "../Lib/db.php" );

$pathConfigFile = ConfigFile;

echo "    <p>Please ensure that PHP extentions for SOAP are enable:</p>\n<br>";

echo "    <code>extension=soap</code> in \"php.ini\" file +/- line 914\n<br>";
?>
    <p><b>Note 2:</b></p>
    <p>Book store locations are specified in file <b><code>services.xml</code></b></p>
    
    <p>New locations can be manually specified in the text field.</p>
    
    <p><b>Book store client:</b></p>
<?php
  $services = simplexml_load_file( "services.xml" );

  $description = $services->Description;
  $locations = $services->Locations[0];

  $numLocations = count( $locations );

  echo "    <p>Available locations for <i>" . $description . "</i>:<p>\n";
?>
    <form action="processClientBookStore.php" method="POST">
      <table>
        <tr>
          <td>
            <select size="1" name="wsdls" id="wsdls" onchange="selectChanged('wsdls', 'wsdl')">
<?php
  $idxLocation=1;
  foreach ( $locations as $currentlocation) {
    if ( $idxLocation!=$numLocations) {
      echo "              <option value=\"$currentlocation\">$currentlocation</option>\n";
    }
    else {
      echo "              <option selected value=\"$currentlocation\">$currentlocation</option>\n";
    }
    ++$idxLocation;
  }
?>
            </select>
          </td>
        </tr>

        <tr>
          <td>
            <p>Location selected:</p>
            <input type="text" size="100" value="" name="wsdl" id="wsdl">
          </td>
        </tr>

      </table>

      <br>

      <input type="submit" value="List Available Books"> <input type="reset" value="Clear">
    </form>

  </body>
</html>