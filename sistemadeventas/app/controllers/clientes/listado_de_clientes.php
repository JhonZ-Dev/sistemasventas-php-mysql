<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 12/2/2023
 * Time: 18:45
 */

$sql_clientes = "SELECT * FROM tb_clientes";
$query_clientes = $pdo->prepare($sql_clientes);
$query_clientes->execute();
$clientes_datos = $query_clientes->fetchAll(PDO::FETCH_ASSOC);