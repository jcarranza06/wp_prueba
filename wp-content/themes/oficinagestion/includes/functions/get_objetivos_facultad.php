<?php 

try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    $FACULTAD = $_GET['FACULTAD'];
    
    if(isset($FACULTAD)){
        $sql_editar = "SELECT objetivo.ID_OBJETIVO, meta.ID_META, objetivo.FACULTAD, objetivo.NOMBRE as 'NOMBRE_OBJETIVO', objetivo.DESCRIPCION as 'DESCRIPCION_OBJETIVO', meta.NOMBRE as 'NOMBRE_META', meta.PONDERACION, (SELECT avance.PORCENTAJE FROM avance WHERE avance.ID_META = meta.ID_META ORDER BY avance.FECHA DESC LIMIT 1) as 'AVANCE', meta.DESCRIPCION as 'DESCRIPCION_META', meta.COLOR FROM `meta` INNER JOIN objetivo on meta.ID_OBJETIVO = objetivo.ID_OBJETIVO WHERE objetivo.FACULTAD=? AND objetivo.VISIBLE=1 ORDER BY 1;";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($FACULTAD);
        if(verify_array($strings)){
            $sentencia_editar->execute($strings);
            $user = $sentencia_editar->fetchAll();
            echo json_encode($user);
        }
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>