<?php
    require('template/header.php');
    require("conexion.php");
    $con = retornarConexion();
    $consulta = mysqli_query(
      $con,
      "select 
              fact.codigo as codigo,
              date_format(fecha,'%d/%m/%Y') as fecha,
              nombre,
              round(sum(deta.precio*deta.cantidad),2) as importefactura
          from facturas as fact 
          join clientes as cli on cli.codigo=fact.codigocliente
          join detallefactura as deta on deta.codigofactura=fact.codigo
          group by deta.codigofactura
          order by codigo desc"
    )
      or die(mysqli_error($con));

    $filas = mysqli_fetch_all($consulta, MYSQLI_ASSOC);

?>

    <div class="container">
      <h1 class="mt-3">Listado de Facturas Registrada <i class="fas fa-file-invoice"></i></h1>
      <div class="row justify-content-end">
        <div class="col-auto">
          <button type="button" id="btnNuevaFactura" class="btn btn-primary m-3"><i class="fas fa-plus"></i></button>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <table class="table table-striped">
            <thead>
              <tr>
                <th><i class="fas fa-file-alt"></i> Factura</th>
                <th><i class="fas fa-user"></i> Cliente</th>
                <th><i class="fas fa-calendar-alt"></i> Fecha</th>
                <th><i class="fas fa-dollar-sign"></i> Precio Total </th>
                <th><i class="fas fa-cogs"></i> Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($filas as $fila) {
                ?>
                <tr>
                  <td><?php echo $fila['codigo'] ?></td>
                  <td><?php echo $fila['nombre'] ?></td>
                  <td><?php echo $fila['fecha'] ?></td>
                  <td class="text-right"><?php echo '$' . number_format($fila['importefactura'], 2, ',', '.'); ?></td>
                  <td class="text-right">
                    <a class="btn btn-primary btn-sm botonimprimir" role="button" href="#" data-codigo="<?php echo $fila['codigo'] ?>"><i class="fas fa-print"></i></a>
                    <a class="btn btn-danger btn-sm botonborrar" role="button" href="#" data-codigo="<?php echo $fila['codigo'] ?>"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ModalConfirmarBorrar -->
    <div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
      <div class="modal-dialog" style="max-width: 400px" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4><i class="fas fa-exclamation-triangle mr-2 text-danger"></i> Confirmar Borrado</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>¿Realmente desea borrar la factura?</p>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnConfirmarBorrado" class="btn btn-danger"><i class="fas fa-trash-alt mr-2"></i> Confirmar</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fas fa-times mr-2"></i> Cancelar</button>
          </div>
        </div>
      </div>
    </div>


<script>
  document.addEventListener("DOMContentLoaded", function() {

    $('#btnNuevaFactura').click(function() {
        window.location = 'facturacion.php';
      });

      var codigofactura;

      $('.botonborrar').click(function() {
        codigofactura = $(this).get(0).dataset.codigo;
        $("#ModalConfirmarBorrar").modal();
      });

      $('#btnConfirmarBorrado').click(function() {
        window.location = 'borrarfactura.php?codigofactura=' + codigofactura;
      });

      $('.botonimprimir').click(function() {
        window.open('pdffactura.php?' + '&codigofactura=' + $(this).get(0).dataset.codigo, '_blank');
      });

  });
</script>


<?php
require('template/footer.php');
?>