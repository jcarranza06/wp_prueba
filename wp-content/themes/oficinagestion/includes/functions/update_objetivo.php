<?php 
try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    $FACULTAD = $_GET['FACULTAD'];
    $NOMBRE = $_GET['NOMBRE'];
    $DESCRIPCION = $_GET['DESCRIPCION'];
    $COLOR = $_GET['COLOR']; 
    $VISIBLE = $_GET['VISIBLE']; 
    $ID_OBJETIVO = $_GET['ID_OBJETIVO']; 
    
    if(isset($FACULTAD) and isset($NOMBRE) and isset($DESCRIPCION) and isset($COLOR) and isset($VISIBLE)){
        
        $sql_editar = "UPDATE `objetivo` SET `FACULTAD`=?, `NOMBRE`=?, `DESCRIPCION`=?, `COLOR`=?, `VISIBLE`=?  WHERE `objetivo`.`ID_OBJETIVO` = ?;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($FACULTAD,$NOMBRE,$DESCRIPCION,$COLOR,$VISIBLE,$ID_OBJETIVO);
        
        if(verify_array($strings)){
            $res = $sentencia_editar->execute($strings);
            if($res){echo json_encode("success");}
        }
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}


?>