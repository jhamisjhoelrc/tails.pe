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
                        <li class="breadcrumb-item"><a href="notadebito">Nota debito</a></li>
                        <li class="breadcrumb-item active">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form role="form" method="post" autocomplete="off">
                <div class="row">
                    <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Datos de la factura</h3>
                        </div>    
                        <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR EL NUMERO DEL COMPROBANTE AFECTADO -->
                                    <div class="form-group col-md-3">
                                        <label for="comprobanteAddNotacredito">Comprobante afecto</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg select2bs4 " style="width: 100%;" name="comprobanteAddNotacredito" id="comprobanteAddNotacredito">
                                                <option value="">Seleciona un comprobante</option>
                                                <?php
                                                $table = 'invoicing';
                                                $item = null;
                                                $value = null;
                                                $response =  ControllerNotas::ctrShowFactBol($table, $item, $value);
                                                foreach ($response as $key => $value) {
                                                    echo '<option value="' . $value['id'] . '">' . $value['serial_number'].'-'.$value['correlative'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="voucher_affected_serial" id="voucher_affected_serial">
                                            <input type="hidden" name="voucher_affected_correlative" id="voucher_affected_correlative">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA SELECCION DEL COMPROBANTE -->
                                    <div class="form-group col-md-3">
                                        <label for="typeVoucherAddNotacredito">Tipo comprobante afecto</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="typeVoucherAddNotacredito" id="typeVoucherAddNotacredito">
                                                <option value="01">Factura</option>
                                                <option value="03">Boleta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA SELECCION DEL CODIGO SERIE NUMERO AFECTO -->
                                    <div class="form-group col-md-3">
                                        <label for="motivoAddNotacredito">Motivo del afecto</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="motivoAddNotacredito" id="motivoAddNotacredito">
                                                <option value="01">Interes por mora</option>
                                                <option value="02">Aumento en el valor</option>
                                                <option value="03">Penalidades / otros conceptos</option>
                                                <option value="11">Ajustes de operaciones de exportación</option>
                                                <option value="12">Ajustes afectos al IVAP</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEmision">Fecha emisión</label>
                                        <div class="input-group date" id="dateEmision" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEmision" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateAddNotacredito" data-target="#dateEmision" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Datos de cliente</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA EL NOMBRE DE CLIENTE -->
                                    <div class="form-group col-md-3">
                                        <label for="nombreCustomerAddNotacredito">Razón social o nombres</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="nombreCustomerAddNotacredito" id="nombreCustomerAddNotacredito" placeholder="Nombres de cliente" readonly>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL TIPO DE DOCUMENTO -->
                                    <div class="form-group col-md-3">
                                        <label for="documentTypeAddNotacredito">Tipo documento</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="documentTypeAddNotacredito" readonly>
                                                <option id="documentTypeAddNotacredito">Seleciona un tipo</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL NUMERO DE DOCUMENTO -->
                                    <div class="form-group col-md-3">
                                        <label for="documentNumberAddNotacredito">Número de documento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="documentNumberAddNotacredito" id="documentNumberAddNotacredito" placeholder="Ingresar n° de documento" readonly>
                                            <input type="hidden" name="tipodoc" id="tipodoc" value="08">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA DIRECCIÓN -->
                                    <div class="form-group col-md-3">
                                        <label for="addressCustomerAddNotacredito">Dirección</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="addressCustomerAddNotacredito" id="addressCustomerAddNotacredito" readonly>
                                            <input type="hidden" name="idCustomer" id="idCustomer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Datos del movil</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <table class="table table-bordered dt-responsive" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Categoría</th>
                                                <th scope="col">Marca</th>
                                                <th scope="col">Modelo</th>
                                                <th scope="col">Chasis</th>
                                                <th scope="col">Motor</th>
                                                <th scope="col">Color</th>
                                                <th scope="col">Precio móvil</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row" class="numberItem">1</th>
                                            <td><input type="text" name="category" id="category" class="form-control" readonly></td>
                                            <td><input type="text" name="brand" id="brand" class="form-control" readonly></td>
                                            <td><input type="text" name="model" id="model" class="form-control" readonly></td>
                                            <td><input type="text" name="chasis" id="chasis" class="form-control" readonly></td>
                                            <td><input type="text" name="motor" id="motor" class="form-control" readonly></td>
                                            <td><input type="text" name="colour" id="colour" class="form-control" readonly></td>
                                            <td><input type="text" name="priceMovil" id="priceMovil" class="form-control"></td>
                                            <td><div class="btn-group"><button class="btn btn-danger btnDeleteItem"><i class="fas fa-times"></i></button></div></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-left btn btn-lg btn-default" href="notadebito">Cancelar</a>
                            <button type="submit" class="float-right btn btn-lg btn-primary">Registrar</button>
                        </div>
                    </div>
                </div>
                <?php
                $addSales = new ControllerNotas();
                $addSales->ctrCreateNotas();
                ?>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>