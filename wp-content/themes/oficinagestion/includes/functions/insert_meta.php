<?php 
try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    $ID_OBJETIVO = $_GET['ID_OBJETIVO'];
    $NOMBRE = $_GET['NOMBRE'];
    $DESCRIPCION = $_GET['DESCRIPCION'];
    $COLOR = $_GET['COLOR']; 
    $PONDERACION = $_GET['PONDERACION']; 
    
    if(isset($ID_OBJETIVO) and isset($NOMBRE) and isset($DESCRIPCION) and isset($COLOR) and isset($PONDERACION)){
        
        $sql_editar = "INSERT INTO `meta` (`ID_META`, `ID_OBJETIVO`, `NOMBRE`, `DESCRIPCION`, `COLOR`, `PONDERACION`) VALUES (NULL, ?, ?, ?, ?, ?);";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_OBJETIVO,$NOMBRE,$DESCRIPCION,$COLOR,$PONDERACION);
        if(verify_array($strings)){
            $res = $sentencia_editar->execute($strings);
            //if($res){echo json_encode("success");}
        }
    
        $sql_editar = "INSERT INTO `avance` (`ID_AVANCE`, `ID_META`, `PORCENTAJE`, `FECHA`, `DESCRIPCION`) VALUES (NULL, (SELECT ID_META FROM meta WHERE ID_OBJETIVO = ? AND NOMBRE= ? AND DESCRIPCION = ? AND COLOR=? AND PONDERACION = ? ORDER BY ID_META DESC LIMIT 1), 1, CURRENT_TIME(), 'creacion');";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_OBJETIVO,$NOMBRE,$DESCRIPCION,$COLOR, $PONDERACION);
        if(verify_array($strings)){
            $res1 = $sentencia_editar->execute($strings);
            if($res and $res1){echo json_encode("success");}
        }
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>