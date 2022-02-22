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
                        <li class="breadcrumb-item"><a href="notas">Notas</a></li>
                        <li class="breadcrumb-item active">Crear Nota</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <?php 
        # REGISTRAR FECHA Y HORA ACTUAL
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $exchange = ControllerMant::ctrShowMant('exchange', 'date_exchange', $date);
        if(!$exchange){
            echo '<script>
            window.onload=function() {
                Swal.fire({
                icon: "warning",
                title: "Advertencia de tipo de cambio",
                text: "No existe tipo de cambio del día",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
                })
            }
            </script>';
        }
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form role="form" method="post" autocomplete="off">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">Datos del cliente</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA EL NOMBRE DE CLIENTE -->
                                    <div class="form-group col-md-3">
                                        <label for="nameCustomerAddSales">Razón social o nombres</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="nameCustomerAddSales" id="nameCustomerAddSales" placeholder="Ingresar razón social o nombres de cliente" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL TIPO DE DOCUMENTO -->
                                    <div class="form-group col-md-3">
                                        <label for="documentTypeAddSales">Tipo documento</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="documentTypeAddSales" id="documentTypeAddSales" required>
                                                <option value="">Seleciona un tipo de documento</option>
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
                                    <!-- ENTRADA PARA EL NUMERO DE DOCUMENTO -->
                                    <div class="form-group col-md-3">
                                        <label for="documentNumberAddSales">Número de documento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="documentNumberAddSales" id="documentNumberAddSales" placeholder="Ingresar n° de documento" required>
                                            <button type="button" class="consultaruc float-right btn btn-primary">Consulta RUC</button>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL TELEFONO -->
                                    <div class="form-group col-md-3">
                                        <label for="phoneAddSales">Teléfono</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="phoneAddSales" id="phoneAddSales" placeholder="Ingresar n° teléfono" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL EMAIL -->
                                    <div class="codeChine form-group col-md-3">
                                        <label for="emailAddSales">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="emailAddSales" id="emailAddSales" placeholder="Ingresar email" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL TIPO DE CLIENTE -->
                                    <div class="form-group col-md-3">
                                        <label for="customerTypeAddSales">Tipo de cliente</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="customerTypeAddSales" id="customerTypeAddSales" required>
                                                <option selected>Seleciona el tipo de cliente</option>
                                                <option value="Final">Final</option>
                                                <option value="Distribuidor">Distribuidor</option>
                                                <option value="Distribuidor informal">Distribuidor informal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA DIRECCIÓN -->
                                    <div class="form-group col-md-6">
                                        <label for="addressCustomerAddSales">Dirección</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="addressCustomerAddSales" id="addressCustomerAddSales" placeholder="Ingresar dirección del cliente" required>
                                            <input type="hidden" id="idCustomer" name="idCustomer">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL DISTRITO -->
                                    <div class="form-group col-md-3">
                                        <label for="districtAddSales">Seleccionar el distrito</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="districtAddSales" id="districtAddSales" required>
                                                <option selected>Selecciona el distrito</option>
                                                <?php 
                                                    $table = 'ubigeo_peru_districts';
                                                    $item = null;
                                                    $value = null;
                                                    $response =  ControllerMant::ctrShowMant($table, $item, $value);
                                                    foreach ($response as $key => $value) {
                                                        echo '<option value="' . $value['id'] . '">' . $value['name'] .'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <!-- ENTRADA PARA LA PROVINCIA -->
                                     <div class="form-group col-md-3">
                                        <label for="provinceAddSales">Provincia</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="provinceAddSales" id="provinceAddSales" readonly>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA DIRECCIÓN -->
                                    <div class="form-group col-md-3">
                                        <label for="departmentAddSales">Departamento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="departmentAddSales" id="departmentAddSales" readonly>
                                            <?php
                                                // CONSIGUIENDO EL LOCAL DEL USUARIO
                                                $iduser = $_SESSION['id_user'];
                                                $data_user = ControllerUser::ctrShowUser('id', $iduser);
                                            ?>
                                            <input type="hidden" id="idSubsidiary" name="idSubsidiary" value="<?php echo $data_user['id_subsidiary']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA SELECCION DEL COMPROBANTE -->
                                    <div class="form-group col-md-3">
                                        <label for="typeVoucherAddSales">Comprobante</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="typeVoucherAddSales" id="typeVoucherAddSales" required>
                                                <option value="07">Nota crédito</option>
                                                <option value="08">Nota débito</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">Documento a modificar</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR EL TIPO DE DOCUMENTO -->
                                    <div class="form-group col-md-3">
                                        <label for="typeReferenceDocument">Tipo comprobante afecto</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="typeReferenceDocument" id="typeReferenceDocument">
                                                <option value="03">Boleta</option>
                                                <option value="01">Factura</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA INGRESAR EL NUMERO DEL COMPROBANTE AFECTADO -->
                                    <div class="form-group col-md-3">
                                        <label for="referenceDocument">Comprobante afecto</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <input type="text" class="form-control mr-2" placeholder="SERIE-CORRELATIVO" aria-label="" aria-describedby="basic-addon2" name="referenceDocument" id="referenceDocument">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA SELECCION DEL MOTIVO POR MODIFICAR -->
                                    <div class="form-group col-md-3">
                                        <label for="motive">Motivo a modificar</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="motive" id="motive">
                                                <option value="01">Anulación de la operación</option>
                                                <option value="02">Anulación por error en el RUC</option>
                                                <option value="03">Corrección por error en la descripción</option>
                                                <option value="04">Descuento global</option>
                                                <option value="05">Descuento por item</option>
                                                <option value="06">Devolución total</option>
                                                <option value="07">Devolución por item</option>
                                                <option value="08">Bonificación</option>
                                                <option value="09">Disminución en el valor</option>
                                                <option value="10">Otros conceptos</option>
                                                <option value="11">Ajustes de operaciones de exportación</option>
                                                <option value="12">Ajustes afectos al IVAP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">Datos de la venta</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA LA MONEDA -->
                                    <div class="form-group col-md-3">
                                        <label for="currencyAddSales">Moneda</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="currencyAddSales" id="currencyAddSales" required>
                                                <option value="PEN">Soles</option>
                                                <option value="USD">Dólares</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA SELECCION DE LA OPERACIÓN -->
                                    <div class="form-group col-md-3">
                                        <label for="typeOperationAddSales">Tipo operación</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="typeOperationAddSales" id="typeOperationAddSales" required>
                                                <option value="01">Gravada / Exonerada</option>
                                                <option value="03">Gratuita</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateSale">Fecha venta</label>
                                        <div class="input-group date" id="dateSale" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateSale" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateAddSales" data-target="#dateSale" required/>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL VENDEDOR -->
                                    <div class="form-group col-md-3">
                                        <label for="sellerAddSales">Vendedor</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-tag nav-icon"></i></span>
                                            <select class="form-control input-lg select2bs4 " style="width: 100%;" name="sellerAddSales" id="sellerAddSales" required>
                                                <option value="">Seleciona un vendedor</option>
                                                <?php
                                                $table = 'sellers';
                                                $item = null;
                                                $value = null;
                                                $response =  ControllerMant::ctrShowMant($table, $item, $value);
                                                foreach ($response as $key => $value) {
                                                    echo '<option value="' . $value['id'] . '">' . $value['names'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL METODO DE PAGO -->
                                    <div class="form-group col-md-3">
                                        <label for="paymentConditionAddSales">Condición de pago</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-cash-register"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="paymentConditionAddSales" id="paymentConditionAddSales" required>
                                                <option value="Contado">Contado</option>
                                                <option value="Crédito">Crédito</option>
                                                <!-- <option value="Tarjeta POS">Tarjeta POS</option>
                                                <option value="Finanpop">Finanpop</option>
                                                <option value="Crediscotia">Crediscotia</option> -->
                                            </select>
                                            <button type="button" class="btn btn-success ml-4 btnAddCredito d-none"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA TABLA CRONOGRAMA DE PAGOS A CRÉDITO -->
                                    <div class="grupotablacronograma form-group col-md-3 d-none">
                                        <label for="paydCredito"></label>
                                        <div class="input-group-prepend">
                                            <table class="table table-bordered dt-responsive">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Fecha pago</th>
                                                        <th scope="col">Monto</th>
                                                        <th scope="col">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableCredito">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA EL PRECIO TRÁMITES -->
                                    <div class="form-group col-md-3">
                                        <label for="priceTramiteAddSales">Precio por trámites</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="priceTramiteAddSales" id="priceTramiteAddSales" placeholder="Ingresar precio por trámites">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL PRECIO TRANSPORTE -->
                                    <div class="form-group col-md-3">
                                        <label for="priceTransportAddSales">Precio por transporte</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="priceTransportAddSales" id="priceTransportAddSales" placeholder="Ingresar precio por transportes">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL PRECIO PLACA -->
                                    <div class="form-group col-md-3">
                                        <label for="pricePlacaAddSales">Precio por placa</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="pricePlacaAddSales" id="pricePlacaAddSales" placeholder="Ingresar precio por placa">
                                        </div>
                                    </div>
                                    <!-- CHECK PARA ENVIAR COMPROBANTE A SUNAT O NO -->
                                    <div class="form-group col-md-3">
                                        <label for="checkSendSunat">Enviar a SUNAT?</label>
                                        <div class="input-group">
                                        <div class="icheck-primary d-inline float-right">
                                                <input type="checkbox" id="checkSendSunat" name="checkSendSunat">
                                                <label for="checkSendSunat">Seleccionar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 my-3">
                                        <label for="motorAddSales">Buscar por motor</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mr-2" placeholder="Código de motor" aria-label="" aria-describedby="basic-addon2" name="motorAddSales" id="motorAddNote">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 my-3">
                                        <label for="chasisAddSales">Buscar por chasis</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mr-2" placeholder="Código de chasis" aria-label="" aria-describedby="basic-addon2" name="chasisAddSales" id="chasisAddNote">
                                        </div>
                                    </div>
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
                                        <tbody id="tableMovil">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-left btn btn-lg btn-default" href="notas">Cancelar</a>
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