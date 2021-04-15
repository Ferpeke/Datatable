<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title class="card-title"></title>
    <?php require_once "scripts.php"; ?>
</head>

<body class="color-body">
    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Tablas dinamicas con databale y php
                    </div>
                    <div class="card-body">
                        <span class="btn btn-info" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
                            Agregar nuevo <span class="fas fa-plus-circle"></span>
                        </span>
                        <hr>
                        <div id="tablaDatatable"></div>
                    </div>
                    <div class="card-footer text-muted">
                        By FerPeke
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agrega nuevos juegos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmnuevo">
                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" id="nombre" name="nombre">
                        <label>Año</label>
                        <input type="text" class="form-control input-sm" id="anio" name="anio">
                        <label>Empresa</label>
                        <input type="text" class="form-control input-sm" id="empresa" name="empresa">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnAgregarnuevo" class="btn btn-primary">Agregar nuevo</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar juego</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmnuevoU">
                        <input type="text" hidden="" id="idjuego" name="idjuego">
                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
                        <label>Año</label>
                        <input type="text" class="form-control input-sm" id="anioU" name="anioU">
                        <label>Empresa</label>
                        <input type="text" class="form-control input-sm" id="empresaU" name="empresaU">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#btnAgregarnuevo').click(function() {
            datos = $('#frmnuevo').serialize();

            $.ajax({
                type: "POST",
                data: datos,
                url: "procesos/agregar.php",
                success: function(r) {
                    if (r == 1) {
                        
                        $('#frmnuevo')[0].reset();
                        $('#tablaDatatable').load('tabla.php');
                        alertify.success("agregado con exito :D");
                    } else {
                        console.log(r);
                        alertify.error("Fallo al agregar :(");
                    }
                }
            });
        });

        $('#btnActualizar').click(function() {
            datos = $('#frmnuevoU').serialize();

            $.ajax({
                type: "POST",
                data: datos,
                url: "procesos/actualizar.php",
                success: function(r) {
                    if (r == 1) {
                        $('#tablaDatatable').load('tabla.php');
                        alertify.success("actualizado con exito :D");
                    } else {
                        alertify.error("Fallo al actualizar :(");
                    }
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#tablaDatatable').load('tabla.php');
    });
</script>
<script>
    function agregarFrmActualizar(idjuego) {
        $.ajax({
            type: "POST",
            data: "idjuego=" + idjuego,
            url: "procesos/obtenDatos.php",
            success: function(r) {
                datos = jQuery.parseJSON(r);
                $('#idjuego').val(datos['id_juego']);
                $('#nombreU').val(datos['nombre']);
                $('#anioU').val(datos['anio']);
                $('#empresaU').val(datos['empresa']);
            }
        });
    }

    function eliminarDatos(idjuego) {
        alertify.confirm('Eliminar juego', '¿Seguro que deseas eliminarlo?', function() {
            $.ajax({
                type: "POST",
                data: "idjuego=" + idjuego,
                url: "procesos/eliminar.php",
                success: function(r) {
                    if(r == 1) {
                        $('#tablaDatatable').load('tabla.php');
                        alertify.success("Eliminado con éxito..!");
                    } else {
                        alertify.error("No se elimino con éxito");
                    }
                }
            });
        }, function() {
            alertify.error('Cancel');
        });
    }
</script>