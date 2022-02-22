<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de Proveedores </h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Proveedores</li>
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
            <button class="btn btn-primary" data-toggle="modal" data-target='#modalAddProvider'>Agregar proveedor</button>
         </div>
         <div class="card-body">
            <table class="table table-bordered dt-responsive table-striped tablas" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Razón social</th>
                     <th>Tipo Documento</th>
                     <th>N° Documento</th>
                     <th>Tipo proveedor</th>
                     <th>Dirección</th>
                     <th>Email</th>
                     <th>Teléfono</th>
                     <th>Estado</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $item = null;
                  $value = null;
                  $providers = ControllerProvider::ctrShowProvider($item, $value);    
                  foreach ($providers as $key => $value) {
                     echo '<tr>
                              <td>' . ($key + 1) . '</td>
                              <td>' . $value['name'] . '</td>
                              <td>' . $value['document'] . '</td>
                              <td>' . $value['document_number'] . '</td>
                              <td>' . $value['provider_type'] . '</td>
                              <td>' . $value['address'] . '</td>
                              <td>' . $value['email'] . '</td>
                              <td>' . $value['phone'] . '</td>
                              <td><button class="btn btn-success btn-xs">Activado</button></td>';

                     echo '<td>
                                 <div class="btn-group">
                                    <button class="btn btn-warning btnEditProvider" idProvider="' . $value['id'] . '" style="color:white;" data-toggle="modal" data-target="#modalEditProvider"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btnDeleteProvider" idProvider="' . $value['id'] . '"><i class="fas fa-times"></i></button>
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

<!-- modalAddProvider -->
<div class="modal fade" id="modalAddProvider" tabindex="-1" role="dialog" aria-labelledby="modalAddProvider" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Registrar nuevo proveedor</h5>
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
                     <input type="text" class="form-control input-lg" name="nameAddProvider" placeholder="Ingresar razón social" required>
                  </div>
               </div>
               <!-- ENTRADA PARA EL TIPO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="documentTypeAddProvider">
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
                     <input type="text" class="form-control input-lg" name="numberDocumentAddProvider" placeholder="Ingresar n° documento">
                  </div>
               </div>
               <!-- ENTRADA PARA EL TIPO PROVEEDOR -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fas fa-caravan"></i></span>
                     <select class="form-control input-lg" name="providerTypeAddProvider" required>
                        <option selected>Selecionar tipo de proveedor</option>
                        <option value="Exterior">Exterior</option>
                        <option value="Nacional">Nacional</option>
                     </select>
                  </div>
               </div>
               <!-- ENTRADA PARA LA DIRECCIÓN -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="addressAddProvider" placeholder="Ingresar dirección">
                  </div>
               </div>
               <!-- ENTRADA PARA EL EMAIL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                     </div>
                     <input type="email" class="form-control input-lg" name="emailAddProvider" id="emailAddProvider" placeholder="Ingresar email">
                  </div>
               </div>
               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="phoneAddProvider" placeholder="Ingresar teléfono">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            <?php
            $addProvider = new ControllerProvider;
            $addProvider->ctrCreateProvider();
            ?>
         </form>
      </div>
   </div>
</div>

<!-- modalEditProvider -->
<div class="modal fade" id="modalEditProvider" tabindex="-1" role="dialog" aria-labelledby="modalEditProvider" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data">
            <div class="modal-header">
               <h5 class="modal-title">Editar proveedor</h5>
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
                     <input type="text" class="form-control input-lg" name="nameEditProvider" id="nameEditProvider" required>
                  </div>
               </div>
               <!-- ENTRADA PARA EL TIPO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="documentTypeEditProvider">
                     <option value="" id="documentTypeEditProvider"></option>
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
                     <input type="text" class="form-control input-lg" name="numberDocumentEditProvider" id="numberDocumentEditProvider">
                  </div>
               </div>
               <!-- ENTRADA PARA EL TIPO PROVEEDOR -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fas fa-caravan"></i></span>
                     <select class="form-control input-lg" name="providerTypeEditProvider">
                     <option value="" id="providerTypeEditProvider"></option>
                     <option value="Exterior">Exterior</option>
                     <option value="Nacional">Nacional</option>
                     </select>
                  </div>
               </div>
               <!-- ENTRADA PARA LA DIRECCIÓN -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="addressEditProvider" id="addressEditProvider">
                  </div>
               </div>
               <!-- ENTRADA PARA EL EMAIL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                     </div>
                     <input type="email" class="form-control input-lg" name="emailEditProvider" id="emailEditProvider">
                  </div>
               </div>
               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="phoneEditProvider" id="phoneEditProvider">
                     <input type="hidden" name="idProvider" id="idProvider">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
            <?php
            $editProvider = new ControllerProvider();
            $editProvider->ctrEditProvider();
            ?>
         </form>
      </div>
   </div>
</div>

<?php
$deleteProvider = new ControllerProvider();
$deleteProvider->ctrDeleteProvider();
?>