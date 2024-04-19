<!doctype html>
<html>

<head>
  <title>Administración de categorías</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>

<body>

  <?php
  require("conexion.php");
  $con = retornarConexion();
  $consulta = mysqli_query($con, "insert into facturas() values ()")
    or die(mysqli_error($con));
  $codigofactura = mysqli_insert_id($con);
  ?>
<div class="container">
  <div class="text-center">
    <h2 class="mt-4"><i class="fas fa-file-invoice"></i> Registro de facturamiento</h2>
  </div>
  <div class="row mt-4">
    <div class="col-md">
      <div class="card p-3">
        <div class="form-group row">
          <label for="CodigoFactura" class="col-lg-3 col-form-label">Número de factura:</label>
          <div class="col-lg-3">
            <input type="text" disabled class="form-control" id="CodigoFactura" value="<?php echo $codigofactura; ?>">
          </div>
        </div>

        <div class="form-group row">
          <label for="Fecha" class="col-lg-3 col-form-label">Fecha de emisión:</label>
          <div class="col-lg-3">
            <input type="date" class="form-control" id="Fecha">
          </div>
        </div>

        <div class="form-group row">
          <label for="CodigoCliente" class="col-lg-3 col-form-label">Cliente:</label>
          <div class="col-lg-3">
            <select class="form-control" id="CodigoCliente">
              <?php
              $consulta = mysqli_query($con, "select codigo, nombre from clientes")
                or die(mysqli_error($con));

              $clientes = mysqli_fetch_all($consulta, MYSQLI_ASSOC);

              echo "<option value='0'>Seleccionar Cliente</option>";
              foreach ($clientes as $cli) {
                echo "<option value='" . $cli['codigo'] . "'>" . $cli['nombre'] . "</option>";
              }
              ?>
            </select>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
 
<div class="row mt-4">
  <div class="col-md">
    <div class="card p-3">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th><i class="fas fa-barcode"></i> Código de Artículo</th>
            <th><i class="fas fa-info-circle"></i> Descripción</th>
            <th class="text-right"><i class="fas fa-sort-numeric-up"></i> Cantidad</th>
            <th class="text-right"><i class="fas fa-dollar-sign"></i> Precio Unitario</th>
            <th class="text-right"><i class="fas fa-money-bill-alt"></i> Total</th>
            <th><i class="fas fa-cogs"></i> Acciones</th>
          </tr>
        </thead>
        <tbody id="DetalleFactura">

        </tbody>
      </table>
      <button type="button" id="btnAgregarProducto" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Agregar Producto</button><br>
      <button type="button" id="btnTerminarFactura" class="btn btn-primary"><i class="fas fa-check-circle me-1"></i>Facturar</button>
    </div>
  </div>
</div>

<!-- ModalProducto(Agregar) -->
<div class="modal fade" id="ModalProducto" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Agregar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label><i class="fas fa-shopping-cart"></i> Producto:</label>
          <select class="form-control" id="CodigoProducto">
            <?php
            $consulta = mysqli_query($con, "select codigo, descripcion, precio from productos")
              or die(mysqli_error($con));

            $productos = mysqli_fetch_all($consulta, MYSQLI_ASSOC);
            foreach ($productos as $pro) {
              echo "<option value='" . $pro['codigo'] . "'>" . $pro['descripcion'] . '  ($' . $pro['precio'] . ")</option>";
            }
            ?>
          </select>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label><i class="fas fa-list-ol"></i> Cantidad:</label>
            <input type="number" id="Cantidad" class="form-control" placeholder="" min="1">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnConfirmarAgregarProducto" class="btn btn-success">Agregar a la factura</button>
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<!-- ModalFinFactura -->
<div class="modal fade" id="ModalFinFactura" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="max-width: 600px" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4><i class="fas fa-tasks"></i> Acciones</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnConfirmarFactura" class="btn btn-success"><i class="fas fa-check-circle"></i></button>
        <button type="button" id="btnConfirmarImprimirFactura" class="btn btn-primary"><i class="fas fa-print"></i></button>
        <button type="button" id="btnConfirmarDescartarFactura" class="btn btn-danger"><i class="fas fa-times-circle"></i></button>
      </div>
    </div>
  </div>
</div>

<!-- ModalConfirmarBorrar -->
<div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="max-width: 600px" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4><i class="fas fa-exclamation-triangle text-danger"></i> ¿Realmente quiere borrarlo?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnConfirmarBorrado" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Confirmar</button>
        <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</button>
      </div>
    </div>
  </div>
