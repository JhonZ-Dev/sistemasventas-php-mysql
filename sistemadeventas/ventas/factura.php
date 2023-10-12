<?php


require_once('../app/TCPDF-main/tcpdf.php');
include('../app/config.php');
include ('../layout/sesion.php');
include ('../app/controllers/ventas/literal.php');


$id_venta_get = $_GET['id_venta'];
$nro_venta_get = $_GET['nro_venta'];

$sql_ventas = "SELECT *,cli.nombre_cliente as nombre_cliente , cli.nit_ci_cliente as nit_ci_cliente
               FROM tb_ventas as ve INNER JOIN tb_clientes as cli ON cli.id_cliente=ve.id_cliente 
               WHERE ve.id_venta='$id_venta_get'";
$query_ventas = $pdo->prepare($sql_ventas);
$query_ventas->execute();
$ventas_datos = $query_ventas->fetchAll(PDO::FETCH_ASSOC);

foreach ($ventas_datos as $ventas_dato){
    $fyh_creacion = $ventas_dato['fyh_creacion'];
    $nit_ci_cliente = $ventas_dato['nit_ci_cliente'];
    $nombre_cliente = $ventas_dato['nombre_cliente'];
    $total_pagado=$ventas_dato['total_pagado'];
    $nombres_sesion = $usuario['nombres'];



}
$monto_literal = numeroEnPalabras($total_pagado);
$fecha=date("d/m/Y",strtotime($fyh_creacion));




