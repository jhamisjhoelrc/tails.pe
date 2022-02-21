<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Administración de importación </h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                  <li class="breadcrumb-item active">Importación</li>
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
            <a href="addImports" class="btn btn-primary">Agregar nueva importación</a>
         </div>
         <div class="card-body">
            <table class="table table-bordered dt-responsive table-striped tableImport" width="100%">
               <thead class="thead-dark">
                  <tr>
                     <th style="width: 10px;">#</th>
                     <th>Proveedor</th>
                     <th>Contenedor</th>
                     <th>Guía</th>
                     <th>Modelo</th>
                     <th>Sucursal</th>
                     <th>Fecha Emisión</th>
                     <th>Fecha llegada</th>
                     <th>Total DAM</th>
                     <th>Total REAL</th>
                     <th>Diferencia</th>
                     <th>Estado</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
               <!-- <tbody>
                    <tr>
                        <td>1</td>
                        <td>GUANGYU</td>
                        <td>BSIU9965568</td>
                        <td>DAM 425387</td>
                        <td>250cc</td>
                        <td>ALMACÉN ATE</td>
                        <td>2021-10-22</td>
                        <td>2021-12-14</td>
                        <td>38859.60</td>
                        <td>42002.00</td>
                        <td>5902.16</td>
                        <td><button class="btn btn-warning btn-xs">Generado</button></td>
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
                        <td>BSIU9965568</td>
                        <td>DAM 425387</td>
                        <td>250cc</td>
                        <td>ALMACÉN ATE</td>
                        <td>2021-10-22</td>
                        <td>2021-12-14</td>
                        <td>38859.60</td>
                        <td>42002.00</td>
                        <td>5902.16</td>
                        <td><button class="btn btn-success btn-xs">Entregado</button></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-info" style="color:white;" data-toggle="modal" data-target="#modalEditSeller"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-warning" style="color:white;" data-toggle="modal" data-target="#modalEditSeller"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger"><i class="fas fa-times"></i></button>
                            </div>
                        </td>
                    </tr>
               </tbody> -->
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


<!-- modalShowImport -->
<div class="modal fade" id="modalShowImport" tabindex="-1" role="dialog" aria-labelledby="modalShowImport" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <form role="form" method="post" enctype="multipart/form-data">
            <div class="modal-header">
               <h5 class="modal-title">Visualizar detalle importación</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body d-flex flex-wrap">
               <!-- ENTRADA PARA EL PROVEEDOR -->
               <div class="form-group col-md-6">
                  <label for="nameProviderImport">Proveedor</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-caravan"></i></span>
                     </div>
                     <input style="background-color:transparent;" type="text" class="form-control input-lg" name="nameProviderImport" id="nameProviderImport" readonly>
                  </div>
               </div>
               <!-- ENTRADA PARA EL SUCURSAL LLEGADA -->
               <div class="form-group col-md-6">
                  <label for="subsidiaryImport">Sucursal llegada</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                     </div>
                     <input style="background-color:transparent;" type="text" class="form-control input-lg" name="subsidiaryImport" id="subsidiaryImport" readonly>
                  </div>
               </div>
               <div class="form-group col-md-12 mt-5">
                  
               </div>
               <div class="form-group">
                  <table class="table table-striped table-bordered table-sm table-responsive">
                     <thead class="thead-light">
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">DAM</th>
                           <th scope="col">CHASIS</th>
                           <th scope="col">MOTOR</th>
                           <th scope="col">COLOR</th>
                           <th scope="col">FABRICACIÓN</th>
                        </tr>
                     </thead>
                     <tbody class="bodyShow">
                        <!-- <tr>
                           <th scope="row">1</th>
                           <td>118-2021-10-087776-01-9-00(178)</td>
                           <td>LHJYJLLA5MB435533</td>
                           <td>WX169FML21A04283</td>
                           <td>ROJO/NEGRO </td>
                           <td>2021</td>
                        </tr> -->
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
      </div>
   </div>
</div>

<?php
$deleteImport = new ControllerImport();
$deleteImport->ctrDeleteImport();
?>