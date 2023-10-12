<?php

$id_venta_get = $_GET['id_venta'];
$nro_venta_get = $_GET['nro_venta'];

include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');
include('../app/controllers/ventas/cargar_venta.php');
include ('../app/controllers/clientes/cargar_cliente.php');




?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Detalle de la venta: Nro <?= $nro_venta ?></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-danger">
                        <div class="card-header">

                            <h3 class="card-title">Venta
                                <input type="text" value="<?php echo $nro_venta; ?>" style="text-align: center;" disabled></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-smt table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th style="background-color:#e7e7e7; text-align: center">Nro</th>
                                        <th style="background-color:#e7e7e7; text-align: center">Producto</th>
                                        <th style="background-color:#e7e7e7; text-align: center">Detalle</th>
                                        <th style="background-color:#e7e7e7; text-align: center">Cantidad</th>
                                        <th style="background-color:#e7e7e7; text-align: center">Precio Unitario</th>
                                        <th style="background-color:#e7e7e7; text-align: center">Precio SubTotal</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $contador_de_carrito=0;
                                    $cantidad_total=0;
                                    $precio_unitario_total=0;
                                    $precio_total=0;
                                    $sql_carrito ="SELECT *,pro.nombre as nombre_producto,pro.descripcion as descripcion, pro.precio_venta as precio_venta,pro.stock as stock, pro.id_producto as id_producto
                                        FROM tb_carrito as carr
                                        INNER JOIN tb_almacen as pro ON carr.id_producto = pro.id_producto
                                        WHERE nro_venta='$nro_venta' ORDER BY id_carrito DESC";
                                    $query_carrito = $pdo->prepare($sql_carrito);
                                    $query_carrito->execute();
                                    $carrito_datos = $query_carrito->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($carrito_datos as $carrito_dato){
                                        $id_carrito=$carrito_dato['id_carrito'];
                                        $contador_de_carrito=$contador_de_carrito + 1;
                                        $cantidad_total=$cantidad_total + $carrito_dato['cantidad'];
                                        $precio_unitario_total = $precio_unitario_total+floatval($carrito_dato['precio_venta']);

                                        ?>
                                        <tr>
                                            <td>
                                                <center><?php echo $contador_de_carrito?></center>
                                                <input hidden type="text" value="<?php echo $carrito_dato['id_producto'] ?>" id="id_producto<?php echo $contador_de_carrito?>"">

                                            </td>
                                            <td><?php echo $carrito_dato['nombre_producto']; ?></td>
                                            <td><?php echo $carrito_dato['descripcion']; ?></td>
                                            <td>
                                                <center><span id="cantidad_carrito<?php echo $contador_de_carrito; ?>"><?php echo $carrito_dato['cantidad']; ?></span></center>
                                                <input hidden  id="stock_de_inventario<?php echo $contador_de_carrito; ?>" type="text" value="<?php echo $carrito_dato['stock']; ?>">
                                            </td>
                                            <td><?php echo $carrito_dato['precio_venta']; ?></td>
                                            <td>
                                                <center>
                                                    <?php
                                                    $cantidad = floatval($carrito_dato['cantidad']);
                                                    $precio_venta = floatval($carrito_dato['precio_venta']);
                                                    echo $subtotal=$cantidad * $precio_venta;
                                                    $precio_total = $precio_total    + $subtotal;

                                                    ?>
                                                </center>
                                            </td>

                                        </tr>
                                        <?php
                                    }

                                    ?>
                                    <tr>
                                        <th colspan="3" style="background: #e7e7e7; text-align: right;">Total</th>
                                        <th>
                                            <center>
                                                <?php
                                                echo $cantidad_total;
                                                ?>
                                            </center>
                                        </th>
                                        <th>
                                            <center>
                                                <?php
                                                echo $precio_unitario_total;
                                                ?>
                                            </center>
                                        </th>
                                        <th style="background-color: yellow">
                                            <center>
                                                <?php
                                                echo $precio_total;
                                                ?>
                                            </center>
                                        </th>
                                    </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Datos del cliente</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <?php

                        foreach ($clientes_datos as $clientes_dato){
                            $nombre_cliente = $clientes_dato['nombre_cliente'];
                            $nit_ci_cliente = $clientes_dato['nit_ci_cliente'];
                            $celular_cliente = $clientes_dato['celular_cliente'];
                            $email_cliente = $clientes_dato['email_cliente'];

                        }
                        ?>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" id="id_cliente" hidden>
                                        <label for="">Cliente</label>
                                        <input  value="<?php echo $nombre_cliente ?>" type="text" class="form-control" id="nombre_cliente" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">CI Cliente</label>
                                        <input  value="<?php echo $nit_ci_cliente ?>" type="text" class="form-control" id="nit_ci_cliente" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Celular</label>
                                        <input  value="<?php echo $celular_cliente ?>" type="text" class="form-control" id="celular_cliente" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input  value="<?php echo $email_cliente ?>" type="text" class="form-control" id="email_cliente" disabled>
                                    </div>
                                </div>



                                <div class="col-md-6"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-shopping-basket"></i> Registrar venta </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Monto a cancelar</label>
                                <input  disabled type="text" id="total_a_cancelar" class="form-control" value="<?php echo $precio_total ?>" style="text-align: center; background-color: yellow;">
                            </div>
                            <hr>
                            <div class="form-group">
                                <button id="btn_borrar_venta" class="btn btn-danger btn-block">Borrar</button>
                                <div id="btn_borrar_venta">

                                </div>
                            </div>
                            <script>
                                $('#btn_borrar_venta').click(function () {
                                    var id_venta = '<?php echo $id_venta_get; ?>';
                                    var nro_venta ='<?php echo $nro_venta_get; ?>';
                                    actualizar_sock();
                                    borrar_venta();


                                    function actualizar_sock() {
                                        var i=1;
                                        var n='<?php echo $contador_de_carrito; ?>';

                                        for(var i=1; i<=n; i++){
                                            var a='#stock_de_inventario'+i;
                                            var stock_de_inventario=$(a).val();
                                            var b = '#cantidad_carrito'+i;
                                            var cantidad_carrito = $(b).html();
                                            var c = '#id_producto'+i;
                                            var id_producto = $(c).val();
                                            var stock_calculado = parseFloat(parseInt(stock_de_inventario) +parseInt(cantidad_carrito));
                                            //alert(id_producto+"--"+ stock_de_inventario  + "__"+ cantidad_carrito + "----"+stock_calculado);
                                            var url2 = "../app/controllers/ventas/actualizar_stock.php";
                                            $.get(url2,{id_producto:id_producto,stock_calculado:stock_calculado},function (datos) {
                                            });

                                        }

                                    }


                                   function borrar_venta(){

                                        var url = "../app/controllers/ventas/borrar_venta.php";
                                        $.get(url,{id_venta:id_venta,nro_venta:nro_venta},function (datos) {
                                            $('#btn_borrar_venta').html(datos);

                                        });
                                    }

                                    //alert(id_venta)
                                })
                            </script>

                        </div>
                    </div>
                </div>

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include ('../layout/mensajes.php'); ?>
    <?php include ('../layout/parte2.php'); ?>



    <script>
        $(function () {
            $("#example1").DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                    "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Productos",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscador:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true, "lengthChange": true, "autoWidth": false,

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });


        $(function () {
            $("#example2").DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Clientes",
                    "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Clientes",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscador:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true, "lengthChange": true, "autoWidth": false,

            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
    <!-- Modal para el formulario del cliente-->
    <div class="modal fade" id="modal-agregar_cliente">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #1d36b6;color: white">
                    <h4 class="modal-title">Nuevo Cliente </h4>
                    <div style="width: 20px;"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../app/controllers/clientes/guardar_clientes.php" method="post">
                        <div class="form-group">
                            <label for="">Nombre Cliente</label>
                            <input type="text" class="form-control" name="nombre_cliente">
                        </div>
                        <div class="form-group">
                            <label for="">Cedula Cliente</label>
                            <input type="text" class="form-control" name="nit_ci_cliente">
                        </div>
                        <div class="form-group">
                            <label for="">Celular Cliente</label>
                            <input type="text" class="form-control" name="celular_cliente">
                        </div>
                        <div class="form-group">
                            <label for="">Email Cliente</label>
                            <input type="email" class="form-control" name="email_cliente">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning btn-block">Guardar cliente</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->

    </div>