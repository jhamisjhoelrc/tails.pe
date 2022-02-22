<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Pago a proveedores</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Pago a proveedores</li>
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
            <button class="btn btn-primary" data-toggle="modal" data-target='#modalAddSeller'>Agregar pago</button>
         </div>
         <div class="card-body">
            <table class="table table-bordered dt-responsive table-striped tablas" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Proveedor</th>
                     <th>Importe acumulado</th>
                     <th>Importe pagado</th>
                     <th>Diferencia</th>
                     <th>Fecha último pago</th>
                     <th>Estado</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
               <tbody>
                    <tr>
                        <td>1</td>
                        <td>POMO</td>
                        <td>$ 47000.00</td>
                        <td>$ 7000.00</td>
                        <td>$ 40000.00</td>
                        <td>2021-04-19</td>
                        <td><button class="btn btn-warning btn-xs">Por pagar</button></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-info" style="color:white;" data-toggle="modal" data-target="#modalEditSeller"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-warning" style="color:white;" data-toggle="modal" data-target="#modalEditSeller"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger"><i class="fas fa-times"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>GUANGYU</td>
                        <td>$ 17000.00</td>
                        <td>$ 17000.00</td>
                        <td>$ 0.00</td>
                        <td>2021-04-10</td>
                        <td><button class="btn btn-success btn-xs">Pagado</button></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-info" style="color:white;" data-toggle="modal" data-target="#modalEditSeller"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-warning" style="color:white;" data-toggle="modal" data-target="#modalEditSeller"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger"><i class="fas fa-times"></i></button>
                            </div>
                        </td>
                    </tr>
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

<!-- modalAddSeller -->
<div class="modal fade" id="modalAddSeller" tabindex="-1" role="dialog" aria-labelledby="modalAddSeller" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Registrar nuevo vendedor</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL NOMBRE -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="nameAddSeller" placeholder="Ingresar nombres completos" required>
                  </div>
               </div>
               <!-- ENTRADA PARA EL EMAIL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                     </div>
                     <input type="email" class="form-control input-lg" name="emailAddSeller" id="emailAddSeller" placeholder="Ingresar el email" required>
                  </div>
               </div>
               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="phoneAddSeller" placeholder="Ingresar teléfono">
                  </div>
               </div>

               <!-- ENTRADA PARA EL TIPO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="documentTypeAddSeller">
                        <option value="">Selecionar tipo de documento</option>
                        <?php
                        $table = 'documents_type';
                        $item = null;
                        $value = null;
                        $response =  ControllerMant::ctrShowMant($table, $item, $value);
                        foreach ($response as $key => $value) {
                           echo '<option value="' . $value['id'] . '">' . $value['description'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <!-- ENTRADA PARA EL NUMERO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="numberDocumentAddSeller" placeholder="Ingresar n° documento" required>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            <?php
            $addSeller = new ControllerSeller;
            $addSeller->ctrCreateSeller();
            ?>
         </form>
      </div>
   </div>
</div>

<!-- modalEditSeller -->
<div class="modal fade" id="modalEditSeller" tabindex="-1" role="dialog" aria-labelledby="modalEditSeller" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data">
            <div class="modal-header">
               <h5 class="modal-title">Editar vendedor</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL NOMBRE -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" id="nameEditSeller" name="nameEditSeller" required>
                  </div>
               </div>
               <!-- ENTRADA PARA EL EMAIL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                     </div>
                     <input type="email" class="form-control input-lg" id="emailEditSeller" name="emailEditSeller" readonly>
                  </div>
               </div>
               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" id="phoneEditSeller" name="phoneEditSeller">
                  </div>
               </div>
               <!-- ENTRADA PARA EL TIPO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="documentTypeEditSeller">
                        <option value="" id="documentTypeEditSeller"></option>
                        <?php
                        $table = 'documents_type';
                        $item = null;
                        $value = null;
                        $response =  ControllerMant::ctrShowMant($table, $item, $value);
                        foreach ($response as $key => $value) {
                           echo '<option value="' . $value['id'] . '">' . $value['description'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
               </div>
               <!-- ENTRADA PARA EL NUMERO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" id="numberDocumentEditSeller" name="numberDocumentEditSeller" required>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
            <?php
            $editSeller = new ControllerSeller();
            $editSeller->ctrEditSeller();
            ?>
         </form>
      </div>
   </div>
</div>

<?php
$deleteSeller = new ControllerSeller();
$deleteSeller->ctrDeleteSeller();
?>