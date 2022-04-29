<!DOCTYPE html>
<html>

<head>
    <title>Registrar usuario</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>

<body>
    <?php

$conex = mysqli_connect("localhost","root","","desarrollo"); 

    ?>

    <?php 
$inc = include("con_db.php");
if ($inc) {
	$consulta = "SELECT Pregunta,Respuesta, C.DetalleId FROM wp_encuestas_respuesta C, wp_encuenstas_detalle O WHERE C.DetalleId = O.DetalleId;";
	$resultado = mysqli_query($conex,$consulta);
	if ($resultado) {
		while ($row = $resultado->fetch_array()) {
	    $id = $row['DetalleId'];
	    $respuesta = $row['Respuesta'];
	    $pregunta = $row['Pregunta'];
	    ?>
    <div>
        <div>

            <p>
                <b>Pregunta </b> <?php print $pregunta ?><br>
                <b>Respuesta: </b> <?php print $respuesta ?><br>
                <b>ID: </b> <?php print $id ?><br>

            </p>
        </div>
    </div>

    <?php
        
        
	    }
	}
}
?>
    <?php 
    include("mostrar.php");
    ?>
</body>

</html>