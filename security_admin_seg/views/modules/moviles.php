<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de moviles</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Moviles</li>
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
            <!-- <a href="addNational" class="btn btn-primary">Agregar nueva compra nacional</a> -->
         </div>
         <div class="card-body">
            <table class="table table-bordered dt-responsive table-striped tableMoviles" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Guía</th>
                     <th>Marca</th>
                     <th>Modelo</th>
                     <th>Chasis</th>
                     <th>Motor</th>
                     <th>Color</th>
                     <th>Sucursal</th>
                     <th>Condición</th>
                     <th>Estado</th>
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

<!-- modalEditAseembler -->
<div class="modal fade" id="modalEditAseembler" tabindex="-1" role="dialog" aria-labelledby="modalEditAseembler" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data">
            <div class="modal-header">
               <h5 class="modal-title">Modificar movil</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body d-flex flex-wrap">
               <!-- ENTRADA PARA EL MODELO -->
               <div class="form-group col-md-6">
                  <label for="modelAssembler">Modelo</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-caravan"></i></span>
                     </div>
                     <input style="background-color:transparent;" type="text" class="form-control input-lg" name="modelAssembler" id="modelAssembler" readonly>
                  </div>
               </div>
               <!-- ENTRADA PARA EL MOTOR -->
               <div class="form-group col-md-6">
                  <label for="motorAssembler">Motor</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-gg-circle"></i></span>
                     </div>
                     <input style="background-color:transparent;" type="text" class="form-control input-lg" name="motorAssembler" id="motorAssembler" readonly>
                  </div>
               </div>
               <!-- ENTRADA PARA EL CHASIS -->
               <div class="form-group col-md-6">
                  <label for="chasisAssembler">Chasis</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                     </div>
                     <input style="background-color:transparent;" type="text" class="form-control input-lg" name="chasisAssembler" id="chasisAssembler" readonly>
                  </div>
               </div>
               <!-- ENTRADA PARA LA FECHA ENSAMBLADO -->
               <div class="form-group col-md-6">
                  <label for="dateSale">Fecha ensamblado</label>
                  <div class="input-group date" id="dateSale" data-target-input="nearest">
                     <div class="input-group-append" data-target="#dateSale" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                     </div>
                     <input type="text" class="form-control datetimepicker-input" name="dateAssembler" id="dateAssembler" data-target="#dateSale" required />
                  </div>
               </div>
               <!-- ENTRADA PARA SELECCIONAR ENSAMBLADOR -->
               <div class="form-group col-md-6">
                  <label for="nameAssembler">Nombre ensamblador</label>
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fas fa-user-plus"></i></span>
                     <select class="form-control input-lg" style="width: 100%;" name="nameAssembler" id="nameAssembler" required>
                        <option id="nameAssemblerAsign"></option>
                        <?php
                        $assembler = ControllerMant::ctrShowMant('assemblers', null, null);
                        foreach ($assembler as $key => $value) {
                           echo '<option value="' . $value['id'] . '">' . $value['names'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
               </div>
               <!-- ENTRADA PARA EL DETALLE DEL ENSAMBLADOR -->
               <div class="form-group col-md-6">
                  <label for="detailAssembler">Detalle</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-comment-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="detailAssembler" id="detailAssembler">
                     <input type="hidden" name="idMovil" id="idMovil">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <input type="submit" class="btn btn-primary" value="Guardar">
            </div>
            <?php
            $saveAssembler = new ControllerMovil;
            $saveAssembler->ctrUpdateAssembler();
            ?>
         </form>
      </div>
   </div>
</div>

<?php
$deleteMoviles = new ControllerMovil();
$deleteMoviles->ctrDeleteMovil();
?>