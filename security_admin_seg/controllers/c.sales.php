<?php

class ControllerSales
{

    #FUNCION PARA ENCONTRAR DATOS DE DISTRITO, DEPARTAMENTO Y PROVINCIA
    static public function ctrShowDistricts($item, $value)
    {
        $table = 'ubigeo_peru_districts';
        $response = ModelSales::mdlShowDistricts($item, $value, $table);
        return $response;
    }
    #FUNCION PARA ENCONTRAR DATOS DE LA VENTA
    static public function ctrShowSales($item, $value)
    {
        $table = 'sales';
        $response = ModelSales::mdlShowSales($table, $item, $value);
        return $response;
    }
    #FUNCION PARA ENCONTRAR DATOS DEL DETALLE DE LA VENTA
    static public function ctrShowDetailSales($item, $value)
    {
        $table = 'detail_sales';
        $response = ModelSales::mdlShowDetailSales($table, $item, $value);
        return $response;
    }
    #FUNCION PARA ENCONTRAR DATOS DEL CRONOGRAMA NEGOCIABLE DE LA VENTA
    static public function ctrShowCronograma($item, $value)
    {
        $table = 'cronograma_negociable';
        $response = ModelSales::mdlShowCronograma($table, $item, $value);
        return $response;
    }
    #FUNCION PARA ENCONTRAR DATOS DEL COMPROBANTE ELECTRONICO
    static public function ctrShowInvoicing($item, $value)
    {
        $table = 'invoicing';
        $response = ModelSales::mdlShowInvoicing($table, $item, $value);
        return $response;
    }

    #FUNCION PARA ENCONTRAR DATOS DE LOS PAGOS DE VENTA
    static public function ctrShowPayd($item, $value)
    {
        $table = 'payment_sales';
        $response = ModelSales::mdlShowPayd($table, $item, $value);
        return $response;
    }

    #FUNCION PARA ENCONTRAR DATOS DE LA VENTA ESPECIFICA
    static public function ctrShowSalesNotacredito($item, $value)
    {
        $table = 'sales';
        $response = ModelSales::mdlShowSalesNotacredito($table, $item, $value);
        return $response;
    }

