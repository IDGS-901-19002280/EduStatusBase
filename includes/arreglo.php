<?php
$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . $baseDir;
define('BASE_URL', $baseUrl);
function promedio($alumno){
    global $pdo;
    $promedio = 0;

    $sqlCantNotas = "SELECT COUNT(valor_nota) as numero FROM notas as n INNER JOIN ev_entregadas as ev ON n.ev_entregada_id = ev.ev_entregada_id WHERE ev.alumno_id = $alumno";
    $queryCantNotas = $pdo->prepare($sqlCantNotas);
    $queryCantNotas->execute();

    if($row = $queryCantNotas->fetch()){
        $cantNotas = $row['numero'];
    }

    $sqlNotas = "SELECT * FROM notas as n INNER JOIN ev_entregadas as ev ON n.ev_entregada_id = ev.ev_entregada_id WHERE ev.alumno_id = $alumno";
    $queryNotas = $pdo->prepare($sqlNotas);
    $queryNotas->execute();
    $count = $queryNotas->rowCount();

    while ($row = $queryNotas->fetch()){
           $promedio = $promedio + $row['valor_nota'];

    }

    if($count > 0){
        return $promedio/$cantNotas;
    } else {
        $promedio = 0;
    }
}


function formato($cantidad){
    $cantidad = number_format($cantidad,2,',','.');
    return $cantidad;
}

?>