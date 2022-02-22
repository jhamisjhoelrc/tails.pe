<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de clientes</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Clientes</li>
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
            <button class="btn btn-primary" data-toggle="modal" data-target='#modalAddCustomer'>Agregar nuevo cliente</button>
         </div>
         <div class="card-body">
            <table class="table table-bordered dt-responsive table-striped tableCustomers" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Nombres</th>
                     <th>Email</th>
                     <th>Teléfono</th>
                     <th>Ordenes</th>
                     <th>Gastos totales</th>
                     <th>Ciudad</th>
                     <th>Provincia</th>
                     <th>Departamento</th>
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
<!-- modalAddCustomer -->
<div class="modal fade" id="modalAddCustomer" tabindex="-1" role="dialog" aria-labelledby="modalAddCustomer" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Registrar nuevo cliente</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA RAZON SOCIAL O NOMBRES -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="nameAddCustomer" placeholder="Ingresar razón social o nombres" required>
                  </div>
               </div>


               <!-- ENTRADA PARA EL TIPO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="documentTypeAddCustomer">
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
                     <input type="text" class="form-control input-lg" name="numberDocumentAddCustomer" placeholder="Ingresar n° documento" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL EMAIL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                     </div>
                     <input type="email" class="form-control input-lg" id="emailAddCustomer" name="emailAddCustomer" placeholder="Ingresar email">
                  </div>
               </div>

               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="phoneAddCustomer" placeholder="Ingresar teléfono">
                  </div>
               </div>

               <!-- ENTRADA PARA LA DIRECCIÓN -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="addressAddCustomer" placeholder="Ingresar dirección">
                  </div>
               </div>

               <!-- ENTRADA PARA EL TIPO DE CLIENTE -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fa fa-users"></i></span>
                     <select class="form-control input-lg" name="customerTypeAddCustomer">
                        <option value="">Selecionar tipo de cliente</option>
                        <option value="Formal">Formal</option>
                        <option value="Distribuidor">Distribuidor</option>
                        <option value="Distribuidor informal">Distribuidor informal</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            <?php
            $addCustomers = new ControllerCustomers;
            $addCustomers->ctrCreateCustomers();
            ?>
         </form>
      </div>
   </div>
</div>

<!-- modalEditCustomer -->
<div class="modal fade" id="modalEditCustomer" tabindex="-1" role="dialog" aria-labelledby="modalEditCustomer" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
               <h5 class="modal-title">Actualizar cliente</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <!-- ENTRADA PARA RAZON SOCIAL O NOMBRES -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="nameEditCustomer" id="nameEditCustomer" required>
                  </div>
               </div>


               <!-- ENTRADA PARA EL TIPO DOCUMENTO -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                     <select class="form-control input-lg" name="documentTypeEditCustomer">
                        <option value="" id="documentTypeEditCustomer"></option>
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
                     <input type="text" class="form-control input-lg" name="numberDocumentEditCustomer" id="numberDocumentEditCustomer" required>
                  </div>
               </div>

               <!-- ENTRADA PARA EL EMAIL -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                     </div>
                     <input type="email" class="form-control input-lg" id="emailEditCustomer" name="emailEditCustomer">
                  </div>
               </div>

               <!-- ENTRADA PARA EL TELÉFONO -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="phoneEditCustomer" id="phoneEditCustomer">
                  </div>
               </div>

               <!-- ENTRADA PARA LA DIRECCIÓN -->
               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                     </div>
                     <input type="text" class="form-control input-lg" name="addressEditCustomer" id="addressEditCustomer">
                  </div>
               </div>

               <!-- ENTRADA PARA EL TIPO DE CLIENTE -->
               <div class="form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fa fa-users"></i></span>
                     <select class="form-control input-lg" name="customerTypeEditCustomer">
                        <option value="" id="typeCustomerEditCustomer"></option>
                        <option value="Formal">Formal</option>
                        <option value="Distribuidor">Distribuidor</option>
                        <option value="Distribuidor informal">Distribuidor informal</option>
                     </select>
                  </div>
               </div>
               <input type="hidden" id="idCustomer" name="idCustomer">
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
            <?php
            $editCustomer = new ControllerCustomers;
            $editCustomer->ctrEditCustomers();
            ?>
         </form>
      </div>
   </div>
</div>


<?php
$deleteCustomer = new ControllerCustomers();
$deleteCustomer->ctrDeleteCustomers();
?>