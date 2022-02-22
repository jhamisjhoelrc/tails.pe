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
                        <li class="breadcrumb-item"><a href="guiasRemision">Guias</a></li>
                        <li class="breadcrumb-item active">Ver guia</li>
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
                                <h3 class="card-title">Datos guía</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                    $item = 'id';
                                    $value = $_GET['guiasView'];
                                    $guia = ControllerGuias::ctrShowGuias('id', $value);
                                    
                                ?>
                                <div class="row pt-3">
                                    <!-- ENTRADA PARA SELECCIONAR EL COMPROBANTE AFECTADO -->
                                    <div class="form-group col-md-3">
                                        <label for="voucherAffected">Comprobante afecto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="voucherAffected" id="voucherAffected" value="<?php echo $guia['voucher_affected']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA EMISION -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditSale">Fecha emisión</label>
                                        <div class="input-group date" id="dateEditSale" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditSale" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateEmision" data-target="#dateEditSale" value="<?php echo $guia['broadcast_date']; ?>"/>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA FECHA DE TRASLADO -->
                                    <div class="form-group col-md-3">
                                        <label for="dateEditInicioTraslado">Fecha traslado</label>
                                        <div class="input-group date" id="dateEditInicioTraslado" data-target-input="nearest">
                                            <div class="input-group-append" data-target="#dateEditInicioTraslado" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="text" class="form-control datetimepicker-input" name="dateTraslate" data-target="#dateEditInicioTraslado" value="<?php echo $guia['transfer_start_date']; ?>"/>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL CLIENTE -->
                                    <div class="form-group col-md-3">
                                        <label for="nameCustomer">Cliente</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-plus"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="nameCustomer" id="nameCustomer" value="<?php echo $guia['name_customer']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR MODO DE TRASLADO -->
                                    <div class="form-group col-md-3">
                                        <label for="transferMode">Modo de traslado</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="transferMode" id="transferMode">
                                            <?php 
                                                if($guia['transfer_mode'] == '01'){
                                                    echo '<option value="01">Transporte público</option>';
                                                }else {
                                                    echo '<option value="02">Transporte privado</option>';
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL MOTIVO DE TRASLADO -->
                                    <div class="form-group col-md-3">
                                        <label for="motivoTraslado">Motivo de traslado</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fas fa-caravan"></i></span>
                                            <select class="form-control input-lg" style="width: 100%;" name="motivoTraslado" id="motivoTraslado">
                                                <option value=""><?php echo $guia['reason_message']; ?></option>
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
                                            <input type="text" class="form-control input-lg" name="weightTotal" id="weightTotal" value="<?php echo $guia['weight']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA OBSERVACION -->
                                    <div class="form-group col-md-3">
                                        <label for="observation">Observaciones</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="observation" id="observation" value="<?php echo $guia['observation']; ?>">
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
                                                <?php 
                                                    $entry = ModelSales::mdlShowDistricts('id',$guia['ubigeo_entry'],'ubigeo_peru_districts');
                                                    echo '<option>'.$entry['distrito'];'.</option>'
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
                                            <input type="text" class="form-control input-lg" name="provincePartida" id="provincePartida" value="<?php echo $entry['province']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL DEPARTEMENTO PARTIDA -->
                                    <div class="form-group col-md-3">
                                        <label for="departmentPartida">Departamento partida</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="departmentPartida" id="departmentPartida" value="<?php echo $entry['department']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA DIRECCIÓN PARTIDA -->
                                    <div class="form-group col-md-3">
                                        <label for="addressPartida">Dirección partida</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="addressPartida" id="addressPartida" value="<?php echo $guia['direction_entry']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA SELECCIONAR EL DISTRITO LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="districtLlegada">Distrito llegada</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                            <select class="form-control input-lg select2bs4" style="width: 100%;" name="districtLlegada" id="districtLlegada">
                                            <?php 
                                                $arrival = ModelSales::mdlShowDistricts('id',$guia['ubigeo_arrival'],'ubigeo_peru_districts');
                                                echo '<option>'.$arrival['distrito'];'.</option>'
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
                                            <input type="text" class="form-control input-lg" name="provinceLlegada" id="provinceLlegada" value="<?php echo $arrival['province']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL DEPARTEMENTO LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="departmentLlegada">Departamento llegada</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="departmentLlegada" id="departmentLlegada" value="<?php echo $arrival['department']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA DIRECCIÓN LLEGADA -->
                                    <div class="form-group col-md-3">
                                        <label for="addressLlegada">Dirección llegada</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="addressLlegada" id="addressLlegada" value="<?php echo $guia['direction_arrival']; ?>">
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
                                            <?php
                                                $document_type = ModelMant::mdlShowMant('documents_type','id',$guia['document_type_driver']);
                                                echo '<option>'.$document_type['description'].'</option>';
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
                                            <input type="text" class="form-control input-lg" name="documentNumberConductor" id="documentNumberConductor" value="<?php echo $guia['document_number_driver']; ?>">
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA EL NUMERO DE PLACA -->
                                    <div class="form-group col-md-3">
                                        <label for="plateNumberTransportista">Número de placa</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-truck-moving"></i></span>
                                            </div>
                                            <input type="text" class="form-control input-lg" name="plateNumberTransportista" id="plateNumberTransportista" value="<?php echo $guia['plate_number']; ?>">
                                            <input type="hidden" name="id_invoicing" id="id_invoicing" >
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a type="button" class="float-right btn btn-lg btn-primary" href="guiasRemision">Regresar</a>
                            <!-- <button type="submit" class="float-right btn btn-lg btn-primary">Registrar</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>