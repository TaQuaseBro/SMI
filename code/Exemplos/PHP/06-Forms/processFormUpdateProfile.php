<!DOCTYPE html>
<?php
header( 'Content-Type: text/html; charset=utf-8' );
?>
        <title>Update user profile response - Forms App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
        <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
    </head>
    </body>
<?php
require_once( "../Lib/lib.php" );
require_once( "vars.php" );

echo "$x\n<br>";

if ( isset($_POST['alias']) ) {
  echo "Alias: " . $_POST['alias'] . "<br>\n";
}

if ( isset($_POST['password']) ) {
  echo "Password: " . $_POST['password'] . "<br>\n";
}

if ( isset($_POST['hobbyCars']) ) {
  echo "hobbyCars: " . $_POST['hobbyCars'] . "<br>\n";
}

if ( isset($_POST['hobbyTrains']) ) {
  echo "hobbyTrains: " . $_POST['hobbyTrains'] . "<br>\n";
}

if ( isset($_POST['age']) ) {
  echo "Age: " . $_POST['age'] . "<br>\n";
}

if ( isset($_POST['district']) ) {
  echo "District: " . $_POST['district'] . "<br>\n";
}

if ( isset($_POST['county']) ) {
  echo "County: " . $_POST['county'] . "<br>\n";
}

if ( isset($_POST['zip']) ) {
  echo "Zip-Code: " . $_POST['zip'] . "<br>\n";
}

echo "<pre>";
print_r($_FILES);
echo "<pre>";

// Maximum time allowed for processing request (including the upload)
set_time_limit(60);

if ( $_FILES['imagePhoto']['error']==0 ) {
  // Name of the upload file in the temporary directory
  $localName = $_FILES['imagePhoto']['tmp_name'];

  // Original name of the file that was uploaded
  $sourceName = $_FILES['imagePhoto']['name'];

  // Directory where the file will be placed
  // Change to read from data base settings
  $dest = "C:\\Temp\\upload\\";
  #$dest = "/tmp/upload/";
  
  // Destination for the uploaded file
  $destName = $dest . $sourceName;

  echo "File: $localName<br>\n";
  echo "Original name of the file: $sourceName<br>\n";
  echo "Destination directory: $dest<br>\n";
  echo "Full destination name: $destName<br>\n";

  if ( copy( $localName, $destName) ) {
    unlink( $localName );
  
    $destName = addslashes( $destName );
    echo "Destination name with slashes: $destName<br>\n";
  }
  else {
    echo "Could not write file to $dest";
  }
}
else {
  $errrorMsg = showUploadFileError( $_FILES['imagePhoto']['error'] );
  echo "Error receiveing file.\n<br>Details: $errrorMsg";
}
?>
    </body>
</html>