<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="nationals">Nacional</a></li>
                        <li class="breadcrumb-item active">Editar compra nacional</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form role="form" method="post" autocomplete="off" id="import_national_excel_form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Datos de la compra nacional</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                    $item = 'id';
                                    $value = $_GET['nationalsView'];
                                    $national = ControllerNational::ctrShowNational($item, $value);
                                ?>
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR EL PROVEEDOR -->
                                    <div class="form-group col-md-3">
                                        <label for="providerEditNational">Nombre Proveedor</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="providerEditNational" id="providerEditNational">
                                            <option value="<?php echo $national['id_provider'] ?>"><?php echo $national['provider'] ?></option>
                                                <?php
                                                $item = 'provider_type';
                                                $value = 'Nacional';
                                                $response =  ControllerNational::ctrShowProvider($item, $value);
                                                foreach ($response as $key => $value) {
                                                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL SUCURSAL DE LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="subsidiaryEditNational">Sucursal llegada</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-building"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="subsidiaryEditNational" id="subsidiaryEditNational">
                                            <option value="<?php echo $national['id_subsidiary'] ?>"><?php echo $national['subsidiary'] ?></option>
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
                                    <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditEmision">FECHA PARTIDA</label>
                                        <div class="input-group date" id="dateEditEmision" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditEmision" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateEmisionEditNational" value="<?php echo $national['date_emision'] ?>"  data-target="#dateEditEmision" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditLlegada">FECHA LLEGADA</label>
                                        <div class="input-group date" id="dateEditLlegada" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditLlegada" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateLlegadaEditNational" value="<?php echo $national['date_llegada'] ?>"  data-target="#dateEditLlegada" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL ESTADO -->
                                    <div class="form-group col-md-3">
                                        <label for="statusEditNational">ESTADO</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-eye"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="statusEditNational" id="statusEditNational">
                                            <?php
                                                if($national['status'] == 1){
                                                    echo '<option value="1">Generado</option>
                                                          <option value="4">Recibido</option>';
                                                } else {
                                                    echo '<option value="4">Recibido</option>
                                                          <option value="1">Generado</option>';
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA GUIA TRANSPORTISTA -->
                                    <div class="form-group col-md-3">
                                        <label for="transportEditNational">GUIA TRANSPORTISTA</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-truck"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="transportEditNational" id="transportEditNational" value="<?php echo $national['transport_guide'] ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL MODELO -->
                                    <div class="form-group col-md-3">
                                        <label for="modelEditNational">MODELO</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="modelEditNational">
                                                <option value="<?php echo $national['id_model'] ?>"><?php echo $national['model'] ?></option>
                                                <?php
                                                $table = 'models';
                                                $item = null;
                                                $value = null;
                                                $response =  ControllerMant::ctrShowMant($table, $item, $value);
                                                foreach ($response as $key => $value) {
                                                    echo '<option value="' . $value['id'] . '">' . $value['name_lucki'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA OBSERVACION -->
                                    <div class="form-group col-md-3">
                                        <label for="observationEditNational">OBSERVACION</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="observationEditNational" id="observationEditNational" value="<?php echo $national['observation'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-left btn btn-lg btn-default" href="nationals">Cancelar</a>
                            <button type="submit" id="national" name="national" class="float-right btn btn-lg btn-info">Actualizar</button>
                        </div>
                    </div>
                </div>
                <?php
                $EditNational = new ControllerNational();
                $EditNational->ctrEditNational();
                ?>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>