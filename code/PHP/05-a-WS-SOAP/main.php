<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Accessing Web Services using PHP</title>
    
    <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
  </head>

  <body>
    <p><b>Note:</b></p>
    <?php
      require_once( "../Lib/db.php" );

      $pathConfigFile = ConfigFile;

      echo "    <p>Please ensure that PHP extentions for SOAP are enable:</p>\n<br>";

      echo "    <code>extension=soap</code> in \"php.ini\" file +/- line 914\n<br>";
    ?>
  </body>
</html>