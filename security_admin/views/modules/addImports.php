<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1>Agregar nueva importación</h1> -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="imports">Importación</a></li>
                        <li class="breadcrumb-item active">Nueva importación</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form role="form" method="post" autocomplete="off" id="import_excel_form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Datos de la orden de importación</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR EL PROVEEDOR -->
                                    <div class="form-group col-md-3">
                                        <label for="providerAddImport">Nombre Proveedor</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="providerAddImport" id="providerAddImport">
                                                <option value="">Seleciona un proveedor</option>
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
                                        <label for="subsidiaryAddImport">Sucursal llegada</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-building"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="subsidiaryAddImport" id="subsidiaryAddImport">
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
                                    <!-- ENTRADA PARA LA GUIA -->
                                    <div class="form-group col-md-3">
                                        <label for="guiaAddImport">Guía</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="guiaAddImport" id="guiaAddImport" placeholder="Ingresar guía" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL BL/NRO -->
                                    <div class="form-group col-md-3">
                                        <label for="blAddImport">BL/NRO</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-bahai"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="blAddImport" id="blAddImport" placeholder="Ingresar bl/nro" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL CODIGO CHINA -->
                                    <div class="codeChine form-group col-md-3 d-none">
                                        <label for="codeChineAddImport">CODIGO CHINA</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-certificate"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="codeChineAddImport" id="codeChineAddImport" placeholder="Ingresar código opcional" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL CONTENEDOR -->
                                    <div class="form-group col-md-3">
                                        <label for="containerAddImport">CONTENEDOR</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-anchor"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="containerAddImport" id="containerAddImport" placeholder="Ingresar contenedor" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL CONTRATO NUMERO -->
                                    <div class="form-group col-md-3">
                                        <label for="">CONTRATO NUMERO</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="contractAddImport" id="contractAddImport" placeholder="Ingresar contrato" required>
                                        </div>
                                        <!-- ENTRADA PARA CHECKBOX DE AGREGAR NUMERO INVOICE -->
                                        <div class="form-group clearfix mb-0">
                                            <div class="icheck-primary d-inline float-right">
                                                <input type="checkbox" id="addNumberInvoice">
                                                <label for="addNumberInvoice">Agregar # invoice
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL NUMERO INVOICE -->
                                    <div class="numberInvoiceAddImport form-group col-md-3 d-none">
                                        <label for="">NUMERO INVOICE</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="numberInvoiceAddImport" id="numberInvoiceAddImport" placeholder="Ingresar # invoice">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA INVOICE -->
                                    <div class="form-group col-md-3">
                                        <label for="dateInvoice">FECHA INVOICE</label>
                                        <div class="input-group date" id="dateInvoice" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateInvoice" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateInvoiceAddImport" data-target="#dateInvoice" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL MODELO -->
                                    <div class="form-group col-md-3">
                                        <label for="modelAddImport">MODELO</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="modelAddImport" id="modelAddImport">
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
                                    <!-- ENTRADA PARA LA FECHA ZARPE CALLAO -->
                                    <div class="form-group col-md-3">
                                        <label for="dateZarpe">FECHA ZARPE CALLAO</label>
                                        <div class="input-group date" id="dateZarpe" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateZarpe" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateZarpeAddImport" data-target="#dateZarpe" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA ARRIBO CALLAO -->
                                    <div class="form-group col-md-3">
                                        <label for="dateArribo">FECHA ARRIBO CALLAO</label>
                                        <div class="input-group date" id="dateArribo" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateArribo" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateArriboAddImport" data-target="#dateArribo" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA NUMERACION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateNumeration">FECHA NUMERACIÓN</label>
                                        <div class="input-group date" id="dateNumeration" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateNumeration" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateNumerationAddImport" data-target="#dateNumeration" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateSale">FECHA EMISIÓN</label>
                                        <div class="input-group date" id="dateSale" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateSale" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateEmisionAddImport" data-target="#dateSale" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="dateLlegada">FECHA LLEGADA</label>
                                        <div class="input-group date" id="dateLlegada" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateLlegada" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateLlegadaAddImport" data-target="#dateLlegada" />
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
                                                        <input type="text" class="form-control" id="priceFlete" name="priceFlete" value="0.00">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i style="font-size:12px;" class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="damMoto" name="damMoto" value="0.00">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i style="font-size:12px;" class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="damRepuesto" name="damRepuesto" value="0.00">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div style="font-weight: bold; background-color: transparent; border:none;" class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input style="font-weight: bold; background-color: transparent; border:none;" type="text" class="form-control" id="damTotal" name="damTotal" value="0.00" readonly>
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i style="font-size:12px;" class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="realMoto" name="realMoto" value="0.00">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i style="font-size:12px;" class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="realRepuesto" name="realRepuesto" value="0.00">
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div style="font-weight: bold; background-color: transparent; border:none;" class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input style="font-weight: bold; background-color: transparent; border:none;" type="text" class="form-control" id="realTotal" name="realTotal" value="0.00" readonly>
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div style="font-weight: bold; background-color: transparent; border:none;" class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                                        </div>
                                                        <input style="font-weight: bold; background-color: transparent; border:none;" type="text" class="form-control" id="diferent" name="diferent" value="0.00" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="dateLlegada">IMPORTAR DETALLE</label>
                                            <input type="file" class="form-control-file" id="import_excel" name="import_excel" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-left btn btn-lg btn-default" href="imports">Cancelar</a>
                            <button type="submit" id="import" name="import" class="float-right btn btn-lg btn-info">Registrar</button>
                        </div>
                    </div>
                </div>
                <?php
                $addImport = new ControllerImport();
                $addImport->ctrCreateImport();
                ?>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>