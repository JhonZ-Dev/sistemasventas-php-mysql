<?php
function numeroEnPalabras($numero) {
    $unidades = array('','UN','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE');
    $decenas = array('','DIEZ','VEINTE','TREINTA','CUARENTA','CINCUENTA','SESENTA','SETENTA','OCHENTA','NOVENTA');
    $centenas = array('','CIENTO','DOSCIENTOS','TRESCIENTOS','CUATROCIENTOS','QUINIENTOS','SEISCIENTOS','SETECIENTOS','OCHOCIENTOS','NOVECIENTOS');

    $resultado = '';

    if ($numero == 0) {
        $resultado = 'CERO';
    } elseif ($numero < 10) {
        $resultado = $unidades[$numero];
    } elseif ($numero < 100) {
        if ($numero % 10 == 0) {
            $resultado = $decenas[$numero / 10];
        } else {
            $resultado = $decenas[floor($numero / 10)] . ' Y ' . $unidades[$numero % 10];
        }
    } elseif ($numero == 100) {
        $resultado = 'CIEN';
    } elseif ($numero > 100 && $numero < 1000) {
        if ($numero % 100 == 0) {
            $resultado = $centenas[$numero / 100];
        } else {
            $resultado = $centenas[floor($numero / 100)] . ' ' . numeroEnPalabras($numero % 100);
        }
    }

    return $resultado;
}

$precio_total = 240; // Aquí deberías colocar el monto total de tu factura

//echo '<p><b>Monto Total: </b>' . $precio_total . '<b>$</b></p>';

//echo '<p><b>Son: </b>' . strtoupper(numeroEnPalabras($precio_total)) . '</p>';
?>
