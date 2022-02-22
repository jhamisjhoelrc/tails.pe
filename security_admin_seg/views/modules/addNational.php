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
                        <li class="breadcrumb-item active">Nueva compra nacional</li>
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
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR EL PROVEEDOR -->
                                    <div class="form-group col-md-3">
                                        <label for="providerAddNational">Nombre Proveedor</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="providerAddNational" id="providerAddNational">
                                                <option value="">Seleciona un proveedor</option>
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
                                        <label for="subsidiaryAddNational">Sucursal llegada</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-building"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="subsidiaryAddNational" id="subsidiaryAddNational">
                                                <option value="">Seleciona una sucursal</option>
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
                                        <label for="dateSale">FECHA PARTIDA</label>
                                        <div class="input-group date" id="dateSale" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateSale" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateEmisionAddNational" data-target="#dateSale" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="dateLlegada">FECHA LLEGADA</label>
                                        <div class="input-group date" id="dateLlegada" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateLlegada" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateLlegadaAddNational" data-target="#dateLlegada" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA GUIA TRANSPORTISTA -->
                                    <div class="form-group col-md-3">
                                        <label for="transportsAddNational">GUIA TRANSPORTISTA</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-truck"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="transportsAddNational" id="transportsAddNational">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL MODELO -->
                                    <div class="form-group col-md-3">
                                        <label for="modelAddNational">MODELO</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="modelAddNational" id="modelAddNational">
                                                <option value="">Seleciona el modelo</option>
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
                                        <label for="observationAddNational">OBSERVACION</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="observationAddNational" id="observationAddNational">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="dateLlegada">IMPORTAR DETALLE</label>
                                            <input type="file" class="form-control-file" id="import_national_excel" name="import_national_excel" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-left btn btn-lg btn-default" href="nationals">Cancelar</a>
                            <button type="submit" id="national" name="national" class="float-right btn btn-lg btn-info">Registrar</button>
                        </div>
                    </div>
                </div>
                <?php
                $addNational = new ControllerNational();
                $addNational->ctrCreateNational();
                ?>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>