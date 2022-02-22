<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de Usuarios </h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Usuarios</li>
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
            <button class="btn btn-primary" data-toggle="modal" data-target='#modalAddUser'>Agregar usuario</button>
         </div>
         <div class="card-body ">
            <table class="table table-bordered dt-responsive table-striped tablas" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Nombres</th>
                     <th>Apellidos</th>
                     <th>Email</th>
                     <th>Teléfono</th>
                     <th>Tipo Documento</th>
                     <th>N° Documento</th>
                     <th>Perfil</th>
                     <th>Foto</th>
                     <th>Sucursal</th>
                     <th>Estado</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $item = null;
                  $value = null;
                  $users = ControllerUser::ctrShowUser($item, $value);    
                  foreach ($users as $key => $value) {
                     echo '<tr>
                              <td>' . ($key + 1) . '</td>
                              <td>' . $value['names'] . '</td>
                              <td>' . $value['last_name'] . '</td>
                              <td>' . $value['email'] . '</td>
                              <td>' . $value['phone'] . '</td>
                              <td>' . $value['document'] . '</td>
                              <td>' . $value['document_number'] . '</td>
                              <td>' . $value['profile'] . '</td>';
                     if ($value['photo'] != null) {
                        echo '<td><img src="' . $value['photo'] . '" class="img-thumbnail" width="35px" alt=""></td>';
                     } else {
                        echo '<td><img src="views/dist/img/users/userDefault.jpg" class="img-thumbnail" width="35px" alt=""></td>';
                     }
                     echo '<td>' . $value['subsidiary'] . '</td>';
                     if ($value['status'] == 1) {
                        echo '<td><button class="btn btn-success btn-xs btnActivateUser" idUser="' . $value['id'] . '" statusUser="2">Activado</button></td>';
                     } elseif ($value['status'] == 2) {
                        echo '<td><button class="btn btn-danger btn-xs btnActivateUser" idUser="' . $value['id'] . '" statusUser="1">Desactivado</button></td>';
                     }

                     echo '<td>
                                 <div class="btn-group">
                                    <button class="btn btn-warning btnEditUser" idUser="' . $value['id'] . '" style="color:white;" data-toggle="modal" data-target="#modalEditUser"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btnDeleteUser" idUser="' . $value['id'] . '" photo="' . $value['photo'] . '" email="' . $value['email'] . '"><i class="fas fa-times"></i></button>
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

<!-- modalAddUser -->
<div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog" aria-labelledby="modalAddUser" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Registrar nuevo usuario</h5>
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
                     <input type="text" class="form-control input-lg" name="nameAddUser" placeholder="Ingresar nombres" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL APELLIDO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="lastNameAddUser" placeholder="Ingresar apellidos" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL EMAIL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                     </div>
                     <input type="email" class="form-control input-lg" name="emailAddUser" id="emailAddUser" placeholder="Ingresar el email" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL PASSWORD -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                     </div>
                     <input type="password" class="form-control input-lg" name="passwordAddUser" placeholder="Ingresar el password" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="phoneAddUser" placeholder="Ingresar teléfono">
                  </div>
               </div>

               <!-- ENTRADA PARA EL TIPO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="documentTypeAddUser">
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
                     <input type="text" class="form-control input-lg" name="numberDocumentAddUser" placeholder="Ingresar n° documento" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL PERFIL -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fa fa-users"></i></span>
                     <select class="form-control input-lg" name="profileAddUser">
                        <option value="">Selecionar perfil</option>
                        <?php
                        $table = 'profiles';
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
               <!-- ENTRADA PARA LA SUCURSAL -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fa fa-home"></i></span>
                     <select class="form-control input-lg" name="subsidiaryAddUser">
                        <option value="">Selecionar sucursal</option>
                        <?php
                        $table = 'subsidiarys';
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

               <!-- ENTRADA PARA LA FOTO -->
               <div class="form-group">
                  <div class="panel">SUBIR FOTO</div>
                  <input type="file" class="newPhoto" name="newPhoto">
                  <p class="help-block">Tamaño recomendado 128 x128 y peso máximo de 2MB</p>
                  <img src="views/dist/img/users/userDefault.jpg" class="img-fluid preview" width="100" alt="Foto de usuario">
               </div>

            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            <?php
            $addUser = new ControllerUser;
            $addUser->ctrCreateUser();
            ?>
         </form>
      </div>
   </div>
</div>

<!-- modalEditUser -->
<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="modalEditUser" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data">
            <div class="modal-header">
               <h5 class="modal-title">Editar usuario</h5>
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
                     <input type="text" class="form-control input-lg" id="nameEditUser" name="nameEditUser" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL APELLIDO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" id="lastNameEditUser" name="lastNameEditUser" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL EMAIL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                     </div>
                     <input type="email" class="form-control input-lg" id="emailEditUser" name="emailEditUser" readonly>
                  </div>
               </div>

               <!-- ENTRADA PARA EL PASSWORD -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                     </div>
                     <input type="password" class="form-control input-lg" name="passwordEditUser" placeholder="Escriba la nueva contraseña">
                     <input type="hidden" id="passwordPresent" name="passwordPresent">
                  </div>
               </div>

               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" id="phoneEditUser" name="phoneEditUser">
                  </div>
               </div>

               <!-- ENTRADA PARA EL TIPO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="documentTypeEditUser">
                        <option value="" id="documentTypeEditUser"></option>
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
                     <input type="text" class="form-control input-lg" id="numberDocumentEditUser" name="numberDocumentEditUser" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL PERFIL -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fa fa-users"></i></span>
                     <select class="form-control input-lg" name="profileEditUser">
                        <option value="" id="profileEditUser"></option>
                        <?php
                        $table = 'profiles';
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

               <!-- ENTRADA PARA LA SUCURSAL -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fa fa-home"></i></span>
                     <select class="form-control input-lg" name="subsidiaryEditUser">
                        <option value="" id="subsidiaryEditUser"></option>
                        <?php
                        $table = 'subsidiarys';
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

               <!-- ENTRADA PARA LA FOTO -->
               <div class="form-group">
                  <div class="panel">SUBIR FOTO</div>
                  <input type="file" class="newPhoto" name="editPhoto">
                  <p class="help-block">Tamaño recomendado 128 x128 y peso máximo de 2MB</p>
                  <img src="views/dist/img/users/userDefault.jpg" class="img-fluid preview" width="100">
                  <input type="hidden" name="photoPresent" id="photoPresent">
               </div>

            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
            <?php
            $editUser = new ControllerUser();
            $editUser->ctrEditUser();
            ?>
         </form>
      </div>
   </div>
</div>

<?php
$deleteUser = new ControllerUser();
$deleteUser->ctrDeleteUser();
?>