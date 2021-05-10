<?php
   require_once( "../../Lib/lib.php" );
   require_once( "../../Lib/db.php" );

   $username = $_GET[ "name" ];
   
   $nextUrl = "formLogin.php";
   dbConnect( ConfigFile );
   $dataBaseName = $GLOBALS['configDataBase']->db;
   mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
   
   $queryString = "UPDATE `$dataBaseName`.`auth-basic` SET `active` = 1 WHERE `name` = '$username'";

   $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString);
   
   
   
   echo "Authentification Done Please Login Again!";
   
   
   dbDisconnect();

?>

