<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de Sucursales </h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Sucursales</li>
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
            <button class="btn btn-primary" data-toggle="modal" data-target='#modalAddSubsidiary'>Agregar sucursal</button>
         </div>
         <div class="card-body">
            <table class="table table-bordered dt-responsive table-striped tablas" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Nombre Local</th>
                     <th>Dirección</th>
                     <th>Teléfono</th>
                     <th>Responsable</th>
                     <th>Distrito</th>
                     <th>Provincia</th>
                     <th>Departamento</th>
                     <th>Estado</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $item = null;
                  $value = null;
                  $subsidiarys = ControllerSubsidiary::ctrShowSubsidiary($item, $value);
                  foreach ($subsidiarys as $key => $value) {
                     echo '<tr>
                              <td>' . ($key + 1) . '</td>
                              <td>' . $value['description'] . '</td>
                              <td>' . $value['address'] . '</td>
                              <td>' . $value['phone'] . '</td>
                              <td>' . $value['responsible'] . '</td>
                              <td>' . $value['district'] . '</td>
                              <td>' . $value['province'] . '</td>
                              <td>' . $value['department'] . '</td>
                              <td><button class="btn btn-success btn-xs btnActivateSubsidiary" idSubsidiary="' . $value['id'] . '" statusSubsidiary="2">Activado</button></td>';

                     echo '<td>
                                 <div class="btn-group">
                                    <button class="btn btn-warning btnEditSubsidiary" idSubsidiary="' . $value['id'] . '" style="color:white;" data-toggle="modal" data-target="#modalEditSubsidiary"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btnDeleteSubsidiary" idSubsidiary="' . $value['id'] . '"><i class="fas fa-times"></i></button>
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

<!-- modalAddSubsidiary -->
<div class="modal fade" id="modalAddSubsidiary" tabindex="-1" role="dialog" aria-labelledby="modalAddSubsidiary" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Registrar nueva sucursal</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL NOMBRE LOCAL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-store-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="descriptionAddSubsidiary" placeholder="Ingresar nombre de local" required>
                  </div>
               </div>
               <!-- ENTRADA PARA LA DIRECCIÓN -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="addressAddSubsidiary" id="addressAddSubsidiary" placeholder="Ingresar dirección">
                  </div>
               </div>
               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="phoneAddSubsidiary" placeholder="Ingresar teléfono">
                  </div>
               </div>

               <!-- ENTRADA PARA EL RESPONSABLE -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="responsibleAddSubsidiary" placeholder="Ingresar responsable">
                  </div>
               </div>

               <!-- ENTRADA PARA EL DISTRITO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg select2bs4 districtSubsidiary" style="width: 100%;" name="districtAddSubsidiary" required>
                        <option value="">Selecionar distrito</option>
                        <?php
                        $table = 'ubigeo_peru_districts';
                        $item = null;
                        $value = null;
                        $response =  ControllerMant::ctrShowMant($table, $item, $value);
                        foreach ($response as $key => $value) {
                           echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
               </div>
               <!-- ENTRADA PARA LA PROVINCIA -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg provinceSubsidiary" name="provinceAddSubsidiary" placeholder="Provincia" readonly>
                  </div>
               </div>
               <!-- ENTRADA PARA EL DEPARTAMENTO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg departmentSubsidiary" name="departmentAddSubsidiary" placeholder="Departamento" readonly>
                  </div>
               </div>

            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            <?php
            $addSubsidiary = new ControllerSubsidiary;
            $addSubsidiary->ctrCreateSubsidiary();
            ?>
         </form>
      </div>
   </div>
</div>

<!-- modalEditSubsidiary -->
<div class="modal fade" id="modalEditSubsidiary" tabindex="-1" role="dialog" aria-labelledby="modalEditSubsidiary" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data">
            <div class="modal-header">
               <h5 class="modal-title">Editar sucursal</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA EL NOMBRE LOCAL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-store-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="descriptionEditSubsidiary" id="descriptionEditSubsidiary" required>
                  </div>
               </div>
               <!-- ENTRADA PARA LA DIRECCIÓN -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="addressEditSubsidiary" id="addressEditSubsidiary" placeholder="Ingresar dirección">
                  </div>
               </div>
               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="phoneEditSubsidiary" id="phoneEditSubsidiary">
                  </div>
               </div>

               <!-- ENTRADA PARA EL RESPONSABLE -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="responsibleEditSubsidiary" id="responsibleEditSubsidiary">
                  </div>
               </div>

               <!-- ENTRADA PARA EL DISTRITO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg districtSubsidiary" style="width: 100%;" name="districtEditSubsidiary" required>
                        <option id="districtEditSubsidiary" value=""></option>
                        <?php
                        $table = 'ubigeo_peru_districts';
                        $item = null;
                        $value = null;
                        $response =  ControllerMant::ctrShowMant($table, $item, $value);
                        foreach ($response as $key => $value) {
                           echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                        }
                        ?>
                     </select>
                  </div>
               </div>
               <!-- ENTRADA PARA LA PROVINCIA -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg provinceSubsidiary" name="provinceEditSubsidiary" readonly>
                  </div>
               </div>
               <!-- ENTRADA PARA EL DEPARTAMENTO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg departmentSubsidiary" name="departmentEditSubsidiary" readonly>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Actualizar</button>
               <input type="hidden" name="idSubsidiary" id="idSubsidiary">
            </div>
            <?php
            $editSubsidiary = new ControllerSubsidiary();
            $editSubsidiary->ctrEditSubsidiary();
            ?>
         </form>
      </div>
   </div>
</div>

<?php
$deleteSubsidiary = new ControllerSubsidiary();
$deleteSubsidiary->ctrDeleteSubsidiary();
?>