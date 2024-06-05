<?php 
try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    $ID_OBJETIVO = $_GET['ID_OBJETIVO']; 
    if(isset($ID_OBJETIVO)){
        $sql_editar = "SELECT `ID_META`, `ID_OBJETIVO`, `NOMBRE`, `DESCRIPCION`, `COLOR`, `PONDERACION` FROM `meta` WHERE `ID_OBJETIVO` = ?;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($ID_OBJETIVO);
        $sentencia_editar->execute($strings);
        $user = $sentencia_editar->fetchAll();
        echo json_encode($user);
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>