//create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(215,279),true,'UTF-8',false);
//set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('WeMakers - Academy');
$pdf->setTitle('Factura - WeMakers');
		$pdf->setSubject('Sistema Inventario -WeMakers');
		$pdf->setKeywords('Factura WeMakers');

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->setMargins(15,15,15);
		$pdf->setAutoPageBreak(true,5);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some lenguage-depend string (optional)l
		if(@file_exists(dirname(__FILE__).'/lang/eng.php')){
            requiere_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		// ----------------------------------------------------------

		//set font
		$pdf->setFont('Helvetica','',12);

		//add a page
		$pdf->AddPage();

		//create some HTML content
		$html = '
<table border="0" style="font-size: 10px;">
<tr>
    <td style="text-align: center; width: 200px">
    <img src="../public/images/logo.jpg" width="80px;" alt="" style="border-radius: 20px;"> <br><br>
   
    <b>WeMakers Academy</b> <br>
    Rio lelila - Parque de la Juventud
    Santo Domingo - Ecuador
    0939765584 / 2350051c
    </td>
    <td style="width:200px"></td>
    <td style="font-size: 15px; width: 290px;"><br><br><br><br><br>
    <b>Ruc: </b>2323232323232 <br>
     <b>Nro Factura: </b> '.$id_venta_get.' <br>
     <b>Nro Autorización:</b>00000000000848 <br>
     <p style="text-align: center"><b>Original</b></p>
    
    </td>
</tr>   
</table>
<p style="text-align: center; font-size: 25px;"><b>FACTURA</b></p>
<div style="border: 1px solid grey;">
<table border="0" cellspacing="8">
<tr>
    <td><b>Fecha:   </b>  '.$fecha.'</td>
    <td></td>
    <td><b>Cedula:  </b>'.$nit_ci_cliente.'</td> 
</tr>
<tr>
    <td colspan="3"><b>Cliente: </b>'.$nombre_cliente.'</td>
</tr>
</table>
</div>

<br>
<hr>
<br><br>

<table border="1" cellpadding="8" style="font-size: 10px;">
<tr style="text-align: center; background-color: #d6d6d6">
    <th style="width: 40px;"><b>Nr</b></th>
    <th style="width:150px;"><b>Producto</b></th>
    <th style="width:235px;"><b>Descripcion</b></th>
    <th style="width:65px;"><b>Cantidad</b></th>
    <th style="width:98px;"><b>Precio Unitario</b></th>
    <th style="width:70px;"><b>Subtotal</b></th>
</tr>
';
$contador_de_carrito=0;
$cantidad_total=0;
$precio_unitario_total=0;
$precio_total=0;

$sql_carrito ="SELECT *,pro.nombre as nombre_producto,pro.descripcion as descripcion, pro.precio_venta as precio_venta,pro.stock as stock, pro.id_producto as id_producto
                                        FROM tb_carrito as carr
                                        INNER JOIN tb_almacen as pro ON carr.id_producto = pro.id_producto
                                        WHERE nro_venta='$nro_venta_get' ORDER BY id_carrito DESC";
$query_carrito = $pdo->prepare($sql_carrito);
$query_carrito->execute();
$carrito_datos = $query_carrito->fetchAll(PDO::FETCH_ASSOC);

foreach ($carrito_datos as $carrito_dato) {
    $id_carrito = $carrito_dato['id_carrito'];
    $contador_de_carrito = $contador_de_carrito + 1;
    $cantidad_total = $cantidad_total + $carrito_dato['cantidad'];
    $precio_unitario_total = $precio_unitario_total + floatval($carrito_dato['precio_venta']);
    $subtotal=$carrito_dato['cantidad'] * $carrito_dato['precio_venta'];
    $precio_total=$precio_total+$subtotal;



    $html .='
    <tr>
        <td style="text-align: center;">'.$contador_de_carrito.'</td>
        <td style="text-align: center;">'.$carrito_dato['nombre_producto'].'</td>
        <td style="text-align: center;">'.$carrito_dato['descripcion'].'</td>
        <td style="text-align: center;">'.$carrito_dato['cantidad'].'</td>
        <td style="text-align: center;">'.$carrito_dato['precio_venta'].'</td>
        <td style="text-align: center;">'.$subtotal.'</td>
</tr>
    ';
    }
$html .='

<tr>
    <td colspan="3" style="text-align: right; background-color: yellow"><b>Total</b></td>
    <td style="text-align: center">'.$cantidad_total.'</td>
    <td style="text-align: center">'.$precio_unitario_total.'</td>
    <td style="text-align: center">'.$precio_total.'</td>
    
</tr>
</table>
<p style="text-align: right;">
    <b>Monto Total: </b>'.$precio_total.'<b>$</b>
    
</p>
<p>
    <b>Son: </b> '.$monto_literal.'
</p>   
<br>
----------------------------------------- <br>
<b>Vendedor: </b>'.$nombres_sesion.'<br>
<p style="text-align: center;"></p>
<p style="text-align: center;">KGKFJGKFKGFNKGNAKLNFKDNJKSNBGKJBDFJKGBSKJGBKDSJBKJDSBKGSDF</p>
<p style="text-align: center;">GRACIAS POR SU COMPRA</p>


		';
		// ouput the HTML content
		$pdf->writeHTML($html,true,false,true,false,'');

		$style = array(
            'border'=>0,
            'vpadding' => '3',
            'hpadding'=>'3',
            'fgcolor'=> array(0,0,0),
            'bgcolor'=>false,
            'module_width'=>1
        );

			//$QR = 'Factra realizada en wemakers';
            $nit_ci_cliente_utf8 = utf8_encode($nit_ci_cliente);
            $QR = "Cliente: $nombre_cliente\nFecha: $fecha\nCédula: $nit_ci_cliente_utf8\nProductos:\n";
            foreach ($carrito_datos as $carrito_dato) {
                $nombre_producto_utf8 = utf8_encode($carrito_dato['nombre_producto']); // Asegura que los caracteres acentuados en el nombre del producto se codifiquen en UTF-8
                $QR .= "$nombre_producto_utf8\n";
            }
// Agregar los valores de precio_total y monto_literal
    $QR .= "Monto Total: $precio_total $\n";
    $QR .= "Total cancelado Fueron: $monto_literal";

$pdf->write2DBarcode($QR,'QRCODE,L',170,180,90,90, $style);
	//close and output PDF document
	$pdf->Output('example_002.pdf','I');

	// ========================================
	// END OF file
	// ========================================
