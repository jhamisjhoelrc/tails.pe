<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de guías de remisión</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Guias de remisión</li>
               </ol>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </section>

   <!-- Main content -->
   <section class="content">
      <!-- Default box -->
      <div class="card">
         <div class="card-header ">
            <a href="addGuiaRemision" class="btn btn-primary">Agregar nueva guía</a>
         </div>
         <div class="card-body">
            <table class="table table-bordered dt-responsive table-striped tableGuias" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Comprobante guía</th>
                     <th>Comprobante relacionado</th>
                     <th>Motivo traslado</th>
                     <th>Fecha emisión</th>
                     <th>Fecha Inicio Traslado</th>
                     <th>Partida</th>
                     <th>Llegada</th>
                     <th>Estado Sunat</th>
                     <th></th>
                     <th>Acciones</th>
                  </tr>
               </thead>
            </table>
         </div>
         <!-- /.card-body -->
         <div class="card-footer">

         </div>
         <!-- /.card-footer-->
      </div>
      <!-- /.card -->
   </section>
   <!-- /.content -->
</div>

<!-- modalShowObservation -->
<div class="modal fade" id="modalShowObsGuia" tabindex="-1" role="dialog" aria-labelledby="modalShowObsGuia" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post">
            <div class="modal-header">
               <h5 class="modal-title">Ver observación</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL NOMBRE -->
               <div class="form-group">
                  <div class="input-group">
                     <textarea name="messageObsGuia" id="messageObsGuia" cols="100" rows="5"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">

            </div>
         </form>
      </div>
   </div>
</div>