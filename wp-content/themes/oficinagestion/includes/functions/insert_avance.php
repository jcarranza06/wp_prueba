<?php 
try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    $ID_META = $_GET['ID_META'];
    $PORCENTAJE = $_GET['PORCENTAJE']; 
    $DESCRIPCION = $_GET['DESCRIPCION'];
    
    
    if(isset($ID_META) and isset($DESCRIPCION) and isset($PORCENTAJE)){
        
        $sql_editar = "INSERT INTO `avance` (`ID_AVANCE`, `ID_META`, `PORCENTAJE`, `FECHA`, `DESCRIPCION`) VALUES (NULL, ?, ?, CURRENT_TIME(), ?);";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_META,$PORCENTAJE,$DESCRIPCION);
        if(verify_array($strings)){
            $res = $sentencia_editar->execute($strings);
            if($res){echo json_encode("success");}
        }
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>