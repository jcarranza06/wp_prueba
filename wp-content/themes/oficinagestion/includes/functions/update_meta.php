<?php 
try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    $NOMBRE = $_GET['NOMBRE'];
    $DESCRIPCION = $_GET['DESCRIPCION'];
    $COLOR = $_GET['COLOR']; 
    $PONDERACION = $_GET['PONDERACION']; 
    $ID_META = $_GET['ID_META']; 
    
    if(isset($NOMBRE) and isset($DESCRIPCION) and isset($COLOR) and isset($PONDERACION) and isset($ID_META) ){
                     
        $sql_editar = "UPDATE `meta` SET `NOMBRE`= ?, `DESCRIPCION` = ?, `COLOR` = ?, `PONDERACION` = ? WHERE `meta`.`ID_META` = ?;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($NOMBRE,$DESCRIPCION,$COLOR,$PONDERACION,$ID_META);
        
        if(verify_array($strings)){
            $res = $sentencia_editar->execute($strings);
            if($res){echo json_encode("success");}
        }
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>