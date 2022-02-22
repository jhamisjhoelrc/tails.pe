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
                        <li class="breadcrumb-item active">Actualizar nota</li>
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
                                <?php
                                    $item = 'id';
                                    $value = $_GET['salesView'];
                                    $id_sales = $value;
                                    $sales = ControllerSales::ctrShowSales($item, $value);
                                    $negociable = ControllerSales::ctrShowCronograma('id_sale', $sales['id']);
                                    if($negociable){
                                        $class = '';
                                    }else {
                                        $class = 'd-none';
                                    }
                                    if($sales['send_sunat'] == 'NO'){
                                        $check = '';
                                    }else {
                                        $check = 'checked';
                                    }

                                    $detail_sales = ControllerSales::ctrShowDetailSales('id_sales', $sales['id']);
                                ?>
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA EL NOMBRE DE CLIENTE -->
                                    <div class="form-group col-md-3">
                                        <label for="nameCustomerAddSales">Razón social o nombres</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="nameCustomerAddSales" id="nameCustomerAddSales" value="<?php echo $sales['customer']; ?>" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL TIPO DE DOCUMENTO -->
                                    <div class="form-group col-md-3">
                                        <label for="documentTypeAddSales">Tipo documento</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="documentTypeAddSales" id="documentTypeAddSales" required>
                                                <option value="<?php echo $sales['id_document']; ?>"><?php echo $sales['document']; ?></option>
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
                                            <input type="text" class="form-control input-lg" name="documentNumberAddSales" id="documentNumberAddSales" value="<?php echo $sales['document_number']; ?>" required>
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
                                            <input type="text" class="form-control input-lg" name="phoneAddSales" id="phoneAddSales" value="<?php echo $sales['phone']; ?>"  required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL EMAIL -->
                                    <div class="codeChine form-group col-md-3">
                                        <label for="emailAddSales">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="emailAddSales" id="emailAddSales" value="<?php echo $sales['email']; ?>" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL TIPO DE CLIENTE -->
                                    <div class="form-group col-md-3">
                                        <label for="customerTypeAddSales">Tipo de cliente</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="customerTypeAddSales" id="customerTypeAddSales" required>
                                                <option value="<?php echo $sales['customer_type']; ?>"><?php echo $sales['customer_type']; ?></option>
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
                                            <input type="text" class="form-control input-lg" name="addressCustomerAddSales" id="addressCustomerAddSales" value="<?php echo $sales['address']; ?>" required>
                                            <input type="hidden" id="idCustomer" name="idCustomer" value="<?php echo $sales['id_customer']; ?>">
                                            <input type="hidden" id="idSale" name="idSale" value="<?php echo $sales['id']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL DISTRITO -->
                                    <div class="form-group col-md-3">
                                        <label for="districtAddSales">Seleccionar el distrito</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="districtAddSales" id="districtAddSales" required>
                                                <option value="<?php echo $sales['id_district']; ?>"><?php echo $sales['district']; ?></option>
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
                                            <input type="text" class="form-control input-lg" name="provinceAddSales" id="provinceAddSales" value="<?php echo $sales['province']; ?>" readonly>
                                        </div>
                                    </div>
                                     <!-- ENTRADA PARA LA DIRECCIÓN -->
                                     <div class="form-group col-md-3">
                                        <label for="departmentAddSales">Departamento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="departmentAddSales" id="departmentAddSales" value="<?php echo $sales['department']; ?>" readonly>
                                            <input type="hidden" id="idSubsidiary" name="idSubsidiary" value="<?php echo $sales['id_subsidiary']; ?>">
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
                                                <?php 
                                                    if($sales['currency'] == 'PEN'){
                                                        echo '<option value="PEN">Soles</option>
                                                        <option value="USD">Dólares</option>';
                                                    }else {
                                                        echo '<option value="USD">Dólares</option>
                                                        <option value="PEN">Soles</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <!-- ENTRADA PARA LA SELECCION DEL COMPROBANTE -->
                                     <div class="form-group col-md-3">
                                        <label for="typeVoucherAddSales">Comprobante</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="typeVoucherAddSales" id="typeVoucherAddSales" required>
                                                <?php 
                                                    if($sales['type_voucher'] == '01'){
                                                        echo '<option value="01">Factura</option>
                                                        <option value="03">Boleta</option>';
                                                    }else {
                                                        echo '<option value="03">Boleta</option>
                                                        <option value="01">Factura</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA SELECCION DE LA OPERACIÓN -->
                                    <div class="form-group col-md-3">
                                        <label for="typeOperationAddSales">Tipo operación</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="typeOperationAddSales" id="typeOperationAddSales" required>
                                                <?php 
                                                    if($sales['type_operation'] == '01'){
                                                        echo '<option value="01">Gravada / Exonerada</option>
                                                        <option value="03">Gratuita</option>';
                                                    }else {
                                                        echo '<option value="03">Gratuita</option>
                                                        <option value="01">Gravada / Exonerada</option>';
                                                    }
                                                ?>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditSale">Fecha venta</label>
                                        <div class="input-group date" id="dateEditSale" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditSale" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateAddSales" value="<?php echo $sales['date_sale']; ?>" data-target="#dateEditSale" required/>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL VENDEDOR -->
                                    <div class="form-group col-md-3">
                                        <label for="sellerAddSales">Vendedor</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-tag nav-icon"></i></span>
                                            <select class="form-control input-lg select2bs4 " style="width: 100%;" name="sellerAddSales" id="sellerAddSales" required>
                                                <option value="<?php echo $sales['id_seller']; ?>"><?php echo $sales['seller']; ?></option>
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
                                                <?php 
                                                    if($sales['payment_condition'] == 'Contado'){
                                                        echo '<option value="Contado">Contado</option>
                                                        <option value="Crédito">Crédito</option>';
                                                    }else {
                                                        echo '<option value="Crédito">Crédito</option>
                                                        <option value="Contado">Contado</option>';
                                                    }
                                                ?>
                                            </select>
                                            <button type="button" class="btn btn-success ml-4 btnAddCredito <?php echo $class; ?>"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA TABLA CRONOGRAMA DE PAGOS A CRÉDITO -->
                                    <div class="grupotablacronograma form-group col-md-3 <?php echo $class; ?>">
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
                                                    <?php
                                                        if($sales['payment_condition'] == 'Crédito'){
                                                            foreach ($negociable as $key => $value) {
                                                                echo "<tr><th scope='row' class='numberCredito'>".($key+1)."</th><td><input type='text' class='form-control dateEditCronograma' name='dateCronograma[]' value='".$value['date_payd']."'/></td><td><input type='text' class='form-control' name='montoCronograma[]' value='".$value['amount']."'/></td><td><div class='btn-group'><button class='btn btn-danger btnDeleteCronograma'><i class='fas fa-times'></i></button></div></td></tr>";
                                                            }
                                                        }
                                                    ?>
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
                                            <input type="text" class="form-control input-lg" name="priceTramiteAddSales" id="priceTramiteAddSales" value="<?php echo $sales['price_tramit']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL PRECIO TRANSPORTE -->
                                    <div class="form-group col-md-3">
                                        <label for="priceTransportAddSales">Precio por transporte</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="priceTransportAddSales" id="priceTransportAddSales" value="<?php echo $sales['price_transport']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL PRECIO PLACA -->
                                    <div class="form-group col-md-3">
                                        <label for="pricePlacaAddSales">Precio por placa</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="pricePlacaAddSales" id="pricePlacaAddSales" value="<?php echo $sales['price_placa']; ?>">
                                        </div>
                                    </div>
                                    <!-- CHECK PARA ENVIAR COMPROBANTE A SUNAT O NO -->
                                    <div class="form-group col-md-3">
                                        <label for="checkSendSunat">Enviar a SUNAT?</label>
                                        <div class="input-group">
                                        <div class="icheck-primary d-inline float-right">
                                                <input type="checkbox" id="checkSendSunat" name="checkSendSunat" <?php echo $check; ?>>
                                                <label for="checkSendSunat">Seleccionar</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3 my-3">
                                        <label for="motorAddSales">Buscar por motor</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mr-2" placeholder="Código de motor" aria-label="" aria-describedby="basic-addon2" name="motorAddSales" id="motorAddSales">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 my-3">
                                        <label for="chasisAddSales">Buscar por chasis</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mr-2" placeholder="Código de chasis" aria-label="" aria-describedby="basic-addon2" name="chasisAddSales" id="chasisAddSales">
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
                                            <?php
                                                if($detail_sales){
                                                    
                                                    foreach ($detail_sales as $key => $value) { 
                                                        echo '<tr><th scope="row" class="numberItem">'.($key+1).'</th><td><input type="text" name="category[]" class="form-control categorySales'.($key+1).'" value="'.$value['category'].'" readonly></td><td><input type="text" name="brand[]" class="form-control brandSales'.($key+1).'" value="'.$value['brand'].'" readonly></td><td><input type="text" name="model[]" class="form-control modelSales'.($key+1).'" value="'.$value['model'].'" readonly></td><td><input type="text" name="chasis[]" class="form-control chasisSales'.($key+1).'" value="'.$value['chasis'].'" readonly></td><td><input type="text" name="motor[]"  class="form-control motorSales'.($key+1).'" value="'.$value['motor'].'" readonly></td><td><input type="text" name="colour[]" class="form-control colourSales'.($key+1).'" value="'.$value['colour'].'" readonly></td><td><input type="text" name="priceMovil[]" class="form-control priceSales'.($key+1).'" value="'.$value['priceMovil'].'" required></td><td><div class="btn-group"><button class="btn btn-danger btnDeleteItem"><i class="fas fa-times"></i></button></div></td></tr><input type="hidden" name="idMovil[]" class="form-control idMovilSales'.($key+1).'" value="'.$value['id_movil'].'"><input type="hidden" name="fabricacion[]" class="form-control fabricacionSales'.($key+1).'" value="'.$value['fabricacion'].'">';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-left btn btn-lg btn-default" href="sales">Cancelar</a>
                            <button type="submit" class="float-right btn btn-lg btn-primary">Actualizar</button>
                        </div>
                    </div>
                </div>
                <?php
                $updateSales = new ControllerSales();
                $updateSales->ctrUpdateSales();
                ?>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>