</div>



  <script>
    document.addEventListener('DOMContentLoaded', function() {

      var producto;
      var cliente;

      document.getElementById('Fecha').valueAsDate = new Date();

      //Boton que muestra el diálogo de agregar producto
      $('#btnAgregarProducto').click(function() {
        LimpiarFormulario();
        $("#Cantidad").val("1");
        $("#ModalProducto").modal();
      });

      //Boton que agrega el producto al detalle
      $('#btnConfirmarAgregarProducto').click(function() {
        RecolectarDatosFormulario();
        $("#ModalProducto").modal('hide');
        if ($("#Cantidad").val() == "") { //Controlamos que no esté vacío la cantidad de productos
          alert('no puede estar vacío la cantidad de productos.');
          return;
        }
        EnviarInformacionProducto("agregar");
      });

      //Boton terminar factura
      $('#btnTerminarFactura').click(function() {
        $("#ModalFinFactura").modal();
      });

      //Boton confirmar factura
      $('#btnConfirmarFactura').click(function() {
        if ($('#CodigoCliente').val() == 0) {
          alert('Debe seleccionar un cliente');
          return;
        }
        RecolectarDatosCliente();
        EnviarInformacionFactura("confirmarfactura");
      });

    
      //Boton que descarta la factura generada borrando tanto en la tabla de facturas como detallefactura
      $('#btnConfirmarDescartarFactura').click(function() {
        RecolectarDatosCliente();
        EnviarInformacionFactura("confirmardescartarfactura");
      });

      //Boton confirmar factura y ademas genera pdf
      $('#btnConfirmarImprimirFactura').click(function() {
        if ($('#CodigoCliente').val() == 0) {
          alert('Debe seleccionar un cliente');
          return;
        }
        RecolectarDatosCliente();
        EnviarInformacionFacturaImprimir("confirmarfactura");
      });

      function RecolectarDatosFormulario() {
        producto = {
          codigoproducto: $('#CodigoProducto').val(),
          cantidad: $('#Cantidad').val()
        };
      }

      function RecolectarDatosCliente() {
        cliente = {
          codigocliente: $('#CodigoCliente').val(),
          fecha: $('#Fecha').val()
        };
      }

      //Funciones AJAX para enviar y recuperar datos del servidor
      //******************************************************* 
      function EnviarInformacionProducto(accion) {
        $.ajax({
          type: 'POST',
          url: 'procesar.php?accion=' + accion + '&codigofactura=' + <?php echo $codigofactura ?>,
          data: producto,
          success: function(msg) {
            RecuperarDetalle();
          },
          error: function() {
            alert("Hay un error ..");
          }
        });
      }

      function EnviarInformacionFactura(accion) {
        $.ajax({
          type: 'POST',
          url: 'procesar.php?accion=' + accion + '&codigofactura=' + <?php echo $codigofactura ?>,
          data: cliente,
          success: function(msg) {
            window.location = 'index.php';
          },
          error: function() {
            alert("Hay un error ..");
          }
        });
      }

      function EnviarInformacionFacturaImprimir(accion) {
        $.ajax({
          type: 'POST',
          url: 'procesar.php?accion=' + accion + '&codigofactura=' + <?php echo $codigofactura ?>,
          data: cliente,
          success: function(msg) {
            window.open('pdffactura.php?' + '&codigofactura=' + <?php echo $codigofactura ?>, '_blank');
            window.location = 'index.php';
          },
          error: function() {
            alert("Hay un error ..");
          }
        });
      }

      function LimpiarFormulario() {
        $('#Cantidad').val('');
      }

    });

    //Se ejecuta cuando se presiona un boton de borrar un item del detalle
    var cod;

    function borrarItem(coddetalle) {
      cod = coddetalle;
      $("#ModalConfirmarBorrar").modal();
    }

    $('#btnConfirmarBorrado').click(function() {
      $("#ModalConfirmarBorrar").modal('hide');
      $.ajax({
        type: 'POST',
        url: 'borrarproductodetalle.php?codigo=' + cod,
        success: function(msg) {
          RecuperarDetalle();
        },
        error: function() {
          alert("Hay un error ..");
        }
      });
    });

    function RecuperarDetalle() {
      $.ajax({
        type: 'GET',
        url: 'recuperardetalle.php?codigofactura=' + <?php echo $codigofactura ?>,
        success: function(datos) {
          document.getElementById('DetalleFactura').innerHTML = datos;
        },
        error: function() {
          alert("Hay un error ..");
        }

      });

    }
  </script>
</body>

</html>