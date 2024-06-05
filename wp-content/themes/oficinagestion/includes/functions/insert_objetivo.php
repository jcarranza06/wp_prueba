<?php 
try {
    include_once "SQLconection.php";
    include_once "text_verification.php";
    
    $FACULTAD = $_GET['FACULTAD'];
    $NOMBRE = $_GET['NOMBRE'];
    $DESCRIPCION = $_GET['DESCRIPCION'];
    $COLOR = $_GET['COLOR']; 
    
    if(isset($FACULTAD) and isset($NOMBRE) and isset($DESCRIPCION) and isset($COLOR)){
        $sql_editar = "INSERT INTO `objetivo` (`ID_OBJETIVO`, `FACULTAD`, `NOMBRE`, `DESCRIPCION`, `COLOR`, `VISIBLE`) VALUES (NULL, ?, ?, ?, ?, '1');";
        $sentencia_editar = $conn->prepare($sql_editar);
        $strings = array($FACULTAD,$NOMBRE,$DESCRIPCION,$COLOR);
        if(verify_array($strings)){
            $res = $sentencia_editar->execute($strings);
            if($res){echo json_encode("success");}
        }
    }
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>