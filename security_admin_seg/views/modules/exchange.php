<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de tipo de cambio</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Tipo cambio</li>
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
            <button class="btn btn-primary" data-toggle="modal" data-target='#modalAddPrincipalExchange'>Agregar tipo de cambio</button>
         </div>
         <div class="card-body">
            <table class="table table-bordered dt-responsive table-striped tableExchange" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Valor de cambio</th>
                     <th>Fecha de cambio</th>
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

<!-- modalAddPrincipalExchange -->
<div class="modal fade" id="modalAddPrincipalExchange" tabindex="-1" role="dialog" aria-labelledby="modalAddPrincipalExchange" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Registrar tipo de cambio</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL VALOR DE CAMBIO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="valueExchangePrincipal" placeholder="0.00" required>
                  </div>
               </div>
               <!-- ENTRADA PARA LA FECHA DE CAMBIO -->
               <div class="form-group">
                  <div class="input-group date" id="dateLlegada" data-target-input="nearest">
                     <div class="input-group-prepend" data-target="#dateLlegada" data-toggle="datetimepicker">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                     </div>
                     <input type="text" class="form-control datetimepicker-input" name="dateExchangePrincipal" id="dateExchangePrincipal" data-target="#dateLlegada" required/>
                  </div>
               </div>

            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            <?php
            $addExchangePrincipal = new ControllerExchange;
            $addExchangePrincipal->ctrCreateExchangePrincipal();
            ?>
         </form>
      </div>
   </div>
</div>

<!-- modalEditExchange -->
<div class="modal fade" id="modalEditExchange" tabindex="-1" role="dialog" aria-labelledby="modalEditExchange" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Actualizar tipo de cambio</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL VALOR DE CAMBIO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="valueExchangeEdit" id="valueExchangeEdit" required>
                  </div>
               </div>
               <!-- ENTRADA PARA LA FECHA DE CAMBIO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="dateExchangeEdit" id="dateExchangeEdit" readonly>
                     <input type="hidden" name="idExchange" id="idExchange">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
            <?php
            $editExchange = new ControllerExchange;
            $editExchange->ctrUpdateExchange();
            ?>
         </form>
      </div>
   </div>
</div>
