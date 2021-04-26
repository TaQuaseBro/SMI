<?php
    $DebugForm=true;
    
    if ( $DebugForm==true ) {
        define( "DebugName", "Carlos Gonçalves");
        define( "DebugEmail", "carlos.goncalves@isel.pt");
        define( "DebugSubject", "Subject for sending an e-mail");
        define( "DebugMessage", "Message body of the e-mail");
    }
    else {
        define( "DebugName", "");
        define( "DebugEmail", "");
        define( "DebugSubject", "");
        define( "DebugMessage", "");
    }
?>
