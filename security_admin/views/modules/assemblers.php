<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de Ensambladores </h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Ensambladores</li>
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
         <div class="card-header">
            <button class="btn btn-primary" data-toggle="modal" data-target='#modalAddAssembler'>Agregar ensamblador</button>
         </div>
         <div class="card-body ">
            <table class="table table-bordered dt-responsive table-striped tablas" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Nombres</th>
                     <th>Estado</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $item = null;
                  $value = null;
                  $assemblers = ControllerAssembler::ctrShowAssembler($item, $value);    
                  foreach ($assemblers as $key => $value) {
                     echo '<tr>
                              <td>' . ($key + 1) . '</td>
                              <td>' . $value['names'] . '</td>';
                     if ($value['status'] == 1) {
                        echo '<td><button class="btn btn-success btn-xs">Activado</button></td>';
                     } elseif ($value['status'] == 2) {
                        echo '<td><button class="btn btn-danger btn-xs">Desactivado</button></td>';
                     }
                     echo '<td>
                                 <div class="btn-group">
                                    <button class="btn btn-warning btnEditAssembler" idAssembler="' . $value['id'] . '" style="color:white;" data-toggle="modal" data-target="#modalEditAssembler"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btnDeleteAssembler" idAssembler="' . $value['id'] . '"><i class="fas fa-times"></i></button>
                                 </div>
                              </td>
                           </tr>';
                  }

                  ?>

               </tbody>
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

<!-- modalAddAssembler -->
<div class="modal fade" id="modalAddAssembler" tabindex="-1" role="dialog" aria-labelledby="modalAddAssembler" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Registrar nuevo ensamblador</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL NOMBRES -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-ship"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="namesAddAssembler" placeholder="Ingresar nombres" required>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            <?php
            $addAssembler = new ControllerAssembler;
            $addAssembler->ctrCreateAssembler();
            ?>
         </form>
      </div>
   </div>
</div>

<!-- modalEditAssembler -->
<div class="modal fade" id="modalEditAssembler" tabindex="-1" role="dialog" aria-labelledby="modalEditAssembler" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post">
            <div class="modal-header">
               <h5 class="modal-title">Editar ensamblador</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL NOMBRES -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" id="namesEditAssembler" name="namesEditAssembler" required>
                     <input type="hidden" id="idAssembler" name="idAssembler">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
            <?php
            $editAssembler = new ControllerAssembler();
            $editAssembler->ctrUpdateAssembler();
            ?>
         </form>
      </div>
   </div>
</div>

<?php
$deleteAssembler = new ControllerAssembler();
$deleteAssembler->ctrDeleteAssembler();
?>