<?php

require_once( "../../Lib/lib.php" );
require_once( "../../Lib/db.php" );

$flags[] = FILTER_NULL_ON_FAILURE;

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING, $flags);

if ($method == 'POST') {
    $_INPUT_METHOD = INPUT_POST;
} elseif ($method == 'GET') {
    $_INPUT_METHOD = INPUT_GET;
} else {
    echo "Invalid HTTP method (" . $method . ")";
    exit();
}
$flags[] = FILTER_NULL_ON_FAILURE;

$username = filter_input($_INPUT_METHOD, 'username', FILTER_SANITIZE_STRING, $flags);
$password = filter_input($_INPUT_METHOD, 'password', FILTER_SANITIZE_STRING, $flags);
$passwordConfirm = filter_input($_INPUT_METHOD, 'passwordConfirm', FILTER_SANITIZE_STRING, $flags);
$email = filter_input($_INPUT_METHOD, 'email', FILTER_SANITIZE_STRING, $flags);

$serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

$serverPort = 80;

$name = webAppName();

$baseUrl = "http://" . $serverName . ":" . $serverPort;

$baseNextUrl = $baseUrl . $name;

//$idUser = isValid($username, $password, "basic");
$userAlreadyExists = existUserField("name", $username, "basic");
echo "<h2>" . $username . "</h2>";
// VALIDAR PASSWORD COM AJAX
if ($password != $passwordConfirm) {
    $nextUrl = "formRegister.php";
} else {
    header("Location: " . $baseNextUrl . $nextUrl);
    return;
}
if ($userAlreadyExists) {
    $nextUrl = "formRegister.php";
} else {
    $nextUrl = "formLogin.php";
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    $queryString = 
        "INSERT INTO $dataBaseName (`name`, `password`, `email`, `active`)
            VALUES($username, $password, $email, 0)";

    mysqli_query( $GLOBALS['ligacao'], $queryString);
    /* session_start();
      $_SESSION['username'] = $username;
      $_SESSION['id'] = $idUser;
$_SESSION['id'] = $idUser; nova linha
      if (isset($_SESSION['locationAfterAuth'])) {
      $baseNextUrl = $baseUrl;
      $nextUrl = $_SESSION['locationAfterAuth'];
      } else {
      $nextUrl = "pag_1.php";
      } */
}

header("Location: " . $baseNextUrl . $nextUrl);
?>