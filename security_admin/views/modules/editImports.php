<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Actualizando importación</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="imports">Importación</a></li>
                        <li class="breadcrumb-item active">Editar importación</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form role="form" method="post" autocomplete="off" id="import_excel_form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Datos de la orden de importación</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                $item = 'id';
                                $value = $_GET['importsView'];
                                $import = ControllerImport::ctrShowImport($item, $value);

                                ?>
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR EL PROVEEDOR -->
                                    <div class="form-group col-md-3">
                                        <label for="providerEditImport">Nombre Proveedor</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="providerEditImport" id="providerEditImport">
                                                <option value="<?php echo $import['id_provider'] ?>"><?php echo $import['provider'] ?></option>
                                                <?php
                                                $item = 'provider_type';
                                                $value = 'Exterior';
                                                $response =  ControllerImport::ctrShowProvider($item, $value);
                                                foreach ($response as $key => $value) {
                                                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL SUCURSAL DE LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="subsidiaryEditImport">Sucursal llegada</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-building"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="subsidiaryEditImport" id="subsidiaryEditImport">
                                                <option value="<?php echo $import['id_subsidiary'] ?>"><?php echo $import['subsidiary'] ?></option>
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
                                    <!-- ENTRADA PARA LA GUIA -->
                                    <div class="form-group col-md-3">
                                        <label for="guiaEditImport">Guía</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="guiaEditImport" id="guiaEditImport" value="<?php echo $import['guia'] ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL BL/NRO -->
                                    <div class="form-group col-md-3">
                                        <label for="blEditImport">BL/NRO</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-bahai"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="blEditImport" id="blEditImport" value="<?php echo $import['bl'] ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL CODIGO CHINA -->
                                    <div class="codeChine form-group col-md-3">
                                        <label for="codeChineEditImport">CODIGO CHINA</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-certificate"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="codeChineEditImport" id="codeChineEditImport" value="<?php echo $import['chine_code'] ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL CONTENEDOR -->
                                    <div class="form-group col-md-3">
                                        <label for="containerEditImport">CONTENEDOR</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-anchor"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="containerEditImport" id="containerEditImport" value="<?php echo $import['container'] ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL CONTRATO NUMERO -->
                                    <div class="form-group col-md-3">
                                        <label>CONTRATO NUMERO</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="contractEditImport" value="<?php echo $import['contract'] ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL NUMERO INVOICE -->
                                    <div class=" form-group col-md-3">
                                        <label>NUMERO INVOICE</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="numberInvoiceEditImport" value="<?php echo $import['invoice_number'] ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA INVOICE -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditInvoice">FECHA INVOICE</label>
                                        <div class="input-group date" id="dateEditInvoice" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditInvoice" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateInvoiceEditImport" value="<?php echo $import['invoice_date'] ?>" data-target="#dateEditInvoice" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL MODELO -->
                                    <div class="form-group col-md-3">
                                        <label for="modelEditImport">MODELO</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="modelEditImport" id="modelEditImport">
                                                <option value="<?php echo $import['id_model'] ?>"><?php echo $import['model'] ?></option>
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
                                    <!-- ENTRADA PARA LA FECHA ZARPE CALLAO -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditZarpe">FECHA ZARPE CALLAO</label>
                                        <div class="input-group date" id="dateEditZarpe" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditZarpe" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateZarpeEditImport" value="<?php echo $import['date_zarpe'] ?>" data-target="#dateEditZarpe" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA ARRIBO CALLAO -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditArribo">FECHA ARRIBO CALLAO</label>
                                        <div class="input-group date" id="dateEditArribo" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditArribo" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateArriboEditImport" value="<?php echo $import['date_arribo'] ?>" data-target="#dateEditArribo" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA NUMERACION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditNumeration">FECHA NUMERACIÓN</label>
                                        <div class="input-group date" id="dateEditNumeration" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditNumeration" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateNumerationEditImport" value="<?php echo $import['date_numeration'] ?>" data-target="#dateEditNumeration" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditEmision">FECHA EMISIÓN</label>
                                        <div class="input-group date" id="dateEditEmision" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditEmision" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateEmisionEditImport" value="<?php echo $import['date_emision'] ?>" data-target="#dateEditEmision" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditLlegada">FECHA LLEGADA</label>
                                        <div class="input-group date" id="dateEditLlegada" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditLlegada" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateLlegadaEditImport" value="<?php echo $import['date_llegada'] ?>" data-target="#dateEditLlegada" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL ESTADO -->
                                    <div class="form-group col-md-3">
                                        <label for="statusEditImport">ESTADO</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-toggle-off"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="statusEditImport" id="statusEditImport">
                                                <?php
                                                if ($import['status'] == 1) {
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
                                </div>
                                <div class="row mt-5">
                                    <table class="table table-bordered dt-responsive" width="100%">
                                        <thead class="thead-dark bg-dark">
                                            <tr>
                                                <td width="100" rowspan="2" align="center"><span class="titulos_tablas">PRECIO FLETE</span></td>
                                                <td colspan="3" align="center"><span class="titulos_tablas">DAM</span></td>
                                                <td colspan="3" align="center"><span class="titulos_tablas">REAL</span></td>
                                                <td width="60" rowspan="2" align="center"><span class="titulos_tablas">DIFERENCIA</span></td>
                                            </tr>
                                            <tr>
                                                <td width="100" align="center"><span class="titulos_tablas">Motos</span></td>
                                                <td width="100" align="center"><span class="titulos_tablas">Repuestos</span></td>
                                                <td width="100" align="center"><span class="titulos_tablas">Total</span></td>
                                                <td width="100" align="center"><span class="titulos_tablas">Motos</span></td>
                                                <td width="100" align="center"><span class="titulos_tablas">Repuestos</span></td>
                                                <td width="100" align="center"><span class="titulos_tablas">Total</span></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i style="font-size:12px;" class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="priceFlete" name="priceFlete" value="<?php echo $import['price_flete'] ?>">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i style="font-size:12px;" class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="damMoto" name="damMoto" value="<?php echo $import['dam_moto'] ?>">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i style="font-size:12px;" class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="damRepuesto" name="damRepuesto" value="<?php echo $import['dam_repuesto'] ?>">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div style="font-weight: bold; background-color: transparent; border:none;" class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input style="font-weight: bold; background-color: transparent; border:none;" type="text" class="form-control" id="damTotal" name="damTotal" value="<?php echo $import['dam_total'] ?>" readonly>
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i style="font-size:12px;" class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="realMoto" name="realMoto" value="<?php echo $import['real_moto'] ?>">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i style="font-size:12px;" class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="realRepuesto" name="realRepuesto" value="<?php echo $import['real_repuesto'] ?>">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div style="font-weight: bold; background-color: transparent; border:none;" class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input style="font-weight: bold; background-color: transparent; border:none;" type="text" class="form-control" id="realTotal" name="realTotal" value="<?php echo $import['real_total'] ?>" readonly>
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div style="font-weight: bold; background-color: transparent; border:none;" class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input style="font-weight: bold; background-color: transparent; border:none;" type="text" class="form-control" id="diferent" name="diferent" value="<?php echo $import['diferent'] ?>" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-left btn btn-lg btn-default" href="imports">Cancelar</a>
                            <button type="submit" id="import" name="import" class="float-right btn btn-lg btn-info">Actualizar</button>
                        </div>
                    </div>
                </div>
                <?php
                $editImport = new ControllerImport();
                $editImport->ctrEditImport();
                ?>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>