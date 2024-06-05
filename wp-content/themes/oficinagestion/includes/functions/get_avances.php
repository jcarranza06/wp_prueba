<?php 
try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    /*$FACULTAD = $_GET['FACULTAD'];
    $NOMBRE = $_GET['NOMBRE'];*/
    $ID_META = $_GET['ID_META']; 
    if(isset($ID_META)){     
        $sql_editar = "SELECT `ID_AVANCE`, `ID_META`, `PORCENTAJE`, `FECHA`, `DESCRIPCION` FROM `avance` WHERE `ID_META` = ?;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_META);
        $sentencia_editar->execute($strings);
        $user = $sentencia_editar->fetchAll();
        echo json_encode($user);
        //INSERT INTO `meta` (`ID_META`, `ID_META`, `NOMBRE`, `DESCRIPCION`, `COLOR`, `PONDERACION`) VALUES (NULL, '4', 'limpiarlo a diario', 'hacer procedimiento manualmente', '798465', '4');
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>