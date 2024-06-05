<?php 

try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    $ID_META = $_GET['ID_META'];
    
    if(isset($ID_META)){
    
        $sql_editar = "DELETE FROM avance WHERE `avance`.`ID_META` = ?;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_META);
        if(verify_array($strings)){
            $res = $sentencia_editar->execute($strings);
            //if($res){echo json_encode("success");}
        }
        $sql_editar = "DELETE FROM meta WHERE `meta`.`ID_META` = ?;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_META);
        if(verify_array($strings)){
            $res = $sentencia_editar->execute($strings);
            if($res){echo json_encode("success");}
        }
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>