    #FUNCION PARA CREAR EL REGISTRO DE PAGOS DE UNA VENTA
    static public function ctrCreatePayment()
    {
        if (isset($_POST['dateAddPayment'])) {
            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            // PREPARANDO DATOS PARA INSERTAR DETALLE DE PAGOS
            $idSale = $_POST['idSale'];
            $dateAddPayments = ($_POST['dateAddPayment']);
            $paymentMethodAddPayments = ($_POST['paymentMethodAddPayment']);
            $destinyAddPayments = ($_POST['destinyAddPayment']);
            $referenceAddPayments = ($_POST['referenceAddPayment']);
            $amountAddPayments = ($_POST['amountAddPayment']);

            // INSERTANDO DETALLE EN PAGOS
            while (true) {
                $dateAddPayment = current($dateAddPayments);
                $paymentMethodAddPayment = current($paymentMethodAddPayments);
                $destinyAddPayment = current($destinyAddPayments);
                $referenceAddPayment = current($referenceAddPayments);
                $amountAddPayment = current($amountAddPayments);

                $date = (($dateAddPayment !== false) ? $dateAddPayment : ", &nbsp;");
                $method = (($paymentMethodAddPayment !== false) ? $paymentMethodAddPayment : ", &nbsp;");
                $destiny = (($destinyAddPayment !== false) ? $destinyAddPayment : ", &nbsp;");
                $reference = (($referenceAddPayment !== false) ? $referenceAddPayment : ", &nbsp;");
                $amount = (($amountAddPayment !== false) ? $amountAddPayment : ", &nbsp;");

                $valores = '(NULL,' . $idSale . ',"' . $date . '","' . $method . '","' . $destiny . '","' . $reference . '",' . $amount . ',' . $_SESSION['id_user'] . ',"' . $currentDate . '", NULL, NULL),';
                $valoresQ = substr($valores, 0, -1);
                
                // INSERTAR DETALLE DE PAGOS
                $responseDetalle = ModelSales::mdlCreateDetailPayment('payment_sales', $valoresQ);
                
                $dateAddPayment = next($dateAddPayments);
                $paymentMethodAddPayment = next($paymentMethodAddPayments);
                $destinyAddPayment = next($destinyAddPayments);
                $referenceAddPayment = next($referenceAddPayments);
                $amountAddPayment = next($amountAddPayments);

                if ($dateAddPayment === false && $paymentMethodAddPayment === false && $destinyAddPayment === false && $referenceAddPayment === false && $amountAddPayment === false) break;
            }

            // RESPUESTA DE LA INSERCI??N DE DETALLE DE PAGOS
            if ($responseDetalle == 'ok') {
                echo '
                <script>
                window.onload=function() {
                Swal.fire({
                    icon: "success",
                    title: "Pagos registrados correctamente",
                    text: "Los pagos fueron registrados correctamente!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.value) {
                    window.location = "sales";
                    }
                })
                }
                </script>';
            } else {
                echo '
                <script>
                window.onload=function() {
                    Swal.fire({
                    icon: "error",
                    title: "Ocurri?? un error al registrar los pagos",
                    text: "Revisar, pagos contienen errores!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then((result) => {
                    if (result.value) {
                        window.location = "sales";
                    }
                    })
                }
                </script>';
            }

        }
    }
    #FUNCION PARA CREAR EL REGISTRO DE VENTAS
    static public function ctrCreateSales()
    {

        if (isset($_POST['nameCustomerAddSales'])) {
            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            // VALIDANDO EL TIPO DE CAMBIO DE LA FECHA DE LA VENTA
            $responseExchange = ControllerMant::ctrShowMant('exchange', 'date_exchange', $_POST['dateAddSales']);
            if ($responseExchange) { // SI EXISTE TIPO DE CAMBIO

                //DEFINIENDO VALOR DE TIPO DE CAMBIO
                $cambio = $responseExchange['value_exchange'];

                if (
                    preg_match('/^[0-9]*$/', $_POST['documentTypeAddSales']) &&
                    preg_match('/^[0-9]*$/', $_POST['sellerAddSales'])
                ) {
                    // VALIDANDO SI EL CLIENTE EXISTE EN BD
                    $validateCustomer = ModelCustomers::mdlShowCustomers('customers', 'document_number', $_POST['documentNumberAddSales']);

                    if ($validateCustomer) { //SI EXISTE UN CLIENTE EN BD
                        $dataCustomer = array(
                            'id' => $_POST['idCustomer'],
                            'names' => strtoupper($_POST['nameCustomerAddSales']),
                            'id_document' => $_POST['documentTypeAddSales'],
                            'document_number' => $_POST['documentNumberAddSales'],
                            'email' => $_POST['emailAddSales'],
                            'phone' => $_POST['phoneAddSales'],
                            'address' => $_POST['addressCustomerAddSales'],
                            'customer_type' => $_POST['customerTypeAddSales'],
                            'user_update' => $_SESSION['id_user'],
                            'date_update' => $currentDate
                        );

                        $updateCustomer = ModelCustomers::mdlEditCustomers('customers', $dataCustomer);
                        $idCustomer = $dataCustomer['id'];
                    } else { // NO EXISTE UN CLIENTE EN BD
                        $dataCustomer = array(
                            "names" => strtoupper($_POST['nameCustomerAddSales']),
                            "id_document" => $_POST['documentTypeAddSales'],
                            "document_number" => $_POST['documentNumberAddSales'],
                            "phone" => $_POST['phoneAddSales'],
                            "email" => $_POST['emailAddSales'],
                            "customer_type" => $_POST['customerTypeAddSales'],
                            "address" => $_POST['addressCustomerAddSales'],
                            "user_create" => $_SESSION['id_user'],
                            "date_create" => $currentDate
                        );

                        // INSERTANDO UN NUEVO CLIENTE
                        $response = ModelCustomers::mdlCreateCustomers('customers', $dataCustomer);
                        if ($response == 'ok') {
                            // CONSULTANDO ID DE CLIENTE
                            $id = ModelSales::mdlConsultId('customers');
                            $idCustomer = $id;
                        }
                    }

                    // PREPARANDO DATOS PARA LA VENTA
                    $dataSales = array(
                        "id_invoicing" => null,
                        "id_customer" => $idCustomer,
                        "id_district" => $_POST['districtAddSales'],
                        "id_subsidiary" => $_POST['idSubsidiary'],
                        "id_seller" => $_POST['sellerAddSales'],
                        "currency" => $_POST['currencyAddSales'],
                        "date_sale" => $_POST['dateAddSales'],
                        "payment_condition" => $_POST['paymentConditionAddSales'],
                        "price_tramit" => $_POST['priceTramiteAddSales'],
                        "subtotal_tramit" => 0,
                        "importe_igv_tramit" => 0,
                        "price_transport" => $_POST['priceTransportAddSales'],
                        "subtotal_transport" => 0,
                        "importe_igv_transport" => 0,
                        "price_placa" => $_POST['pricePlacaAddSales'],
                        "subtotal_placa" => 0,
                        "importe_igv_placa" => 0,
                        "total_price" => 0,
                        "type_operation" => $_POST['typeOperationAddSales'],
                        "type_voucher" => $_POST['typeVoucherAddSales'],
                        "hour"        => $hour,
                        "exchange"    => $cambio,
                        "send_sunat" => 'NO',
                        "tasaIgv" => 18,
                        "user_create" => $_SESSION['id_user'],
                        "date_create" => $currentDate,
                        "status_correlative" => 'SIGNED'
                    );

                    // PREPARANDO DATOS PARA INSERTAR DETALLE DE VENTAS
                    $idmoviles = ($_POST['idMovil']);
                    $priceMoviles = ($_POST['priceMovil']);

                    // PREPARANDO DATOS PARA INSERTAR CRONOGRAMA DE PAGOS
                    if($dataSales['payment_condition'] == 'Cr??dito'){
                        $date_payds = ($_POST['dateCronograma']);
                        $amounts = ($_POST['montoCronograma']);
                    }else {
                        $date_payds = NULL;
                        $amounts = NULL;
                    }

                    // REVISANDO SI SE ACTIVO EL CHECK PARA ENVIAR COMPROBANTE A SUNAT
                    if (isset($_POST['checkSendSunat'])) { // SI SE ENVI?? EL CHECK PARA ENVIAR A SUNAT
                        $dataSales['send_sunat'] = 'SI';
                        
                        // LLAMANDO A LA FACTURACI??N ELECTRONICA PARA GENERAR FACTURAS O BOLETAS
                        $response_bizlinks = ControllerApiFacturation::ctrSendFactBol($dataSales, $idmoviles, $priceMoviles, $date_payds, $amounts);

                        if ($response_bizlinks == 'vacio') {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al registrar el comprobante",
                                text: "Bizlinks no envi?? el mensaje de respuesta!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        } else if ($response_bizlinks == 'error') {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al registrar el comprobante",
                                text: "Error de comunicaci??n!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        }  else if ($response_bizlinks == 'ok_er') {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al registrar el comprobante",
                                text: "Revisar, el comprobante contiene errores!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        } else if ($response_bizlinks == 'ok_pe') {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al registrar el comprobante",
                                text: "Comprobante pendiente, el comprobante contiene errores!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        } else {
                            echo '
                            <script>
                            window.onload=function() {
                            Swal.fire({
                                icon: "success",
                                title: "Comprobante registrado correctamente",
                                text: "El comprobante fue registrado correctamente!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            }).then((result) => {
                                if (result.value) {
                                window.location = "sales";
                                }
                            })
                            }
                            </script>';
                        }

                        /* echo '<pre>';
                        var_dump($response_bizlinks);
                        echo '</pre>'; */

                    } else { // NO SE ENVI?? EL CHECK PARA ENVIAR A SUNAT
                        $dataSales['send_sunat'] = 'NO';
                        // INSERTANDO DATOS EN SALES
                        $id_sales = ModelSales::mdlCreateSales('sales', $dataSales);

                        // CAPTURANDO TOTAL INICIAL DE LA VENTA
                        $sumandototal = number_format($dataSales['price_tramit'] + $dataSales['price_transport'] + $dataSales['price_placa'], 2, '.', '');

                        // INSERTANDO DETALLE EN SALES
                        while (true) {
                            $idmovil = current($idmoviles);
                            $pricemovil = current($priceMoviles);

                            $idm = (($idmovil !== false) ? $idmovil : ", &nbsp;");
                            $price = (($pricemovil !== false) ? $pricemovil : ", &nbsp;");

                            // SUMANDO EL TOTAL DE LA VENTA
                            $sumandototal = $sumandototal + $price;

                            // DESCONTANDO EL STOCK DEL MOVIL
                            $dataMovilStock = array(
                                "id_movil" => $idm,
                                "user_update" => $_SESSION['id_user'],
                                "date_update" => $currentDate
                            );
                            $responseMovil = ModelSales::mdlUpdateMovil('moviles', $dataMovilStock);

                            $valores = '(null,' . $id_sales . ',"' . $idm . '","' . $price . '"),';
                            $valoresQ = substr($valores, 0, -1);
                            // INSERTAR DETALLE DE VENTAS
                            $responseDetalle = ModelSales::mdlCreateDetailSales('detail_sales', $valoresQ);

                            $idmovil = next($idmoviles);
                            $pricemovil = next($priceMoviles);

                            if ($idmovil === false && $pricemovil === false) break;
                        }

                        if($dataSales['payment_condition'] == 'Cr??dito'){
                            // INSERTANDO DETALLE DE CRONOGRAMA DE PAGOS
                            while (true) {
                                $date_payd = current($date_payds);
                                $amount = current($amounts);
        
                                $date = (($date_payd !== false) ? $date_payd : ", &nbsp;");
                                $amou = (($amount !== false) ? $amount : ", &nbsp;");
        
                                $valores = '(null,' . $id_sales . ',"' . $date . '","' . $amou . '",1,"' . $_SESSION['id_user'] . '","' . $currentDate . '", NULL, NULL),';
                                $valoresQ = substr($valores, 0, -1);
                                // INSERTAR CRONOGRAMA DE NEGOCIABLE
                                $responseDetalleCronograma = ModelSales::mdlCreateCronogramaNegociable('cronograma_negociable', $valoresQ);
        
                                $date_payd = next($date_payds);
                                $amount = next($amounts);
        
                                if ($date_payd === false && $amount === false) break;
                            }
                        }

                        // ACTUALIZAR EL MONTO TOTAL DE LA VENTA
                        $updateTotalSales = ModelSales::mdlUpdateTotalSales('sales', $id_sales, $sumandototal);

                        // RESPUESTA DE LA INSERCI??N DE DETALLE DE VENTAS
                        if ($responseDetalle == 'ok') {
                            echo '
                            <script>
                            window.onload=function() {
                            Swal.fire({
                                icon: "success",
                                title: "Venta registrada correctamente",
                                text: "El documento no fue enviado a SUNAT!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            }).then((result) => {
                                if (result.value) {
                                window.location = "sales";
                                }
                            })
                            }
                            </script>';
                        } else {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al registrar la venta",
                                text: "Revisar, venta contiene errores!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        }
                    }
                }
            } else { // NO EXISTE TIPO DE CAMBIO
                echo '<script>
                window.onload=function() {
                    Swal.fire({
                    icon: "error",
                    title: "Error de tipo de cambio",
                    text: "No se encontr?? tipo de cambio!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then((result) => {
                    if (result.value) {
                        window.location = "addSales";
                    }
                    })
                }
                </script>';
            }
        }
    }

    # FUNCION PARA CONSULTA RUC
    static public function ctrConsultaruc($token, $document_number, $document_type){
        // Iniciar llamada a API
        $curl = curl_init();

        // Buscar ruc sunat
        if($document_type == 6){
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.apis.net.pe/v1/ruc?numero=' . $document_number,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Referer: http://apis.net.pe/api-ruc',
                    'Authorization: Bearer ' . $token
                ),
                ));
        }else {
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $document_number,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 2,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                  'Referer: https://apis.net.pe/consulta-dni-api',
                  'Authorization: Bearer ' . $token
                ),
            ));
        }

        $response = curl_exec($curl);

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        curl_close($curl);
        // Datos de empresas seg??n padron reducido
        
        $data_response = json_decode($response);
        return $data_response;
        
        
    }
    

    #FUNCION PARA ACTUALIZAR EL REGISTRO DE VENTAS
    static public function ctrUpdateSales()
    {

        if (isset($_POST['nameCustomerAddSales'])) {
            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            // VALIDANDO EL TIPO DE CAMBIO DE LA FECHA DE LA VENTA
            $responseExchange = ControllerMant::ctrShowMant('exchange', 'date_exchange', $_POST['dateAddSales']);
            if ($responseExchange) { // SI EXISTE TIPO DE CAMBIO

                //DEFINIENDO VALOR DE TIPO DE CAMBIO
                $cambio = $responseExchange['value_exchange'];

                if (
                    preg_match('/^[0-9]*$/', $_POST['documentTypeAddSales']) &&
                    preg_match('/^[0-9]*$/', $_POST['sellerAddSales'])
                ) {
                    // VALIDANDO SI EL CLIENTE EXISTE EN BD
                    $validateCustomer = ModelCustomers::mdlShowCustomers('customers', 'document_number', $_POST['documentNumberAddSales']);

                    if ($validateCustomer) { //SI EXISTE UN CLIENTE EN BD
                        $dataCustomer = array(
                            'id' => $_POST['idCustomer'],
                            'names' => strtoupper($_POST['nameCustomerAddSales']),
                            'id_document' => $_POST['documentTypeAddSales'],
                            'document_number' => $_POST['documentNumberAddSales'],
                            'email' => $_POST['emailAddSales'],
                            'phone' => $_POST['phoneAddSales'],
                            'address' => $_POST['addressCustomerAddSales'],
                            'customer_type' => $_POST['customerTypeAddSales'],
                            'user_update' => $_SESSION['id_user'],
                            'date_update' => $currentDate
                        );

                        $updateCustomer = ModelCustomers::mdlEditCustomers('customers', $dataCustomer);
                        $idCustomer = $dataCustomer['id'];
                    } else { // NO EXISTE UN CLIENTE EN BD
                        $dataCustomer = array(
                            "names" => strtoupper($_POST['nameCustomerAddSales']),
                            "id_document" => $_POST['documentTypeAddSales'],
                            "document_number" => $_POST['documentNumberAddSales'],
                            "phone" => $_POST['phoneAddSales'],
                            "email" => $_POST['emailAddSales'],
                            "customer_type" => $_POST['customerTypeAddSales'],
                            "address" => $_POST['addressCustomerAddSales'],
                            "user_create" => $_SESSION['id_user'],
                            "date_create" => $currentDate
                        );

                        // INSERTANDO UN NUEVO CLIENTE
                        $response = ModelCustomers::mdlCreateCustomers('customers', $dataCustomer);
                        if ($response == 'ok') {
                            // CONSULTANDO ID DE CLIENTE
                            $id = ModelSales::mdlConsultId('customers');
                            $idCustomer = $id;
                        }
                    }

                    // PREPARANDO DATOS PARA LA VENTA
                    $dataSales = array(
                        "id_sale" => $_POST['idSale'],
                        "id_invoicing" => null,
                        "id_customer" => $idCustomer,
                        "id_district" => $_POST['districtAddSales'],
                        "id_subsidiary" => $_POST['idSubsidiary'],
                        "id_seller" => $_POST['sellerAddSales'],
                        "currency" => $_POST['currencyAddSales'],
                        "date_sale" => $_POST['dateAddSales'],
                        "payment_condition" => $_POST['paymentConditionAddSales'],
                        "price_tramit" => $_POST['priceTramiteAddSales'],
                        "subtotal_tramit" => 0,
                        "importe_igv_tramit" => 0,
                        "price_transport" => $_POST['priceTransportAddSales'],
                        "subtotal_transport" => 0,
                        "importe_igv_transport" => 0,
                        "price_placa" => $_POST['pricePlacaAddSales'],
                        "subtotal_placa" => 0,
                        "importe_igv_placa" => 0,
                        "total_price" => 0,
                        "type_operation" => $_POST['typeOperationAddSales'],
                        "type_voucher" => $_POST['typeVoucherAddSales'],
                        "hour"        => $hour,
                        "exchange"    => $cambio,
                        "send_sunat" => 'NO',
                        "tasaIgv" => 18,
                        "user_create" => $_SESSION['id_user'],
                        "date_create" => $currentDate,
                        "status_correlative" => 'SIGNED'
                    );

                    if($dataSales['price_tramit'] == '0.00'){
                        $dataSales['price_tramit'] = NULL;
                    }
                    if($dataSales['price_transport'] == '0.00'){
                        $dataSales['price_transport'] = NULL;
                    }
                    if($dataSales['price_placa'] == '0.00'){
                        $dataSales['price_placa'] = NULL;
                    }

                    // PREPARANDO DATOS PARA INSERTAR DETALLE DE VENTAS
                    $idmoviles = ($_POST['idMovil']);
                    $priceMoviles = ($_POST['priceMovil']);

                    // PREPARANDO DATOS PARA INSERTAR CRONOGRAMA DE PAGOS
                    if($dataSales['payment_condition'] == 'Cr??dito'){
                        $date_payds = ($_POST['dateCronograma']);
                        $amounts = ($_POST['montoCronograma']);
                    }else {
                        $date_payds = NULL;
                        $amounts = NULL;
                    }

                    // REVISANDO SI SE ACTIVO EL CHECK PARA ENVIAR COMPROBANTE A SUNAT
                    if (isset($_POST['checkSendSunat'])) { // SI SE ENVI?? EL CHECK PARA ENVIAR A SUNAT
                        $dataSales['send_sunat'] = 'SI';
                        
                        // LLAMANDO A LA FACTURACI??N ELECTRONICA PARA GENERAR FACTURAS O BOLETAS
                        $response_bizlinks = ControllerApiFacturation::ctrSendFactBol($dataSales, $idmoviles, $priceMoviles, $date_payds, $amounts);

                        if ($response_bizlinks == 'vacio') {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al actualizar el comprobante",
                                text: "Bizlinks no envi?? el mensaje de respuesta!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        } else if ($response_bizlinks == 'error') {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al actualizar el comprobante",
                                text: "Error de comunicaci??n!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        }  else if ($response_bizlinks == 'ok_er') {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al actualizar el comprobante",
                                text: "Revisar, el comprobante contiene errores!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        } else if ($response_bizlinks == 'ok_pe') {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al actualizar el comprobante",
                                text: "Comprobante pendiente, el comprobante contiene errores!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        } else {
                            echo '
                            <script>
                            window.onload=function() {
                            Swal.fire({
                                icon: "success",
                                title: "Comprobante actualizado correctamente",
                                text: "El comprobante fue actualizado correctamente!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            }).then((result) => {
                                if (result.value) {
                                window.location = "sales";
                                }
                            })
                            }
                            </script>';
                        }

                        // echo '<pre>';
                        // var_dump($dataSales);
                        // echo '</pre>';

                    } else { // NO SE ENVI?? EL CHECK PARA ENVIAR A SUNAT
                        $dataSales['send_sunat'] = 'NO';
                        // ACTUALIZANDO DATOS EN SALES
                        $updateSales = ModelSales::mdlUpdateSale('sales', $dataSales);

                        // CAPTURANDO TOTAL INICIAL DE LA VENTA
                        $sumandototal = number_format($dataSales['price_tramit'] + $dataSales['price_transport'] + $dataSales['price_placa'], 2, '.', '');

                        // CONSULTANDO LOS DETALLES DE SALES PARA SU ELIMINACION
                        $response_detail_sales = ModelSales::mdlShowDetailSales('detail_sales', 'id_sales', $dataSales['id_sale']);

                        # REGISTRAR FECHA Y HORA ACTUAL
                        date_default_timezone_set('America/Lima');
                        $date = date('Y-m-d');
                        $hour = date('H:i:s');
                        $currentDate = $date . ' ' . $hour;

                        // REVERSA DEL STOCK DEL MOVIL
                        foreach ($response_detail_sales as $key => $value) {
                            $dataMovilStock = array(
                                "id_movil" => $value['id_movil'],
                                "status" => 1,
                                "user_update" => $_SESSION['id_user'],
                                "date_update" => $currentDate
                            );
                            $responseMovil = ModelSales::mdlUpdateMovil('moviles', $dataMovilStock);
                        }
                        // ELIMINANDO DETALLE DE VENTAS
                        $delete = ModelSales::mdlDelete('detail_sales', 'id_sales', $dataSales['id_sale']);
                        
                        // INSERTANDO DETALLE EN SALES
                        while (true) {
                            $idmovil = current($idmoviles);
                            $pricemovil = current($priceMoviles);

                            $idm = (($idmovil !== false) ? $idmovil : ", &nbsp;");
                            $price = (($pricemovil !== false) ? $pricemovil : ", &nbsp;");

                            // SUMANDO EL TOTAL DE LA VENTA
                            $sumandototal = $sumandototal + $price;

                            // DESCONTANDO EL STOCK DEL MOVIL
                            $dataMovilStock = array(
                                "id_movil" => $idm,
                                "status" => 5,
                                "user_update" => $_SESSION['id_user'],
                                "date_update" => $currentDate
                            );
                            $responseMovil = ModelSales::mdlUpdateMovil('moviles', $dataMovilStock);

                            $valores = '(null,' . $dataSales['id_sale'] . ',"' . $idm . '","' . $price . '"),';
                            $valoresQ = substr($valores, 0, -1);
                            // INSERTAR DETALLE DE VENTAS
                            $responseDetalle = ModelSales::mdlCreateDetailSales('detail_sales', $valoresQ);

                            $idmovil = next($idmoviles);
                            $pricemovil = next($priceMoviles);

                            if ($idmovil === false && $pricemovil === false) break;
                        }

                        if($dataSales['payment_condition'] == 'Cr??dito'){
                            // ELIMINANDO EL DETALLE DE LA TABLA CRONOGRAMA NEGOCIABLE
                            $delete = ModelSales::mdlDelete('cronograma_negociable', 'id_sale', $dataSales['id_sale']);

                            // INSERTANDO DETALLE DE CRONOGRAMA DE PAGOS
                            while (true) {
                                $date_payd = current($date_payds);
                                $amount = current($amounts);
        
                                $date = (($date_payd !== false) ? $date_payd : ", &nbsp;");
                                $amou = (($amount !== false) ? $amount : ", &nbsp;");
        
                                $valores = '(null,' . $dataSales['id_sale'] . ',"' . $date . '","' . $amou . '",1,"' . $_SESSION['id_user'] . '","' . $currentDate . '", NULL, NULL),';
                                $valoresQ = substr($valores, 0, -1);
                                // INSERTAR CRONOGRAMA DE NEGOCIABLE
                                $responseDetalleCronograma = ModelSales::mdlCreateCronogramaNegociable('cronograma_negociable', $valoresQ);
        
                                $date_payd = next($date_payds);
                                $amount = next($amounts);
        
                                if ($date_payd === false && $amount === false) break;
                            }
                        }

                        // ACTUALIZAR EL MONTO TOTAL DE LA VENTA
                        $updateTotalSales = ModelSales::mdlUpdateTotalSales('sales', $dataSales['id_sale'], $sumandototal);

                        // RESPUESTA DE LA INSERCI??N DE DETALLE DE VENTAS
                        if ($responseDetalle == 'ok') {
                            echo '
                            <script>
                            window.onload=function() {
                            Swal.fire({
                                icon: "success",
                                title: "Venta actualizada correctamente",
                                text: "El documento no fue enviado a SUNAT!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            }).then((result) => {
                                if (result.value) {
                                window.location = "sales";
                                }
                            })
                            }
                            </script>';
                        } else {
                            echo '
                            <script>
                            window.onload=function() {
                                Swal.fire({
                                icon: "error",
                                title: "Error al actualizada la venta",
                                text: "Revisar, venta contiene errores!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                }).then((result) => {
                                if (result.value) {
                                    window.location = "sales";
                                }
                                })
                            }
                            </script>';
                        }
                    }
                }
            } else { // NO EXISTE TIPO DE CAMBIO
                echo '<script>
                window.onload=function() {
                    Swal.fire({
                    icon: "error",
                    title: "Error de tipo de cambio",
                    text: "No se encontr?? tipo de cambio!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then((result) => {
                    if (result.value) {
                        window.location = "addSales";
                    }
                    })
                }
                </script>';
            }
        }
    }
}
