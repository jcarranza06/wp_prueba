<?php 

try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    $ID_OBJETIVO = $_GET['ID_OBJETIVO'];
    
    if(isset($ID_OBJETIVO)){
    
        $sql_editar = "DELETE FROM avance WHERE ID_AVANCE in (SELECT ID_AVANCE FROM avance INNER JOIN meta ON meta.ID_META = avance.ID_META WHERE meta.ID_OBJETIVO = ?);";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_OBJETIVO);
        if(verify_array($strings)){
            $res = $sentencia_editar->execute($strings);
            //if($res){echo json_encode("success");}
        }
    
        $sql_editar = "DELETE FROM meta WHERE `meta`.`ID_OBJETIVO` = ?;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_OBJETIVO);
        if(verify_array($strings)){
            $res1 = $sentencia_editar->execute($strings);
            //if($res){echo json_encode("success");}
        }
        $sql_editar = "DELETE FROM objetivo WHERE `objetivo`.`ID_OBJETIVO` = ?;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_OBJETIVO);
        if(verify_array($strings)){
            $res2 = $sentencia_editar->execute($strings);
            if($res and $res1 and $res2){echo json_encode("success");}
        }
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>