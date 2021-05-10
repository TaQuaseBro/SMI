<?php
require_once( "../../Lib/lib.php" );
require_once( "../../Lib/db.php" );
require_once( "../../Lib/lib-mail-v2.php" );


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
    //header("Location: " . $baseNextUrl . $nextUrl);
    //return;

}
if ($userAlreadyExists) {
    $nextUrl = "formRegister.php";
} else {
    $nextUrl = "formLogin.php";
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    $queryString = "INSERT INTO `$dataBaseName`.`auth-basic` (`name`, `password`, `email`, `active`) VALUES('$username', '$password', '$email', 0)";

    $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString);

    
    //EMAIL SENDING 
    $Account = 2;
    $ToName = $username;
    $ToEmail = $email;
    $Subject = "Teste 123";
    $Message = "https://localhost/examples-smi/07-Auth/Ver3/processAuth.php?name=$username";
    
    dbConnect( ConfigFile );
                

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $queryString2 = "SELECT * FROM `$dataBaseName`.`email-accounts` WHERE `id`='$Account'";
    $queryResult2 = mysqli_query( $GLOBALS['ligacao'], $queryString2 );
    $record = mysqli_fetch_array( $queryResult2 );
        
    $smtpServer = $record[ 'smtpServer' ];
    $port = intval( $record[ 'port' ] );
    $useSSL = boolval( $record[ 'useSSL' ] );
    $timeout = intval( $record[ 'timeout' ] );
    $loginName = $record[ 'loginName' ];
    $password = $record[ 'password' ];
    $fromEmail = $record[ 'email' ];
    $fromName = $record[ 'displayName' ];
    
    mysqli_free_result( $queryResult2 );
    $Debug = FALSE;
    
    $result = sendAuthEmail(
            $smtpServer,
            $useSSL,
            $port,
            $timeout,
            $loginName,
            $password,
            $fromEmail,
            $fromName,
            $ToName . " <" . $ToEmail . ">",
            NULL,
            NULL,
            $Subject,
            $Message,
            $Debug,
            NULL );
    
    echo $result;
    

    dbDisconnect();

}

header("Location: " . $baseNextUrl . $nextUrl);
?>