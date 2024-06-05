<?php 
try {
    include_once "SQLconection.php";
    include_once "text_verification.php";

    /*$FACULTAD = $_GET['FACULTAD'];
    $NOMBRE = $_GET['NOMBRE'];*/

    $sql_editar = "SELECT `ID_OBJETIVO`, `FACULTAD`, `NOMBRE`, `DESCRIPCION`, `COLOR`, `VISIBLE` FROM `objetivo`";
    $sentencia_editar = $conn->prepare($sql_editar);
    $sentencia_editar->execute();
    $user = $sentencia_editar->fetchAll();
    echo json_encode($user);
} catch (Exception $e) {
    echo json_encode('Ha ocurrido un error');
}

?>