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
                        <li class="breadcrumb-item active">Ver Nota</li>
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
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Datos del cliente</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                    $item = 'id';
                                    $value = $_GET['salesView'];
                                    $id_sales = $value;
                                    $sales = ControllerSales::ctrShowSales($item, $value);
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
                                        <label for="documentTypeEditSales">Tipo documento</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="documentTypeEditSales" id="documentTypeAddSales">
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
                                        <label for="documentNumberEditSales">Número de documento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="documentNumberEditSales" id="documentNumberAddSales" value="<?php echo $sales['document_number']; ?>" required>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL TELEFONO -->
                                    <div class="form-group col-md-3">
                                        <label for="phoneEditSales">Teléfono</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="phoneEditSales" id="phoneAddSales" value="<?php echo $sales['phone']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL EMAIL -->
                                    <div class="codeChine form-group col-md-3">
                                        <label for="emailEditSales">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="emailEditSales" id="emailAddSales" value="<?php echo $sales['email']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL TIPO DE CLIENTE -->
                                    <div class="form-group col-md-3">
                                        <label for="customerTypeEditSales">Tipo de cliente</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="customerTypeEditSales" id="customerTypeAddSales">
                                                <option value="<?php echo $sales['customer_type']; ?>"><?php echo $sales['customer_type']; ?></option>
                                                <option value="Final">Final</option>
                                                <option value="Distribuidor">Distribuidor</option>
                                                <option value="Distribuidor informal">Distribuidor informal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA DIRECCIÓN -->
                                    <div class="form-group col-md-6">
                                        <label for="addressCustomerEditSales">Dirección</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="addressCustomerEditSales" id="addressCustomerAddSales" value="<?php echo $sales['address']; ?>">
                                            <input type="hidden" id="idCustomer" name="idCustomer" value="<?php echo $sales['id_customer']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL DISTRITO -->
                                    <div class="form-group col-md-3">
                                        <label for="districtEditSales">Seleccionar el distrito</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="districtEditSales" id="districtAddSales">
                                                <option value="<?php echo $sales['id_district']; ?>"><?php echo $sales['district']; ?></option>
                                                <?php 
                                                    $table = 'ubigeo_peru_districts';
                                                    $item = null;
                                                    $value = null;
                                                    $response =  ControllerMant::ctrShowMant($table, $item, $value);
                                                    foreach ($response as $key => $value) {
                                                        echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                     <!-- ENTRADA PARA LA PROVINCIA -->
                                     <div class="form-group col-md-3">
                                        <label for="provinceEditSales">Provincia</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="provinceEditSales" id="provinceAddSales" value="<?php echo $sales['province']; ?>" readonly>
                                        </div>
                                    </div>
                                     <!-- ENTRADA PARA LA DIRECCIÓN -->
                                     <div class="form-group col-md-3">
                                        <label for="departmentEditSales">Departamento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="departmentEditSales" id="departmentAddSales" value="<?php echo $sales['department']; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA MONEDA -->
                                    <div class="form-group col-md-3">
                                        <label for="currencyEditSales">Moneda</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="currencyEditSales" id="currencyEditSales">
                                                <?php 
                                                    if($sales['currency'] == 'PEN'){
                                                        echo '<option value="PEN">Soles</option><option value="USD">Dólares</option>';
                                                    }else {
                                                        echo '<option value="USD">Dólares</option><option value="PEN">Soles</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Datos del documento</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA EL NOMBRE DE CLIENTE -->
                                    <div class="form-group col-md-3">
                                        <label for="subsidiaryAddSales">Sucursal</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-store-alt"></i></span>
                                            </div>
                                            <?php
                                                // CONSIGUIENDO EL LOCAL DEL USUARIO
                                                $subsidiarys = ControllerSubsidiary::ctrShowSubsidiary('id', $sales['id_subsidiary']);
                                            ?>
                                            <input type="text" class="form-control input-lg" name="subsidiaryAddSales" id="subsidiaryAddSales" value="<?php echo $subsidiarys['description']; ?>" readonly>
                                            <input type="hidden" id="idSubsidiary" name="idSubsidiary" value="<?php echo $sales['id_subsidiary']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA SELECCION DEL COMPROBANTE -->
                                    <div class="form-group col-md-3">
                                        <label for="typeVoucherEditSales">Seleccionar tipo comprobante</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="typeVoucherEditSales" id="typeVoucherEditSales">
                                            <?php 
                                                if($sales['type_voucher'] == '01'){
                                                    echo '<option value="01">Factura</option><option value="03">Boleta</option>';
                                                }else {
                                                    echo '<option value="03">Boleta</option><option value="01">Factura</option>';
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL VENDEDOR -->
                                    <div class="form-group col-md-3">
                                        <label for="sellerEditSales">Vendedor</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-tag nav-icon"></i></span>
                                            <select class="form-control input-lg select2bs4 " style="width: 100%;" name="sellerEditSales" id="sellerEditSales">
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
                                    <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditEmision">Fecha venta</label>
                                        <div class="input-group date" id="dateEditEmision" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditEmision" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateEditSales" data-target="#dateEditEmision" value="<?php echo $sales['date_sale']; ?>" />
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL METODO DE PAGO -->
                                    <div class="form-group col-md-3">
                                        <label for="paymentConditionEditSales">Condición de pago</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-cash-register"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="paymentConditionEditSales" id="paymentConditionEditSales">
                                                <option value="<?php echo $sales['payment_condition']; ?>"><?php echo $sales['payment_condition']; ?></option>
                                                <option value="Contado">Contado</option>
                                                <option value="Crédito directo">Crédito directo</option>
                                                <option value="Tarjeta POS">Tarjeta POS</option>
                                                <option value="Finanpop">Finanpop</option>
                                                <option value="Crediscotia">Crediscotia</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL PRECIO TRÁMITES -->
                                    <div class="form-group col-md-3">
                                        <label for="priceTramiteEditSales">Precio por trámites</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="priceTramiteEditSales" id="priceTramiteEditSales" value="<?php echo $sales['price_tramit']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL PRECIO TRANSPORTE -->
                                    <div class="form-group col-md-3">
                                        <label for="priceTransportEditSales">Precio por transporte</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="priceTransportEditSales" id="priceTransportEditSales" value="<?php echo $sales['price_transport']; ?>">
                                            <input type="hidden" name="id_sale" id="id_sale" value="<?php echo $id_sales; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL PRECIO PLACA -->
                                    <div class="form-group col-md-3">
                                        <label for="pricePlacaEditSales">Precio por placa</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="pricePlacaEditSales" id="pricePlacaEditSales" value="<?php echo $sales['price_placa']; ?>">
                                            <input type="hidden" name="total_price" id="total_price" value="<?php echo $sales['total_price']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Documento a modificar</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR EL TIPO DE DOCUMENTO -->
                                    <div class="form-group col-md-3">
                                        <label for="typeReferenceDocument">Tipo</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="typeReferenceDocument" id="typeReferenceDocument">
                                                <option value=""><?php if($sales['type_reference'] == '01'){ echo 'Factura';} else { echo 'Boleta'; } ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA INGRESAR EL NUMERO DEL COMPROBANTE AFECTADO -->
                                    <div class="form-group col-md-3">
                                        <label for="referenceDocument">Comprobante</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <input type="text" class="form-control mr-2" value="<?php echo $sales['reference']; ?>" aria-label="" aria-describedby="basic-addon2" name="referenceDocument" id="referenceDocument">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA SELECCION DEL MOTIVO POR MODIFICAR -->
                                    <div class="form-group col-md-3">
                                        <label for="motive">Motivo modificar</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="motive" id="motive">
                                                <option value="01"><?php echo $sales['motive']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">DETALLE</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- <div class="form-group col-md-3 my-3">
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
                                    </div> -->
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
                                                <?php
                                                /* echo $id_sales;                                                 */
                                                $detail = ControllerSales::ctrShowDetailSales('id_sales', $id_sales);
                                                foreach ($detail as $key => $val) {
                                                    echo '<tr>
                                                            <th scope="row" class="numberItem">'.($key+1).'</th>
                                                            <td><input type="text" name="category[]" class="form-control categorySales'.($key+1).'" value="'.$val['category'].'" ></td><td><input type="text" name="brand[]" class="form-control brandSales'.($key+1).'" value="'.$val['brand'].'" ></td><td><input type="text" name="model[]" class="form-control modelSales'.($key+1).'" value="'.$val['model'].'" ></td><td><input type="text" name="chasis[]" class="form-control chasisSales'.($key+1).'" value="'.$val['chasis'].'" ></td><td><input type="text" name="motor[]"  class="form-control motorSales'.($key+1).'" value="'.$val['motor'].'" ></td><td><input type="text" name="colour[]" class="form-control colourSales'.($key+1).'" value="'.$val['colour'].'" ></td><td><input type="text" name="priceMovil[]" class="form-control priceSales'.($key+1).'" value="'.$val['priceMovil'].'" required ></td><td><div class="btn-group"><button class="btn btn-danger btnDeleteItem" disabled><i class="fas fa-times"></i></button></div></td>
                                                        </tr>
                                                        <input type="hidden" name="idMovil[]" class="form-control idMovilSales'.($key+1).'" value="'.$val['id_movil'].'">
                                                        <input type="hidden" name="fabricacion[]" class="form-control fabricacionSales'.($key+1).'" value="'.$val['fabricacion'].'">';
                                                }
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-right btn btn-lg btn-primary" href="notas">Regresar</a>
                            <!-- <button type="submit" class="float-right btn btn-lg btn-primary">Regresar</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>