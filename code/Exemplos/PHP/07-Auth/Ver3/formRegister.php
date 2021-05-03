<!DOCTYPE html>
<?php
    require_once( "../../Lib/lib.php" );
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

    $serverPortSSL = 443;
    $serverPort = 80;

    $name = webAppName();

    $nextUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "processFormRegister.php";
    #$nextUrl = "http://" . $serverName . ":" . $serverPort . $name . "processFormLogin.php";
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Authentication Using PHP</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" typr="text/css" href="../../Styles/GlobalStyle.css">
    </head>
    
    <body>
        <form action="<?php echo $nextUrl ?>" method="POST">
            <table>
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="username" placeholder="Username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" placeholder="Password"></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" name="passwordConfirm" placeholder="Confirm password"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" placeholder="Email"></td>
                </tr>
                
            </table>

            <input type="submit" value="Register"> <input type="reset" value="Clear">
        </form>

        <p><a href="formLogin.php">Back</a></p>
    </body>
</html>