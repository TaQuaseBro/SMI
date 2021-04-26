<?php
    require_once( "../Lib/db.php" );
    
    $county = $_GET[ "county" ];
    $district = $_GET[ "district" ];

    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    $queryString = 
        "SELECT `idLocation`, `postalCode`, `postalCodeExtension` FROM `$dataBaseName`.`forms-zips` " .
        "WHERE `idCounty`=$county AND `idDistrict`=$district";
    
    $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString );

    if ( $queryResult ) {
        $result[] = array( 'idLocation'=>0, 'postalCode'=>"" );

        while ($registo = mysqli_fetch_array($queryResult)) {
            $result[] = array( 
                'idLocation'=>$registo['idLocation'], 
                'postalCode'=>$registo['postalCode'].'-'.$registo['postalCodeExtension']);
        }
    }
    else {
        $errDesc = mysqli_error( $GLOBALS['ligacao'] );
        $errNumber = mysqli_errno( $GLOBALS['ligacao']  );

        $result[] = array( 
            'idLocation'=>-1, 
            'postalCode'=>"No Zip Available" );
        $result[] = array( 
            'idLocation'=>-$errNumber, 
            'postalCode'=>$errDesc );        
    }
    dbDisconnect();
    echo json_encode( $result );
?>