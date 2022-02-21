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
                        <li class="breadcrumb-item"><a href="guias">Guias</a></li>
                        <li class="breadcrumb-item active">Crear guia</li>
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
                        <?php
                            // CONSULTANDO EL USUARIO
                            $users = ControllerMant::ctrShowMant('users', 'id', $_SESSION['id_user']);
                            $id_subsidiary = $users['id_subsidiary'];
                            // CONSULTANDO EL ESTABLECIMIENTO
                            $subsidiary = ControllerMant::ctrShowMant('subsidiarys','id', $id_subsidiary);
                            $serie = $subsidiary['serie'];
                            // CONSULTANDO EL UBIGEO DEL ESTABLECIMIENTO
                            $ubigeo_entry = ControllerSales::ctrShowDistricts('id', $subsidiary['id_district']);
                        ?>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Datos guía</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR TIPO DE COMPROBANTE AFECTADO -->
                                    <div class="form-group col-md-3">
                                        <label for="type_voucher">Tipo comprobante</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="type_voucher" id="type_voucher">
                                                <option value="01">Factura</option>
                                                <option value="03">Boleta</option>
                                                <option value="99">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL COMPROBANTE AFECTADO -->
                                    <div class="form-group col-md-3">
                                        <label for="voucherAffected">Comprobante afecto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="voucherAffected" id="voucherAffecteded">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateSale">Fecha emisión</label>
                                        <div class="input-group date" id="dateSale" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateSale" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateEmision" data-target="#dateSale" required/>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA DE TRASLADO -->
                                    <div class="form-group col-md-3">
                                        <label for="dateInicioTraslado">Fecha traslado</label>
                                        <div class="input-group date" id="dateInicioTraslado" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateInicioTraslado" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateTraslate" data-target="#dateInicioTraslado" required/>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL CLIENTE -->
                                    <div class="form-group col-md-3">
                                        <label for="nameCustomer">Cliente</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-plus"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="nameCustomer" id="nameCustomer">
                                            <input type="hidden" name="id_customer" id="id_customer">
                                            <input type="hidden" name="serie_subsidiary" id="serie_subsidiary" value="<?php echo $serie; ?>">
                                            <input type="hidden" name="id_subsidiary" id="id_subsidiary" value="<?php echo $id_subsidiary; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR MODO DE TRASLADO -->
                                    <div class="form-group col-md-3">
                                        <label for="transferMode">Modo de traslado</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="transferMode" id="transferMode">
                                                <option value="01">Transporte público</option>
                                                <option value="02">Transporte privado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL MOTIVO DE TRASLADO -->
                                    <div class="form-group col-md-3">
                                        <label for="motivoTraslado">Motivo de traslado</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="motivoTraslado" id="motivoTraslado">
                                                <option value="01">Venta</option>
                                                <option value="02">Compra</option>
                                                <option value="04">Traslado entre establecimientos de la misma empresa</option>
                                                <option value="08">Importación</option>
                                                <option value="09">Exportación</option>
                                                <option value="13">Otros</option>
                                                <option value="14">Venta sujeta a confirmación del comprador</option>
                                                <option value="18">Traslado emisor itinerante CP</option>
                                                <option value="19">Traslado a zona primaria</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL PESO TOTAL -->
                                    <div class="form-group col-md-3">
                                        <label for="weightTotal">Peso total</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="weightTotal" id="weightTotal" value="0.00">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA OBSERVACION -->
                                    <div class="form-group col-md-3">
                                        <label for="observation">Observaciones</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="observation" id="observation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Datos de partida y llegada</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    
                                    <!-- ENTRADA PARA SELECCIONAR EL DISTRITO PARTIDA -->
                                    <div class="form-group col-md-3">
                                        <label for="districtPartida">Distrito partida</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="districtPartida" id="districtPartida">
                                                <option value="<?php echo $subsidiary['id_district']; ?>"><?php echo $ubigeo_entry['distrito']; ?></option>
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
                                    <!-- ENTRADA PARA LA PROVINCIA PARTIDA -->
                                    <div class="form-group col-md-3">
                                        <label for="provincePartida">Provincia partida</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="provincePartida" id="provincePartida" value="<?php echo $ubigeo_entry['province']; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL DEPARTEMENTO PARTIDA -->
                                    <div class="form-group col-md-3">
                                        <label for="departmentPartida">Departamento partida</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="departmentPartida" id="departmentPartida" value="<?php echo $ubigeo_entry['department']; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA DIRECCIÓN PARTIDA -->
                                    <div class="form-group col-md-3">
                                        <label for="addressPartida">Dirección partida</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="addressPartida" id="addressPartida" value="<?php echo $subsidiary['address']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL DISTRITO LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="districtLlegada">Distrito llegada</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="districtLlegada" id="districtLlegada">
                                                <option selected>Selecciona el distrito</option>
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
                                    <!-- ENTRADA PARA LA PROVINCIA LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="provinceLlegada">Provincia llegada</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="provinceLlegada" id="provinceLlegada" readonly>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL DEPARTEMENTO LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="departmentLlegada">Departamento partida</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="departmentLlegada" id="departmentLlegada" readonly>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA DIRECCIÓN LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="addressLlegada">Dirección llegada</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="addressLlegada" id="addressLlegada" placeholder="Ingresar dirección de llegada">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Datos conductor</h3>
                            </div>
                            <div class="card-body">
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR EL TIPO DE DOCUMENTO -->
                                    <div class="form-group col-md-3">
                                        <label for="documentTypeAddConductor">Tipo documento Identidad</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-bandcamp"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="documentTypeAddConductor" id="documentTypeAddConductor">
                                                <option value="">Tipo de documento</option>
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
                                    <!-- ENTRADA PARA EL NUMERO DE DOCUMENTO CONDUCTOR -->
                                    <div class="form-group col-md-3">
                                        <label for="documentNumberConductor">Número de documento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" placeholder="Ingresar n° conductor" name="documentNumberConductor" id="documentNumberConductor">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL NUMERO DE PLACA -->
                                    <div class="form-group col-md-3">
                                        <label for="plateNumberTransportista">Número de placa</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-truck-moving"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" placeholder="Ingresar la placa" name="plateNumberTransportista" id="plateNumberTransportista">
                                            <input type="hidden" name="id_invoicing" id="id_invoicing" value="<?php echo $sale['id_invoicing']; ?>">
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
                                    <div class="form-group col-md-3 my-3">
                                        <label for="motorAddGuia">Buscar por motor</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mr-2" placeholder="Código de motor" aria-label="" aria-describedby="basic-addon2" name="motorAddGuia" id="motorAddGuia">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 my-3">
                                        <label for="chasisAddGuia">Buscar por chasis</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mr-2" placeholder="Código de chasis" aria-label="" aria-describedby="basic-addon2" name="chasisAddGuia" id="chasisAddGuia">
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
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-left btn btn-lg btn-default" href="guiasRemision">Cancelar</a>
                            <button type="submit" class="float-right btn btn-lg btn-primary">Registrar</button>
                        </div>
                    </div>
                </div>
                <?php
                $addGuias = new ControllerGuias();
                $addGuias->ctrCreateGuias();
                ?>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>