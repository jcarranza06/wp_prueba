<?php 
try {
    include_once "SQLconection.php";
    include_once "text_verification.php";

    $ID_AVANCE = $_GET['ID_AVANCE'];

    if(isset($ID_AVANCE)){
        $sql_editar = "DELETE FROM avance WHERE `avance`.`ID_AVANCE` = ?;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_AVANCE);
        if(verify_array($strings)){
            $res = $sentencia_editar->execute($strings);
            if($res){echo json_encode("success");}
        }
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>




