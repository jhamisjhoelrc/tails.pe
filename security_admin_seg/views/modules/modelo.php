<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de Modelos </h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Modelos</li>
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
            <button class="btn btn-primary" data-toggle="modal" data-target='#modalAddModel'>Agregar modelo</button>
         </div>
         <div class="card-body ">
            <table class="table table-bordered dt-responsive table-striped tablas" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Nombre DUA</th>
                     <th>Nombre Lucki</th>
                     <th>Marca</th>
                     <th>Categoría</th>
                     <th>Estado</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $item = null;
                  $value = null;
                  $models = ControllerModel::ctrShowModel($item, $value);    
                  foreach ($models as $key => $value) {
                     echo '<tr>
                              <td>' . ($key + 1) . '</td>
                              <td>' . $value['name_dua'] . '</td>
                              <td>' . $value['name_lucki'] . '</td>
                              <td>' . $value['brand'] . '</td>
                              <td>' . $value['category'] . '</td>';
                     if ($value['status'] == 1) {
                        echo '<td><button class="btn btn-success btn-xs">Activado</button></td>';
                     } elseif ($value['status'] == 2) {
                        echo '<td><button class="btn btn-danger btn-xs">Desactivado</button></td>';
                     }
                     echo '<td>
                                 <div class="btn-group">
                                    <button class="btn btn-warning btnEditModel" idModel="' . $value['id'] . '" style="color:white;" data-toggle="modal" data-target="#modalEditModel"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btnDeleteModel" idModel="' . $value['id'] . '"><i class="fas fa-times"></i></button>
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

<!-- modalAddModel -->
<div class="modal fade" id="modalAddModel" tabindex="-1" role="dialog" aria-labelledby="modalAddModel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Registrar nuevo modelo</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL NOMBRE DUA -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-ship"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="nameduaAddModel" placeholder="Ingresar modelo DUA" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL NOMBRE LUCKI -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="nameluckiAddModel" placeholder="Ingresar modelo LUCKI" required>
                  </div>
               </div>

               <!-- ENTRADA PARA LA MARCA -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="brandAddModel">
                        <option value="">Selecionar marca </option>
                        <?php
                        $table = 'brands';
                        $item = null;
                        $value = null;
                        $response =  ControllerMant::ctrShowMant($table, $item, $value);
                        foreach ($response as $key => $value) {
                           echo '<option value="' . $value['id'] . '">' . $value['descripction'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <!-- ENTRADA PARA LA CATEGORÍA -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fas fa-exchange-alt"></i></span>
                     <select class="form-control input-lg" name="categoryAddModel">
                        <option value="">Selecionar categoría </option>
                        <?php
                        $table = 'categories';
                        $item = null;
                        $value = null;
                        $response =  ControllerMant::ctrShowMant($table, $item, $value);
                        foreach ($response as $key => $value) {
                           echo '<option value="' . $value['id'] . '">' . $value['descripction'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
               </div>

            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            <?php
            $addModel = new ControllerModel;
            $addModel->ctrCreateModel();
            ?>
         </form>
      </div>
   </div>
</div>

<!-- modalEditModel -->
<div class="modal fade" id="modalEditModel" tabindex="-1" role="dialog" aria-labelledby="modalEditModel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post">
            <div class="modal-header">
               <h5 class="modal-title">Editar modelo</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL NOMBRE DUA -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" id="nameduaEditModel" name="nameduaEditModel" required>
                     <input type="hidden" id="idModel" name="idModel">
                  </div>
               </div>

               <!-- ENTRADA PARA EL NOMBRE LUCKI -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" id="nameluckiEditModel" name="nameluckiEditModel" required>
                  </div>
               </div>

               <!-- ENTRADA PARA LA MARCA -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="brandEditModel">
                        <option value="" id="brandEditModel"></option>
                        <?php
                        $table = 'brands';
                        $item = null;
                        $value = null;
                        $response =  ControllerMant::ctrShowMant($table, $item, $value);
                        foreach ($response as $key => $value) {
                           echo '<option value="' . $value['id'] . '">' . $value['descripction'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <!-- ENTRADA PARA LA CATEGORÍA -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="categoryEditModel">
                     <option value="" id="categoryEditModel"></option>
                        <?php
                        $table = 'categories';
                        $item = null;
                        $value = null;
                        $response =  ControllerMant::ctrShowMant($table, $item, $value);
                        foreach ($response as $key => $value) {
                           echo '<option value="' . $value['id'] . '">' . $value['descripction'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
            <?php
            $editModel = new ControllerModel();
            $editModel->ctrUpdateModel();
            ?>
         </form>
      </div>
   </div>
</div>

<?php
$deleteModel = new ControllerModel();
$deleteModel->ctrDeleteModel();
?>