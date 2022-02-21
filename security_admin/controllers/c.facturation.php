<?php

require_once('views/plugins/cantidad_letras/cantidad_en_letras.php');

class ControllerApiFacturation
{


    #FUNCION PREPARAR DATOS PARA LA FACTURAS Y BOLETAS
    static public function ctrSendFactBol($dataSales, $idmoviles, $priceMoviles, $date_payds, $amounts)
    {

        // CAPTURANDO DATOS DEL USUARIO QUIEN EMITIÓ EL COMPROBANTE
        $palabra = explode(' ', $_SESSION['names_user']);
        $usuario = 'USU-';
        for ($i = 0; $i < count($palabra); $i++) {
            $usuario .= strtoupper(substr($palabra[$i], 0, 1));
        }

        // CAPTURANDO DATOS DEL EMISOR DEL COMPROBANTE
        $data_emisor = ModelFacturation::mdlShowConfiguration('configuration');
        $emisor =     array(
            'tipodoc'        => $data_emisor['tipodoc'],
            'ruc'             => $data_emisor['ruc'],
            'razon_social'    => $data_emisor['razon_social'],
            'email'         => $data_emisor['email_emisor'],
            'nombre_comercial'    => '-',
            'direccion'        => $data_emisor['direccion'],
            'pais'            => 'PE',
            'departamento'  => $data_emisor['departamento'],
            'provincia'        => $data_emisor['provincia'],
            'distrito'        => $data_emisor['distrito'],
            'ubigeo'        => $data_emisor['ubigeo'],
            'urlsoap'       => $data_emisor['url'],
            'usuariosoap'   => $data_emisor['usuario'],
            'passwordsoap'  => $data_emisor['password'],
            'usuario'       => $usuario
        );

        // CONSIGUIENDO DATOS DEL CLIENTE
        $data_customer = ModelCustomers::mdlShowCustomers('customers', 'id', $dataSales['id_customer']);
        $data_ubigeo = ModelSales::mdlShowDistricts('id', $dataSales['id_district'], 'ubigeo_peru_districts');

        $adquiriente = array(
            'tipodoc'                    => $data_customer['cod_sunat'],
            'numero_documento'            => $data_customer['document_number'],
            'razon_social'              => $data_customer['names'],
            'email'                     => $data_customer['email'],
            'direccion'                    => $data_customer['address'],
            'pais'                        => 'PE',
            'departamento'              => $data_ubigeo['department'],
            'provincia'                    => $data_ubigeo['province'],
            'ubigeo'                    => $dataSales['id_district'],
            'distrito'                  => $data_ubigeo['distrito'],
            'condicion_pago'            => $dataSales['payment_condition']
        );

        // PREPARAR PALABRA DE INICIO PARA LA SERIE DEL COMPROBANTE
        if ($dataSales['type_voucher'] == '01') {
            $inicio_serie = 'F';
        } else {
            $inicio_serie = 'B';
        }

        // CONSIGUIENDO DATOS DE LA SUCURSAL
        $subsidiary = ModelSubsidiary::mdlShowSubsidiary('subsidiarys', 'id', $dataSales['id_subsidiary']);

        // CONSULTANDO SI EXISTE CORRELATIVO EN LA SERIE PARA LOS SIGNED
        $consult_correlative = ModelFacturation::mdlUltimateCorrelative('invoicing', $dataSales['type_voucher'], 'serial_number', $inicio_serie . substr(str_repeat(0, 3) . $subsidiary['serie'], -3));

        // LOGICA PARA TOMAR EL ÚLTIMO CORRELATIVO DE LA SERIE
        if ($consult_correlative['correlative'] == '') { // NO HAY COMPROBANTES CON LA SERIE
            if ($inicio_serie == 'F') {
                $ultimate_correlative = $subsidiary['correlative_f'];
            } else {
                $ultimate_correlative = $subsidiary['correlative_b'];
            }
        } else { // SI HAY COMPROBANTES CON LA SERIE
            // VERIFICANDO SI EL CORRELATIVO TIENE ERROR
            if($consult_correlative['status_response'] == 'ERROR'){
                $ultimate_correlative = substr(str_repeat(0, 8) . $consult_correlative['correlative'], -8);
            }else {
                $ultimate_correlative = substr(str_repeat(0, 8) . ($consult_correlative['correlative'] + 1), -8);    
            }
        }

        // <---------- RECORRIENDO EL DETALLE DE VENTAS ------------>

        // VERIFICANDO SI EL LOCAL DE EMISIÓN ES EXONERADO DE IGV
        if ($subsidiary['exonerated'] == 'SI') {
            // VERIFICANDO SI ES FACTURA GRATUITA
            if($dataSales['type_operation'] == '03'){
                $codigo_ex = 21;
            }else {
                $codigo_ex = 20;
            }
        }else {
            // VERIFICANDO SI ES FACTURA GRATUITA
            if($dataSales['type_operation'] == '03'){
                $codigo_ex = 12;
            }else {
                $codigo_ex = 10;
            }
        }

        
        
        // VALIDANDO SI LOS PRECIOS ADICIONALES VIENEN VACÍOS
        if ($dataSales['price_tramit'] == NULL) {
            $pr_tram = 0;
        } else {
            $pr_tram = $dataSales['price_tramit'];
        }

        if ($dataSales['price_transport'] == NULL) {
            $pr_tran = 0;
        } else {
            $pr_tran = $dataSales['price_transport'];
        }

        if ($dataSales['price_placa'] == NULL) {
            $pr_plac = 0;
        } else {
            $pr_plac = $dataSales['price_placa'];
        }

        // CAPTURANDO TOTAL INICIAL DE LA VENTA
        $sumandototal = number_format($pr_tram + $pr_tran + $pr_plac, 2, '.', '');
        $calculandoigv = number_format($pr_tram - ($pr_tram / 1.18) + $pr_tran - ($pr_tran / 1.18) + $pr_plac - ($pr_plac / 1.18), 2, '.', '');
        $igv = number_format($calculandoigv, 2, '.', '');
        $detalle = array();

        // PREPARANDO DATOS DE DETALLE EN SALES
        $idmovilesc = $idmoviles;
        $priceMovilesc = $priceMoviles;
        while (true) {
            $idmovil = current($idmoviles);
            $pricemovil = current($priceMoviles);

            $idm = (($idmovil !== false) ? $idmovil : ", &nbsp;");
            $price = (($pricemovil !== false) ? $pricemovil : ", &nbsp;");

            // SUMANDO EL TOTAL DE LA VENTA
            $sumandototal = $sumandototal + $price;

            // CALCULANDO IMPORTES POR ITEM
            $subtotal_item = ($price / 1.18);
            if($dataSales['type_operation'] == '03'){
                $subtotal_item = $price;
            }
            $igv_item = number_format($price - $subtotal_item, 2, '.', '');
            if($dataSales['type_operation'] == '03'){
                $igv_item = number_format($subtotal_item * 0.18, 2, '.', '');
            }
            $igv = $igv + number_format($price - $subtotal_item, 2, '.', '');
            // PREPARANDO DATOS PARA EL DETALLE
            $responseMovil = ModelMovil::mdlShowMoviles('moviles', 'id', $idm);
            $item = array(
                'codigo_producto'           => $responseMovil['id'],
                'marca'                     => $responseMovil['brand'],
                'modelo'                    => $responseMovil['model'],
                'serie_chasis'              => $responseMovil['chasis'],
                'motor'                     => $responseMovil['motor'],
                'color'                     => $responseMovil['colour'],
                'fabricacion'               => $responseMovil['fabricacion'],
                'categoria'                 => $responseMovil['category'],
                'dam'                       => $responseMovil['dam'],
                'total_sin_impuesto'        => $subtotal_item,
                'unitario_sin_impuesto'     => $subtotal_item,
                'unitario_con_impuesto'     => $price,
                'monto_base_igv'            => $subtotal_item,
                'tasa_igv'                  => 18.00,
                'importe_igv'               => $igv_item,
                'total_impuesto'            => $igv_item,
                'exoneracion'               => $codigo_ex
            );

            // VERIFICANDO SI EL LOCAL DE EMISIÓN ES EXONERADO DE IGV PARA CAMBIAR DETALLE
            if ($subsidiary['exonerated'] == 'SI') {
                $item['monto_base_igv'] = $item['unitario_con_impuesto'];
                $item['total_sin_impuesto'] = $item['unitario_con_impuesto'];
                $item['unitario_sin_impuesto'] = $item['unitario_con_impuesto'];
                $item['tasa_igv'] = 0;
                $item['importe_igv'] = 0;
                $item['total_impuesto'] = 0;
                $subtotal = number_format(($sumandototal), 2, '.', '');
            } else {
                $subtotal = number_format(($sumandototal / 1.18), 2, '.', '');
            }

            array_push($detalle, $item);

            $idmovil = next($idmoviles);
            $pricemovil = next($priceMoviles);

            if ($idmovil === false && $pricemovil === false) break;
        }


        // VALIDANDO SI EXISTE CRONOGRAMA DE PAGOS
        if($date_payds != NULL){
            

            $detalleCronograma = array();

            // PREPARANDO DATOS DE DETALLE EN SALES
            $date_paydc = $date_payds;
            $amountc = $amounts;

            while (true) {
                $date_payd = current($date_payds);
                $amount = current($amounts);

                $date = (($date_payd !== false) ? $date_payd : ", &nbsp;");
                $amou = (($amount !== false) ? $amount : ", &nbsp;");

                // PREPARANDO DATOS PARA EL DETALLE
                $item = array(
                    'date_payd' => $date,
                    'amount'    => $amou
                );

                array_push($detalleCronograma, $item);

                $date_payd = next($date_payds);
                $amount = next($amounts);

                if ($date_payd === false && $amount === false) break;
            }
        } else {
            $date_paydc = NULL;
            $amountc = NULL;
            $detalleCronograma = NULL;
        }

        // CONVIRTIENDO EL TOTAL A LETRAS
        $text_price = CantidadEnLetra($sumandototal);
        // CALCULANDO IMPORTES PARA COMPROBANTE

        // CONSIGUIENDO DATOS DEL VENDEDOR
        $data_seller = ModelSeller::mdlShowSeller('sellers', 'id', $dataSales['id_seller']);

        // PREPARANDO DATOS PARA EL COMPROBANTE
        $comprobante =    array(
            'tipodoc'        => $dataSales['type_voucher'], //FACTURA->01 o BOLETA->03
            'serie'            => '' . $inicio_serie . substr(str_repeat(0, 3) . $subsidiary['serie'], -3) . '',
            'correlativo'    => $ultimate_correlative,
            'fecha_emision' => $dataSales['date_sale'],
            'hora'          => $dataSales['hour'],
            'moneda'        => $dataSales['currency'], //PEN->SOLES; USD->DOLARES
            'subtotal'      => $subtotal,
            'montobaseigv'  => $subtotal,
            'igv'           => $igv,
            'tasaigv'       => '18.00',
            'total'         => sprintf('%.2f', $sumandototal),
            'total_texto'   => $text_price,
            'exchange'      => $dataSales['exchange'],
            'vendedor'      => $data_seller['names'],
            'exonerado'     => $subsidiary['exonerated'],
            'tag'           => 'totalValorVentaNetoOpGravadas',
            'codigo_exonerado' => $codigo_ex,
            'gratuita'      => '0',
            'forma_pago' => 0
        );

        $dataSales['total_price'] = $comprobante['total'];
        $dataSales['subtotal_tramit'] = ($pr_tram / 1.18);
        $dataSales['subtotal_transport'] = ($pr_tran / 1.18);
        $dataSales['subtotal_placa'] = ($pr_plac / 1.18);
        $dataSales['importe_igv_tramit'] = ($pr_tram - ($pr_tram / 1.18));
        $dataSales['importe_igv_transport'] = $pr_tran - ($pr_tran / 1.18);
        $dataSales['importe_igv_placa'] = $pr_plac - ($pr_plac / 1.18);

        // VERIFICANDO SI EL LOCAL DE EMISIÓN ES EXONERADO DE IGV
        if ($subsidiary['exonerated'] == 'SI') {
            $comprobante['igv'] = '0.00';
            $comprobante['total'] = $subtotal;
            $comprobante['total'] = $subtotal;
            $text_price = CantidadEnLetra($comprobante['total']);
            $comprobante['total_texto'] = $text_price;
            /* $comprobante['montobaseigv'] = '0.00'; */
            $comprobante['tasaigv'] = '0.00';
            /* $comprobante['codigo_razon_exoneracion'] = '20'; */
            $comprobante['tag'] = 'totalValorVentaNetoOpExoneradas';
            $dataSales['subtotal_tramit'] = $dataSales['price_tramit'];
            $dataSales['subtotal_transport'] = $dataSales['price_transport'];
            $dataSales['subtotal_placa'] = $dataSales['price_placa'];
            $dataSales['importe_igv_tramit'] = 0;
            $dataSales['importe_igv_transport'] = 0;
            $dataSales['importe_igv_placa'] = 0;
            $dataSales['tasaIgv'] = 0;
        } else {
            $comprobante['gratuita'] == $comprobante['subtotal'] * 0.18;
        }

        // VALIDANDO SI ES GRATUITA PARA CAMBIAR EL TAG TOTAL VALOR
        if($dataSales['type_operation'] == '03'){
            $comprobante['subtotal'] = number_format($sumandototal, 2, '.', '');
            $comprobante['tag'] = 'totalValorVentaNetoOpGratuitas';
            $comprobante['total_texto'] = 'SON: CERO Y 00/100 SOLES';
        }

        if($subsidiary['exonerated'] == 'NO'){
            $comprobante['gratuita'] = $comprobante['subtotal'] * 0.18;
        }
        if($dataSales['payment_condition'] != 'Contado'){
            $comprobante['forma_pago'] = 1;
        }

        // ENVIANDO LOS DATOS PREPARADOS AL XML DE FACTURAS Y BOLETAS
        $responseBizlinks = ControllerApiFacturation::prepareXMLFactBol($emisor, $adquiriente, $comprobante, $detalle, $idmovilesc, $priceMovilesc, $dataSales, $detalleCronograma, $date_paydc, $amountc);

        // LÓGICA ADICIONAL PARA DECLARAR LAS BOLETAS
        if ($dataSales['type_voucher'] == '03') {
            $anio = substr($comprobante['fecha_emision'], 0, 4);
            $mes = substr($comprobante['fecha_emision'], 5, 2);
            $dia = substr($comprobante['fecha_emision'], 8, 2);
            $serie_rc = $anio . $mes . $dia;
            // CORRELATIVO DEL RC
            $consult_correlative_rc = ModelFacturation::mdlUltimateCorrelative('invoicing', 'RC', 'serial_number', $serie_rc);

            // LOGICA PARA TOMAR EL ÚLTIMO CORRELATIVO DE LA SERIE
            if ($consult_correlative_rc['correlative'] == '') {
                $ultimate_correlative_rc = '001';
            } else {
                $ultimate_correlative_rc = substr(str_repeat(0, 3) . ($consult_correlative_rc['correlative'] + 1), -3);
            }

            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            $data_rc = array(
                'serie' => $serie_rc,
                'correlative' => $ultimate_correlative_rc,
                'id_invoicing' => '',
                'user_create' => $_SESSION['id_user'],
                'date_create' => $currentDate
            );
            // ENVIANDO LOS DATOS PREPARADOS AL XML DE RESUMEN DE COMPROBANTE
            $response_rc = ControllerApiFacturation::prepareXMLRc($emisor, $adquiriente, $comprobante, $data_rc);
            return $response_rc;
        } else {
            return $responseBizlinks;
        }
    }

    # FUNCION PARA PREPARAR DATOS PARA NOTAS DE CRÉDITO Y DÉBITO
    static public function ctrSendNotas($dataNote, $idmoviles, $priceMoviles, $date_payds, $amounts)
    {
        // CAPTURANDO DATOS DEL USUARIO QUIEN EMITIÓ EL COMPROBANTE
        $palabra = explode(' ', $_SESSION['names_user']);
        $usuario = 'USU-';
        for ($i = 0; $i < count($palabra); $i++) {
            $usuario .= strtoupper(substr($palabra[$i], 0, 1));
        }

        // CAPTURANDO DATOS DEL EMISOR DEL COMPROBANTE
        $data_emisor = ModelFacturation::mdlShowConfiguration('configuration');
        $emisor =     array(
            'tipodoc'        => $data_emisor['tipodoc'],
            'ruc'             => $data_emisor['ruc'],
            'razon_social'    => $data_emisor['razon_social'],
            'email'         => $data_emisor['email_emisor'],
            'nombre_comercial'    => '-',
            'direccion'        => $data_emisor['direccion'],
            'pais'            => 'PE',
            'departamento'  => $data_emisor['departamento'],
            'provincia'        => $data_emisor['provincia'],
            'distrito'        => $data_emisor['distrito'],
            'ubigeo'        => $data_emisor['ubigeo'],
            'urlsoap'       => $data_emisor['url'],
            'usuariosoap'   => $data_emisor['usuario'],
            'passwordsoap'  => $data_emisor['password'],
            'usuario'       => $usuario
        );

        // CONSIGUIENDO DATOS DEL CLIENTE
        $data_customer = ModelCustomers::mdlShowCustomers('customers', 'id', $dataNote['id_customer']);
        $data_ubigeo = ModelSales::mdlShowDistricts('id', $dataNote['id_district'], 'ubigeo_peru_districts');

        $adquiriente = array(
            'tipodoc'                    => $data_customer['cod_sunat'],
            'numero_documento'            => $data_customer['document_number'],
            'razon_social'              => $data_customer['names'],
            'email'                     => $data_customer['email'],
            'direccion'                    => $data_customer['address'],
            'pais'                        => 'PE',
            'departamento'              => $data_ubigeo['department'],
            'provincia'                    => $data_ubigeo['province'],
            'ubigeo'                    => $dataNote['id_district'],
            'distrito'                  => $data_ubigeo['distrito'],
            'condicion_pago'            => $dataNote['payment_condition']
        );

        // PREPARAR PALABRA DE INICIO PARA LA SERIE DEL COMPROBANTE
        if ($dataNote['type_reference'] == '01') {
            $inicio_serie = 'F';
        } else {
            $inicio_serie = 'B';
        }

        // CONSIGUIENDO DATOS DE LA SUCURSAL
        $subsidiary = ModelSubsidiary::mdlShowSubsidiary('subsidiarys', 'id', $dataNote['id_subsidiary']);

        // CONSULTANDO SI EXISTE CORRELATIVO EN LA SERIE PARA LOS SIGNED
        $consult_correlative = ModelFacturation::mdlUltimateCorrelative('invoicing', $dataNote['type_voucher'], 'serial_number', $inicio_serie . substr(str_repeat(0, 3) . $subsidiary['serie'], -3));

        // LOGICA PARA TOMAR EL ÚLTIMO CORRELATIVO DE LA SERIE
        if ($consult_correlative['correlative'] == '') { // NO HAY COMPROBANTES CON LA SERIE
            //CONSULTANDO SI ES NOTA DE CRÉDITO O DÉBITO
            if ($dataNote['type_voucher'] == '07') { // NOTA CRÉDITO
                $nametype = 'nc';
            } else { // NOTA DÉBITO
                $nametype = 'nd';
            }

            //CONSULTANDO SI LA NOTA ES PARA FACTURA O BOLETA
            if ($inicio_serie == 'F') { // PARA FACTURA
                $ultimate_correlative = $subsidiary['correlative_' . $nametype . ''];
            } else { // PARA BOLETA
                $ultimate_correlative = $subsidiary['correlative_' . $nametype . '_b'];
            }
        } else { // SI HAY COMPROBANTES CON LA SERIE
            // VERIFICANDO SI EL CORRELATIVO TIENE ERROR
            if($consult_correlative['status_response'] == 'ERROR'){
                $ultimate_correlative = substr(str_repeat(0, 8) . $consult_correlative['correlative'], -8);
            }else {
                $ultimate_correlative = substr(str_repeat(0, 8) . ($consult_correlative['correlative'] + 1), -8);    
            }
        }

        // <---------- RECORRIENDO EL DETALLE DE VENTAS ------------>

        // VERIFICANDO SI EL LOCAL DE EMISIÓN ES EXONERADO DE IGV
        if ($subsidiary['exonerated'] == 'SI') {
            // VERIFICANDO SI ES FACTURA GRATUITA
            if($dataNote['type_operation'] == '03'){
                $codigo_ex = 21;
            }else {
                $codigo_ex = 20;
            }
        }else {
            // VERIFICANDO SI ES FACTURA GRATUITA
            if($dataNote['type_operation'] == '03'){
                $codigo_ex = 12;
            }else {
                $codigo_ex = 10;
            }
        }

        
        
        // VALIDANDO SI LOS PRECIOS ADICIONALES VIENEN VACÍOS
        if ($dataNote['price_tramit'] == NULL) {
            $pr_tram = 0;
        } else {
            $pr_tram = $dataNote['price_tramit'];
        }

        if ($dataNote['price_transport'] == NULL) {
            $pr_tran = 0;
        } else {
            $pr_tran = $dataNote['price_transport'];
        }

        if ($dataNote['price_placa'] == NULL) {
            $pr_plac = 0;
        } else {
            $pr_plac = $dataNote['price_placa'];
        }

        // CAPTURANDO TOTAL INICIAL DE LA NOTA
        $sumandototal = number_format($pr_tram + $pr_tran + $pr_plac, 2, '.', '');
        $calculandoigv = number_format($pr_tram - ($pr_tram / 1.18) + $pr_tran - ($pr_tran / 1.18) + $pr_plac - ($pr_plac / 1.18), 2, '.', '');
        $igv = number_format($calculandoigv, 2, '.', '');
        $detalle = array();

        // PREPARANDO DATOS DE DETALLE EN NOTAS
        $idmovilesc = $idmoviles;
        $priceMovilesc = $priceMoviles;
        while (true) {
            $idmovil = current($idmoviles);
            $pricemovil = current($priceMoviles);

            $idm = (($idmovil !== false) ? $idmovil : ", &nbsp;");
            $price = (($pricemovil !== false) ? $pricemovil : ", &nbsp;");

            // SUMANDO EL TOTAL DE LA NOTA
            $sumandototal = $sumandototal + $price;

            // CALCULANDO IMPORTES POR ITEM
            $subtotal_item = ($price / 1.18);
            if($dataNote['type_operation'] == '03'){
                $subtotal_item = $price;
            }
            $igv_item = number_format($price - $subtotal_item, 2, '.', '');
            if($dataNote['type_operation'] == '03'){
                $igv_item = number_format($subtotal_item * 0.18, 2, '.', '');
            }
            $igv = $igv + number_format($price - $subtotal_item, 2, '.', '');
            // PREPARANDO DATOS PARA EL DETALLE
            $responseMovil = ModelMovil::mdlShowMoviles('moviles', 'id', $idm);
            $item = array(
                'codigo_producto'           => $responseMovil['id'],
                'marca'                     => $responseMovil['brand'],
                'modelo'                    => $responseMovil['model'],
                'serie_chasis'              => $responseMovil['chasis'],
                'motor'                     => $responseMovil['motor'],
                'color'                     => $responseMovil['colour'],
                'fabricacion'               => $responseMovil['fabricacion'],
                'categoria'                 => $responseMovil['category'],
                'dam'                       => $responseMovil['dam'],
                'total_sin_impuesto'        => $subtotal_item,
                'unitario_sin_impuesto'     => $subtotal_item,
                'unitario_con_impuesto'     => $price,
                'monto_base_igv'            => $subtotal_item,
                'tasa_igv'                  => 18.00,
                'importe_igv'               => $igv_item,
                'total_impuesto'            => $igv_item,
                'exoneracion'               => $codigo_ex
            );

            // VERIFICANDO SI EL LOCAL DE EMISIÓN ES EXONERADO DE IGV PARA CAMBIAR DETALLE
            if ($subsidiary['exonerated'] == 'SI') {
                $item['monto_base_igv'] = $item['unitario_con_impuesto'];
                $item['total_sin_impuesto'] = $item['unitario_con_impuesto'];
                $item['unitario_sin_impuesto'] = $item['unitario_con_impuesto'];
                $item['tasa_igv'] = 0;
                $item['importe_igv'] = 0;
                $item['total_impuesto'] = 0;
                $subtotal = number_format(($sumandototal), 2, '.', '');
            } else {
                $subtotal = number_format(($sumandototal / 1.18), 2, '.', '');
            }

            array_push($detalle, $item);

            $idmovil = next($idmoviles);
            $pricemovil = next($priceMoviles);

            if ($idmovil === false && $pricemovil === false) break;
        }


        // VALIDANDO SI EXISTE CRONOGRAMA DE PAGOS
        if($date_payds != NULL){

            $detalleCronograma = array();

            // PREPARANDO DATOS DE DETALLE EN NOTAS
            $date_paydc = $date_payds;
            $amountc = $amounts;

            while (true) {
                $date_payd = current($date_payds);
                $amount = current($amounts);

                $date = (($date_payd !== false) ? $date_payd : ", &nbsp;");
                $amou = (($amount !== false) ? $amount : ", &nbsp;");

                // PREPARANDO DATOS PARA EL DETALLE
                $item = array(
                    'date_payd' => $date,
                    'amount'    => $amou
                );

                array_push($detalleCronograma, $item);

                $date_payd = next($date_payds);
                $amount = next($amounts);

                if ($date_payd === false && $amount === false) break;
            }
        } else {
            $date_paydc = NULL;
            $amountc = NULL;
            $detalleCronograma = NULL;
        }

        // CONVIRTIENDO EL TOTAL A LETRAS
        $text_price = CantidadEnLetra($sumandototal);

        // CONSIGUIENDO DATOS DEL VENDEDOR
        $data_seller = ModelSeller::mdlShowSeller('sellers', 'id', $dataNote['id_seller']);

        //VERIFICANDO SI ES NOTA DE CRÉDITO O DÉBITO
        if ($dataNote['type_voucher'] == '07') {
            // MOTIVO DE AFECTO NOTA DE CREDITO
            if ($dataNote['motive'] == '01') {
                $mensaje_motivo = 'Anulación de la operación';
            } else if ($dataNote['motive'] == '02') {
                $mensaje_motivo = 'Anulación por error en el RUC';
            } else if ($dataNote['motive'] == '03') {
                $mensaje_motivo = 'Corrección por error en la descripción';
            } else if ($dataNote['motive'] == '04') {
                $mensaje_motivo = 'Descuento global';
            } else if ($dataNote['motive'] == '05') {
                $mensaje_motivo = 'Descuento por item';
            } else if ($dataNote['motive'] == '06') {
                $mensaje_motivo = 'Devolución total';
            } else if ($dataNote['motive'] == '07') {
                $mensaje_motivo = 'Devolución por item';
            } else if ($dataNote['motive'] == '08') {
                $mensaje_motivo = 'Bonificación';
            } else if ($dataNote['motive'] == '09') {
                $mensaje_motivo = 'Disminución en el valor';
            } else if ($dataNote['motive'] == '10') {
                $mensaje_motivo = 'Otros conceptos';
            } else if ($dataNote['motive'] == '11') {
                $mensaje_motivo = 'Ajustes de operaciones de exportación';
            } else if ($dataNote['motive'] == '12') {
                $mensaje_motivo = 'Ajustes afectos al IVAP';
            }
        } else {
            // MOTIVO DE AFECTO NOTA DE DEBITO
            if ($dataNote['motive'] == '01') {
                $mensaje_motivo = 'Interes por mora';
            } else if ($dataNote['motive'] == '02') {
                $mensaje_motivo = 'Aumento en el valor';
            } else if ($dataNote['motive'] == '03') {
                $mensaje_motivo = 'Penalidades/ otros conceptos';
            } else if ($dataNote['motive'] == '11') {
                $mensaje_motivo = 'Ajustes de operaciones de exportación';
            } else if ($dataNote['motive'] == '12') {
                $mensaje_motivo = 'Ajustes afectos al IVAP';
            }
        }

        // ASIGNANDO MENSAJE
        $dataNote['msj_motive'] = $mensaje_motivo;

        // PREPARANDO DATOS PARA EL COMPROBANTE
        $comprobante =    array(
            'tipodoc'        => $dataNote['type_voucher'], //FACTURA->01 o BOLETA->03
            'serie'            => '' . $inicio_serie . substr(str_repeat(0, 3) . $subsidiary['serie'], -3) . '',
            'correlativo'    => $ultimate_correlative,
            'fecha_emision' => $dataNote['date_sale'],
            'hora'          => $dataNote['hour'],
            'moneda'        => $dataNote['currency'], //PEN->SOLES; USD->DOLARES
            'subtotal'      => $subtotal,
            'montobaseigv'  => $subtotal,
            'igv'           => $igv,
            'tasaigv'       => '18.00',
            'total'         => sprintf('%.2f', $sumandototal),
            'total_texto'   => $text_price,
            'exchange'      => $dataNote['exchange'],
            'vendedor'      => $data_seller['names'],
            'exonerado'     => $subsidiary['exonerated'],
            'tag'           => 'totalValorVentaNetoOpGravadas',
            'codigo_exonerado' => $codigo_ex,
            'type_reference' => $dataNote['type_reference'],
            'reference' => $dataNote['reference'],
            'motive_code' => $dataNote['motive'],
            'motive' => $mensaje_motivo,
            'gratuita'      => '0',
            'forma_pago' => 0
        );

        $dataNote['total_price'] = $comprobante['total'];
        $dataNote['subtotal_tramit'] = ($pr_tram / 1.18);
        $dataNote['subtotal_transport'] = ($pr_tran / 1.18);
        $dataNote['subtotal_placa'] = ($pr_plac / 1.18);
        $dataNote['importe_igv_tramit'] = ($pr_tram - ($pr_tram / 1.18));
        $dataNote['importe_igv_transport'] = $pr_tran - ($pr_tran / 1.18);
        $dataNote['importe_igv_placa'] = $pr_plac - ($pr_plac / 1.18);

        // VERIFICANDO SI EL LOCAL DE EMISIÓN ES EXONERADO DE IGV
        if ($subsidiary['exonerated'] == 'SI') {
            $comprobante['igv'] = '0.00';
            $comprobante['total'] = $subtotal;
            $comprobante['total'] = $subtotal;
            $text_price = CantidadEnLetra($comprobante['total']);
            $comprobante['total_texto'] = $text_price;
            /* $comprobante['montobaseigv'] = '0.00'; */
            $comprobante['tasaigv'] = '0.00';
            /* $comprobante['codigo_razon_exoneracion'] = '20'; */
            $comprobante['tag'] = 'totalValorVentaNetoOpExoneradas';
            $dataNote['subtotal_tramit'] = $dataNote['price_tramit'];
            $dataNote['subtotal_transport'] = $dataNote['price_transport'];
            $dataNote['subtotal_placa'] = $dataNote['price_placa'];
            $dataNote['importe_igv_tramit'] = 0;
            $dataNote['importe_igv_transport'] = 0;
            $dataNote['importe_igv_placa'] = 0;
            $dataNote['tasaIgv'] = 0;
        } else {
            $comprobante['gratuita'] == $comprobante['subtotal'] * 0.18;
        }

        // VALIDANDO SI ES GRATUITA PARA CAMBIAR EL TAG TOTAL VALOR
        if($dataNote['type_operation'] == '03'){
            $comprobante['subtotal'] = number_format($sumandototal, 2, '.', '');
            $comprobante['tag'] = 'totalValorVentaNetoOpGratuitas';
            $comprobante['total_texto'] = 'SON: CERO Y 00/100 SOLES';
        }

        if($subsidiary['exonerated'] == 'NO'){
            $comprobante['gratuita'] = $comprobante['subtotal'] * 0.18;
        }
        if($dataNote['payment_condition'] != 'Contado'){
            $comprobante['forma_pago'] = 1;
        }

        // ENVIANDO LOS DATOS PREPARADOS AL XML DE FACTURAS Y BOLETAS
        $responseBizlinks = ControllerApiFacturation::prepareXMLNotas($emisor, $adquiriente, $comprobante, $detalle, $idmovilesc, $priceMovilesc, $dataNote, $detalleCronograma, $date_paydc, $amountc);

        // LÓGICA ADICIONAL PARA DECLARAR LAS NOTAS REFERENNTES A BOLETAS
        if ($inicio_serie == 'B') {
            $anio = substr($comprobante['fecha_emision'], 0, 4);
            $mes = substr($comprobante['fecha_emision'], 5, 2);
            $dia = substr($comprobante['fecha_emision'], 8, 2);
            $serie_rc = $anio . $mes . $dia;
            // CORRELATIVO DEL RC
            $consult_correlative_rc = ModelFacturation::mdlUltimateCorrelative('invoicing', 'RC', 'serial_number', $serie_rc);

            // LOGICA PARA TOMAR EL ÚLTIMO CORRELATIVO DE LA SERIE
            if ($consult_correlative_rc['correlative'] == '') {
                $ultimate_correlative_rc = '001';
            } else {
                $ultimate_correlative_rc = substr(str_repeat(0, 3) . ($consult_correlative_rc['correlative'] + 1), -3);
            }

            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            $data_rc = array(
                'serie' => $serie_rc,
                'correlative' => $ultimate_correlative_rc,
                'id_invoicing' => '',
                'user_create' => $_SESSION['id_user'],
                'date_create' => $currentDate
            );
            // ENVIANDO LOS DATOS PREPARADOS AL XML DE RESUMEN DE COMPROBANTE
            $response_rc = ControllerApiFacturation::prepareXMLRc($emisor, $adquiriente, $comprobante, $data_rc);
            return $response_rc;
        } else {
            return $responseBizlinks;
        }
    }

    # FUNCION PARA PREPARAR DATOS PARA GUIAS DE REMISION
    static public function ctrSendGuias($dataGuia, $idmoviles)
    {
        $data_emisor = ModelFacturation::mdlShowConfiguration('configuration');

        // DATOS DEL EMISOR
        $emisor =     array(
            'tipodoc'        => $data_emisor['tipodoc'],
            'ruc'             => $data_emisor['ruc'],
            'razon_social'    => $data_emisor['razon_social'],
            'email'         => $data_emisor['email_emisor'],
            'urlsoap'           => $data_emisor['url'],
            'usuariosoap'       => $data_emisor['usuario'],
            'passwordsoap'      => $data_emisor['password']
        );

        // DATOS DEL CLIENTE
        $data_customer = ModelCustomers::mdlShowCustomers('customers', 'id', $dataGuia['id_customer']);


        $adquiriente = array(
            'tipodoc'           => $data_customer['cod_sunat'],
            'numero_documento'  => $data_customer['document_number'],
            'razon_social'      => $data_customer['names'],
            'email'             => $data_customer['email']
        );

        // ASIGNANDO INICIO DE SERIA PARA GUIAS
        $inicio_serie = 'T';

        // CONSIGUIENDO DATOS DE LA SUCURSAL
        $subsidiary = ModelSubsidiary::mdlShowSubsidiary('subsidiarys', 'id', $dataGuia['id_subsidiary']);

        // CONSULTANDO SI EXISTE CORRELATIVO EN LA SERIE
        $consult_correlative = ModelFacturation::mdlUltimateCorrelative('invoicing', '09', 'serial_number', $inicio_serie . substr(str_repeat(0, 3) . $dataGuia['serie_subsidiary'], -3));



        if ($consult_correlative['correlative'] == '') {
            $ultimate_correlative = $subsidiary['correlative_g'];
        } else {
            $ultimate_correlative = substr(str_repeat(0, 8) . ($consult_correlative['correlative'] + 1), -8);
        }

        // MOTIVO DE AFECTO
        if ($dataGuia['transfer_reason'] == '01') {
            $mensaje_motivo = 'Venta';
        } else if ($dataGuia['transfer_reason'] == '02') {
            $mensaje_motivo = 'Compra';
        } else if ($dataGuia['transfer_reason'] == '04') {
            $mensaje_motivo = 'Traslado entre establecimientos de la misma empresa';
        } else if ($dataGuia['transfer_reason'] == '08') {
            $mensaje_motivo = 'Importación';
        } else if ($dataGuia['transfer_reason'] == '09') {
            $mensaje_motivo = 'Exportación';
        } else if ($dataGuia['transfer_reason'] == '13') {
            $mensaje_motivo = 'Otros';
        } else if ($dataGuia['transfer_reason'] == '14') {
            $mensaje_motivo = 'Venta sujeta a confirmación del comprador';
        } else if ($dataGuia['transfer_reason'] == '18') {
            $mensaje_motivo = 'Traslado emisor itinerante CP';
        } else if ($dataGuia['transfer_reason'] == '19') {
            $mensaje_motivo = 'Traslado a zona primaria';
        }

        // ASIGNANDO MENSAJE A ARRAY DE GUÍAS
        $dataGuia['reason_message'] = $mensaje_motivo;

        // ARMANDO DATOS DEL COMPROBANTE
        $comprobante =    array(
            'tipodoc'            => '09', // GUIA DE REMISION
            'serie'            => '' . $inicio_serie . substr(str_repeat(0, 3) . $dataGuia['serie_subsidiary'], -3) . '',
            'correlativo'    => $ultimate_correlative,
            'fecha_emision' => $dataGuia['broadcast_date'],
            'fechaInicio_traslado' => $dataGuia['transfer_start_date'],
            'hora'  => $dataGuia['hour'],
            'observaciones' => '',
            'numeroDocumento_relacionado' => $dataGuia['voucher_affected'],
            'tipo_comprobante_afecto' => $dataGuia['type_voucher_affected'],
            'motivo_traslado' => $dataGuia['transfer_reason'],
            'mensaje_motivo' => $mensaje_motivo,
            'peso'          => $dataGuia['weight'],
            'modalidad_traslado' => $dataGuia['transfer_mode'],
            'numeroPlaca_vehiculo' => $dataGuia['plate_number'],
            'numeroDocumento_conductor' => $dataGuia['document_number_driver'],
            'tipoDocumento_conductor' => $dataGuia['document_type_driver'],
            'ubigeo_partida' => $dataGuia['ubigeo_entry'],
            'direccion_partida' => $dataGuia['direction_entry'],
            'ubigeo_llegada' => $dataGuia['ubigeo_arrival'],
            'direccion_llegada' => $dataGuia['direction_arrival']
        );

        // PREPARANDO DATOS DE DETALLE EN GUIAS
        $detalle = array();
        $idmovilesc = $idmoviles;
        while (true) {
            $idmovil = current($idmoviles);

            $idm = (($idmovil !== false) ? $idmovil : ", &nbsp;");

            // PREPARANDO DATOS PARA EL DETALLE
            $responseMovil = ModelMovil::mdlShowMoviles('moviles', 'id', $idm);
            $item = array(
                'id_movil'           => $responseMovil['id'],
                'marca'              => $responseMovil['brand'],
                'modelo'             => $responseMovil['model'],
                'serie_chasis'       => $responseMovil['chasis'],
                'motor'              => $responseMovil['motor'],
                'color'              => $responseMovil['colour'],
                'fabricacion'        => $responseMovil['fabricacion'],
                'categoria'          => $responseMovil['category'],
                'dam'                => $responseMovil['dam']
            );

            array_push($detalle, $item);

            $idmovil = next($idmoviles);

            if ($idmovil === false) break;
        }

        // LLAMANDO A PREPARAR EL XML GUIA
        $responseBizlinks = ControllerApiFacturation::prepareXMLGuias($emisor, $adquiriente, $comprobante, $detalle, $idmovilesc, $dataGuia);

        return $responseBizlinks;
    }

    # FUNCION PARA ENVIAR EL XML EN LA FACTURA Y BOLETA WS
    static public function prepareXMLFactBol($emisor, $adquiriente, $comprobante, $detalle, $idmoviles, $priceMoviles, $dataSales, $detalleCronograma, $date_payds, $amounts)
    {
        $soapUrl = $emisor['urlsoap'];
        $soapUsuario = $emisor['usuariosoap'];
        $soapPassword = $emisor['passwordsoap'];
        $soapMensaje = '<![CDATA[
        <SignOnLineCmd declare-sunat="1" declare-direct-sunat="1" publish="1" output="PDF">
            <parameter value="' . $emisor['ruc'] . '" name="idEmisor"/>
            <parameter value="' . $comprobante['tipodoc'] . '" name="tipoDocumento"/>
            <documento>
                <correoEmisor>' . $emisor['email'] . '</correoEmisor>
                <correoAdquiriente>' . $adquiriente['email'] . '</correoAdquiriente>
                <numeroDocumentoEmisor>' . $emisor['ruc'] . '</numeroDocumentoEmisor>
                <tipoDocumentoEmisor>' . $emisor['tipodoc'] . '</tipoDocumentoEmisor>
                <tipoDocumento>' . $comprobante['tipodoc'] . '</tipoDocumento>
                <razonSocialEmisor>' . $emisor['razon_social'] . '</razonSocialEmisor>
                <nombreComercialEmisor>-</nombreComercialEmisor>
                <serieNumero>' . $comprobante['serie'] . '-' . $comprobante['correlativo'] . '</serieNumero>
                <fechaEmision>' . $comprobante['fecha_emision'] . '</fechaEmision>
                <ubigeoEmisor>' . $emisor['ubigeo'] . '</ubigeoEmisor>
                <direccionEmisor>' . $emisor['direccion'] . '</direccionEmisor>
                <urbanizacion>-</urbanizacion>
                <provinciaEmisor>' . $emisor['provincia'] . '</provinciaEmisor>
                <departamentoEmisor>' . $emisor['departamento'] . '</departamentoEmisor>
                <distritoEmisor>' . $emisor['distrito'] . '</distritoEmisor>
                <paisEmisor>PE</paisEmisor>
                <numeroDocumentoAdquiriente>' . $adquiriente['numero_documento'] . '</numeroDocumentoAdquiriente>
                <tipoDocumentoAdquiriente>' . $adquiriente['tipodoc'] . '</tipoDocumentoAdquiriente>
                <razonSocialAdquiriente>' . $adquiriente['razon_social'] . '</razonSocialAdquiriente>
                <tipoMoneda>' . $comprobante['moneda'] . '</tipoMoneda>
                <' . $comprobante['tag'] . '>' . number_format($comprobante['subtotal'],2, '.', '') . '</' . $comprobante['tag'] . '>';
                if($dataSales['type_operation'] == '03'){
                    $soapMensaje .= '
                <totalValorVenta>0.00</totalValorVenta>
			    <totalPrecioVenta>0.00</totalPrecioVenta>
                <totalIgv>0.00</totalIgv>
                <totalImpuestos>0.00</totalImpuestos>
                <totalVenta>0.00</totalVenta>';
                } else {
                    $soapMensaje .= '
                <totalValorVenta>' . number_format($comprobante['subtotal'],2, '.', '') . '</totalValorVenta>
			    <totalPrecioVenta>' . number_format($comprobante['total'],2, '.', '') . '</totalPrecioVenta>
                <totalIgv>' . number_format($comprobante['igv'],2, '.', '') . '</totalIgv>
                <totalImpuestos>' . number_format($comprobante['igv'], 2, '.', '') . '</totalImpuestos>
                <totalVenta>' . number_format($comprobante['total'],2, '.', '') . '</totalVenta>';
                }
                $soapMensaje .= '
                <codigoLeyenda_1>1000</codigoLeyenda_1>
                <textoLeyenda_1>' . $comprobante['total_texto'] . '</textoLeyenda_1>
                <codigoAuxiliar40_1>9011</codigoAuxiliar40_1>
                <textoAuxiliar40_1>18%</textoAuxiliar40_1>
                <codigoAuxiliar100_1>9435</codigoAuxiliar100_1>
                <textoAuxiliar100_1>' . $emisor['usuario'] . '</textoAuxiliar100_1>
                <codigoAuxiliar100_2>9157</codigoAuxiliar100_2>
                <textoAuxiliar100_2>' . $adquiriente['condicion_pago'] . '</textoAuxiliar100_2>
                <codigoAuxiliar100_3>9351</codigoAuxiliar100_3>
                <textoAuxiliar100_3>' . $comprobante['exchange'] . '</textoAuxiliar100_3>
                <codigoAuxiliar100_4>9218</codigoAuxiliar100_4>
                <textoAuxiliar100_4>' . $comprobante['vendedor'] . '</textoAuxiliar100_4>
                <tipoOperacion>0101</tipoOperacion>
                <horaEmision>' . $comprobante['hora'] . '</horaEmision>
                <codigoLocalAnexoEmisor>0000</codigoLocalAnexoEmisor>
                <direccionAdquiriente>' . $adquiriente['direccion'] . '</direccionAdquiriente>
                <ubigeoAdquiriente>' . $adquiriente['ubigeo'] . '</ubigeoAdquiriente>
                <urbanizacionAdquiriente>-</urbanizacionAdquiriente>
                <provinciaAdquiriente>' . $adquiriente['provincia'] . '</provinciaAdquiriente>
                <departamentoAdquiriente>' . $adquiriente['departamento'] . '</departamentoAdquiriente>
                <distritoAdquiriente>' . $adquiriente['distrito'] . '</distritoAdquiriente>
                <formaPagoNegociable>' . $comprobante['forma_pago'] . '</formaPagoNegociable>';
                if($comprobante['forma_pago'] == 1){                    
                    $soapMensaje .= '<montoNetoPendiente>' . number_format($comprobante['total'],2, '.', '') . '</montoNetoPendiente>';
                    foreach ($detalleCronograma as $key => $value) {
                        $soapMensaje .= '
                        <montoPagoCuota'.($key+1).'>'. number_format($value['amount'],2, '.', '') .'</montoPagoCuota'.($key+1).'>
                        <fechaPagoCuota'.($key+1).'>'. $value['date_payd'] .'</fechaPagoCuota'.($key+1).'>';
                    }
                }
                $soapMensaje .= '<paisAdquiriente>PE</paisAdquiriente>';
                if($dataSales['type_operation'] == '03'){
                    $soapMensaje .= '
                <totalTributosOpeGratuitas>'.number_format($comprobante['gratuita'],2, '.', '').'</totalTributosOpeGratuitas>';
                }
        foreach ($detalle as $key => $value) {
            $soapMensaje .= '
                    <item>
                        <numeroOrdenItem>' . ($key + 1) . '</numeroOrdenItem>
                        <codigoProducto>' . $value['codigo_producto'] . '</codigoProducto>
                        <codigoProductoSUNAT>25100000</codigoProductoSUNAT>
                        <codigoAuxiliar100_5>9037</codigoAuxiliar100_5>
                        <textoAuxiliar100_5>' . $value['marca'] . '</textoAuxiliar100_5>
                        <codigoAuxiliar100_6>9038</codigoAuxiliar100_6>
                        <textoAuxiliar100_6>' . $value['modelo'] . '</textoAuxiliar100_6>
                        <codigoAuxiliar100_7>9052</codigoAuxiliar100_7>
                        <textoAuxiliar100_7>' . $value['serie_chasis'] . '</textoAuxiliar100_7>
                        <codigoAuxiliar100_8>9047</codigoAuxiliar100_8>
                        <textoAuxiliar100_8>' . $value['motor'] . '</textoAuxiliar100_8>
                        <codigoAuxiliar100_9>9041</codigoAuxiliar100_9>
                        <textoAuxiliar100_9>' . $value['color'] . '</textoAuxiliar100_9>
                        <codigoAuxiliar100_10>9042</codigoAuxiliar100_10>
                        <textoAuxiliar100_10>' . $value['fabricacion'] . '</textoAuxiliar100_10>
                        <codigoAuxiliar250_1>9991</codigoAuxiliar250_1>
                        <textoAuxiliar250_1>' . $value['dam'] . '</textoAuxiliar250_1>
                        <descripcion>' . $value['categoria'] . '</descripcion>
                        <cantidad>1.00</cantidad>
                        <unidadMedida>NIU</unidadMedida>
                        <importeTotalSinImpuesto>' . number_format($value['total_sin_impuesto'],2, '.', '') . '</importeTotalSinImpuesto>';
                        if($dataSales['type_operation'] == '03'){
                            $soapMensaje .= '
                        <importeUnitarioSinImpuesto>0.00</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>0.00</importeUnitarioConImpuesto>';
                        }else {
                            $soapMensaje .= '
                        <importeUnitarioSinImpuesto>' . number_format($value['unitario_sin_impuesto'],2, '.', '') . '</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>' . number_format($value['unitario_con_impuesto'],2, '.', '') . '</importeUnitarioConImpuesto>';
                        }
                        $soapMensaje .= '
                        <codigoImporteUnitarioConImpuesto>01</codigoImporteUnitarioConImpuesto>
                        <montoBaseIgv>' . number_format($value['monto_base_igv'],2, '.', '') . '</montoBaseIgv>
                        <tasaIgv>' . number_format($value['tasa_igv'],2, '.', '') . '</tasaIgv>
                        <importeIgv>' . number_format($value['importe_igv'],2, '.', '') . '</importeIgv>
                        <importeTotalImpuestos>' . number_format($value['total_impuesto'],2, '.', '') . '</importeTotalImpuestos>
                        <codigoRazonExoneracion>' . $value['exoneracion'] . '</codigoRazonExoneracion>';
                        if($dataSales['type_operation'] == '03'){
                            $soapMensaje .= '
                        <codigoImporteReferencial>02</codigoImporteReferencial>
                        <importeReferencial>'.number_format($value['total_sin_impuesto'],2, '.', '').'</importeReferencial>';
                        }
                        $soapMensaje .= '
                    </item>';
        }
        $key = ($key + 1);
        if ($dataSales['price_tramit'] != NULL) {
            $key = ($key + 1);
            $soapMensaje .= '
                    <item>
                        <numeroOrdenItem>' . $key . '</numeroOrdenItem>
                        <codigoProducto>TRAT</codigoProducto>
                        <codigoProductoSUNAT>25100000</codigoProductoSUNAT>
                        <descripcion>Precio por tramites</descripcion>
                        <cantidad>1.00</cantidad>
                        <unidadMedida>NIU</unidadMedida>
                        <importeTotalSinImpuesto>' . number_format($dataSales['subtotal_tramit'], 2, '.', '') . '</importeTotalSinImpuesto>
                        <importeUnitarioSinImpuesto>' . number_format($dataSales['subtotal_tramit'], 2, '.', '') . '</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>' . number_format($dataSales['price_tramit'], 2, '.', '') . '</importeUnitarioConImpuesto>
                        <codigoImporteUnitarioConImpuesto>01</codigoImporteUnitarioConImpuesto>
                        <montoBaseIgv>' . number_format($dataSales['subtotal_tramit'], 2, '.', '') . '</montoBaseIgv>
                        <tasaIgv>' . $dataSales['tasaIgv'] . '</tasaIgv>
                        <importeIgv>' . number_format($dataSales['importe_igv_tramit'], 2, '.', '') . '</importeIgv>
                        <importeTotalImpuestos>' . number_format($dataSales['importe_igv_tramit'], 2, '.', '') . '</importeTotalImpuestos>
                        <codigoRazonExoneracion>' . $comprobante['codigo_exonerado'] . '</codigoRazonExoneracion>
                    </item>';
        }

        if ($dataSales['price_transport'] != NULL) {
            $key = ($key + 1);
            $soapMensaje .= '
                    <item>
                        <numeroOrdenItem>' . $key . '</numeroOrdenItem>
                        <codigoProducto>TRANS</codigoProducto>
                        <codigoProductoSUNAT>25100000</codigoProductoSUNAT>
                        <descripcion>Precio por transporte</descripcion>
                        <cantidad>1.00</cantidad>
                        <unidadMedida>NIU</unidadMedida>
                        <importeTotalSinImpuesto>' . number_format($dataSales['subtotal_transport'], 2, '.', '') . '</importeTotalSinImpuesto>
                        <importeUnitarioSinImpuesto>' . number_format($dataSales['subtotal_transport'], 2, '.', '') . '</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>' . number_format($dataSales['price_transport'], 2, '.', '') . '</importeUnitarioConImpuesto>
                        <codigoImporteUnitarioConImpuesto>01</codigoImporteUnitarioConImpuesto>
                        <montoBaseIgv>' . number_format($dataSales['subtotal_transport'], 2, '.', '') . '</montoBaseIgv>
                        <tasaIgv>' . $dataSales['tasaIgv'] . '</tasaIgv>
                        <importeIgv>' . number_format($dataSales['importe_igv_transport'], 2, '.', '') . '</importeIgv>
                        <importeTotalImpuestos>' . number_format($dataSales['importe_igv_transport'], 2, '.', '') . '</importeTotalImpuestos>
                        <codigoRazonExoneracion>' . $comprobante['codigo_exonerado'] . '</codigoRazonExoneracion>
                    </item>';
        }

        if ($dataSales['price_transport'] != NULL) {
            $key = ($key + 1);
            $soapMensaje .= '
                    <item>
                        <numeroOrdenItem>' . $key . '</numeroOrdenItem>
                        <codigoProducto>PLACA</codigoProducto>
                        <codigoProductoSUNAT>25100000</codigoProductoSUNAT>
                        <descripcion>Precio por placa</descripcion>
                        <cantidad>1.00</cantidad>
                        <unidadMedida>NIU</unidadMedida>
                        <importeTotalSinImpuesto>' . number_format($dataSales['subtotal_placa'], 2, '.', '') . '</importeTotalSinImpuesto>
                        <importeUnitarioSinImpuesto>' . number_format($dataSales['subtotal_placa'], 2, '.', '') . '</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>' . number_format($dataSales['price_placa'], 2, '.', '') . '</importeUnitarioConImpuesto>
                        <codigoImporteUnitarioConImpuesto>01</codigoImporteUnitarioConImpuesto>
                        <montoBaseIgv>' . number_format($dataSales['subtotal_placa'], 2, '.', '') . '</montoBaseIgv>
                        <tasaIgv>' . $dataSales['tasaIgv'] . '</tasaIgv>
                        <importeIgv>' . number_format($dataSales['importe_igv_placa'], 2, '.', '') . '</importeIgv>
                        <importeTotalImpuestos>' . number_format($dataSales['importe_igv_placa'], 2, '.', '') . '</importeTotalImpuestos>
                        <codigoRazonExoneracion>' . $comprobante['codigo_exonerado'] . '</codigoRazonExoneracion>
                    </item>';
        }
        $soapMensaje .= '
            </documento>
        </SignOnLineCmd>]]>';

        // XML DEL MENSAJE SOAP  
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.ce.ebiz.com/">
        <soapenv:Header/>
          <soapenv:Body>
            <ws:invoke> 
              <command>' . $soapMensaje . '</command> 
            </ws:invoke>
          </soapenv:Body>
        </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "D:/ebiz/app/pse-php/bizlinkzClient/bizlinks-com-pe.crt");
        curl_setopt($ch, CURLOPT_URL, $soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $soapUsuario . ":" . $soapPassword);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpcode == 200) { // COMUNICACION CORRECTA

            // PREPARAR INFORMACIÓN PARA INVOICING
            $data_invoicing = array(
                'document_type'   => $comprobante['tipodoc'],
                'serial_number'   => $comprobante['serie'],
                'correlative'     => $comprobante['correlativo'],
                'status_response' => '',
                'status_document' => '',
                'pdf_file'        => '',
                'xml'        => '',
                'message_response' => '',
                'request_xml'     => $soapMensaje,
                'response_xml'    => html_entity_decode($response),
                'user_create'     => $_SESSION['id_user'],
                'date_create'     => $dataSales['date_create']
            );

            if (empty($response)) {
                $rpt = 'vacio';
            } else {
                // RECORRIENDO RESPUESTA PARA SACAR LOS DATOS
                $xmlSoap = simplexml_load_string($response);
                $xmlEbiz = simplexml_load_string(
                    (string)$xmlSoap->children('soapenv', true)->Body
                        ->children('ns2', true)->invokeResponse
                        ->children('', true)->return
                );

                //COMPROBANDO SI LA RESPUESTA DE LA WS FUE CORRECTA O INCORRECTA
                if (isset($xmlEbiz->genericInvokeResponse->xmlResult->document->statusSunat)) { // SI HAY RESPUESTA DE SUNAT
                    $statusResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->status;
                    $statusSunat = $xmlEbiz->genericInvokeResponse->xmlResult->document->statusSunat;
                    $pdffile = $xmlEbiz->genericInvokeResponse->xmlResult->document->pdfFileUrl;
                    $xml = $xmlEbiz->genericInvokeResponse->xmlResult->document->xmlFileSignUrl;
                    if($statusSunat == 'AC_03'){
                        $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messageSunat;
                        $rpt = 'ok_ac';
                    }else {
                        $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messages->descriptionDetail;
                        $rpt = 'ok_pe';
                    }
                    

                    // ASIGNANDO DATOS A INVOICING
                    $data_invoicing['status_response'] = $statusResponse;
                    $data_invoicing['status_document'] = $statusSunat;
                    $data_invoicing['pdf_file'] = $pdffile;
                    $data_invoicing['xml'] = $xml;
                    $data_invoicing['message_response'] = $messageResponse;

                } else { // SI NO PASO LA VALIDACION DE BIZLINKS
                    $statusResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->status;
                    $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messages->descriptionDetail;

                    $data_invoicing['status_response'] = $statusResponse;
                    $data_invoicing['message_response'] = $messageResponse;

                    $rpt = 'ok_er';
                }
            }

            // INSERTAR DATA A INVOICING
            $id_invoicing_insert = ModelFacturation::mdlCreateInvoicing('invoicing', $data_invoicing);
            $dataSales['id_invoicing'] = $id_invoicing_insert;

            // VERFICIANDO SI SE ESTÁ CREANDO O ACTUALIZANDO LA VENTA
            if (isset($dataSales['id_sale'])) { // ACTUALIZANDO LA VENTA
                // ACTUALIZAR INFORMACIÓN A SALES
                $updateSales = ModelSales::mdlUpdateSale('sales', $dataSales);
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

                    // DESCONTANDO EL STOCK DEL MOVIL
                    $dataMovilStock = array(
                        "id_movil" => $idm,
                        "status" => 5,
                        "user_update" => $_SESSION['id_user'],
                        "date_update" => $dataSales['date_create']
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
                // VERIFICANDO SI ES A CRÉDITO
                if($date_payds != NULL){

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
                        $responseDetalle = ModelSales::mdlCreateCronogramaNegociable('cronograma_negociable', $valoresQ);

                        $date_payd = next($date_payds);
                        $amount = next($amounts);

                        if ($date_payd === false && $amount === false) break;
                    }
                }else {
                    if($dataSales['payment_condition'] == 'Contado'){
                        // ELIMINANDO EL DETALLE DE LA TABLA CRONOGRAMA NEGOCIABLE
                        $delete = ModelSales::mdlDelete('cronograma_negociable', 'id_sale', $dataSales['id_sale']);
                    }
                }

            } else { // CREANDO NUEVA VENTA
                // INSERTAR INFORMACIÓN A SALES
                $id_sales = ModelSales::mdlCreateSales('sales', $dataSales);

                // INSERTANDO DETALLE EN SALES
                while (true) {
                    $idmovil = current($idmoviles);
                    $pricemovil = current($priceMoviles);

                    $idm = (($idmovil !== false) ? $idmovil : ", &nbsp;");
                    $price = (($pricemovil !== false) ? $pricemovil : ", &nbsp;");

                    // DESCONTANDO EL STOCK DEL MOVIL
                    $dataMovilStock = array(
                        "id_movil" => $idm,
                        "status" => 5,
                        "user_update" => $_SESSION['id_user'],
                        "date_update" => $dataSales['date_create']
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

                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                if($date_payds != NULL){
                    // INSERTANDO DETALLE DE CRONOGRAMA DE PAGOS
                    while (true) {
                        $date_payd = current($date_payds);
                        $amount = current($amounts);

                        $date = (($date_payd !== false) ? $date_payd : ", &nbsp;");
                        $amou = (($amount !== false) ? $amount : ", &nbsp;");

                        $valores = '(null,' . $id_sales . ',"' . $date . '","' . $amou . '",1,"' . $_SESSION['id_user'] . '","' . $currentDate . '", NULL, NULL),';
                        $valoresQ = substr($valores, 0, -1);
                        // INSERTAR CRONOGRAMA DE NEGOCIABLE
                        $responseDetalle = ModelSales::mdlCreateCronogramaNegociable('cronograma_negociable', $valoresQ);

                        $date_payd = next($date_payds);
                        $amount = next($amounts);

                        if ($date_payd === false && $amount === false) break;
                    }
                }
            }
        } else { // ERROR DE COMUNICACION
            $error = curl_error($ch);
            $rpt = 'error';
        }
        curl_close($ch);
        return $rpt;
    }

    # FUNCION PARA ENVIAR EL XML EN LA NOTA DE CRÉDITO Y DÉBITO
    static public function prepareXMLNotas($emisor, $adquiriente, $comprobante, $detalle, $idmoviles, $priceMoviles, $dataNote, $detalleCronograma, $date_payds, $amounts)
    {
        $soapUrl = $emisor['urlsoap'];
        $soapUsuario = $emisor['usuariosoap'];
        $soapPassword = $emisor['passwordsoap'];
        $soapMensaje = '<![CDATA[
        <SignOnLineCmd declare-sunat="1" declare-direct-sunat="1" publish="1" output="PDF">
            <parameter value="' . $emisor['ruc'] . '" name="idEmisor"/>
            <parameter value="' . $comprobante['tipodoc'] . '" name="tipoDocumento"/>
            <documento>
                <correoEmisor>' . $emisor['email'] . '</correoEmisor>
                <correoAdquiriente>' . $adquiriente['email'] . '</correoAdquiriente>
                <numeroDocumentoEmisor>' . $emisor['ruc'] . '</numeroDocumentoEmisor>
                <tipoDocumentoEmisor>' . $emisor['tipodoc'] . '</tipoDocumentoEmisor>
                <tipoDocumento>' . $comprobante['tipodoc'] . '</tipoDocumento>
                <razonSocialEmisor>' . $emisor['razon_social'] . '</razonSocialEmisor>
                <nombreComercialEmisor>-</nombreComercialEmisor>
                <serieNumero>' . $comprobante['serie'] . '-' . $comprobante['correlativo'] . '</serieNumero>
                <fechaEmision>' . $comprobante['fecha_emision'] . '</fechaEmision>
                <ubigeoEmisor>' . $emisor['ubigeo'] . '</ubigeoEmisor>
                <direccionEmisor>' . $emisor['direccion'] . '</direccionEmisor>
                <urbanizacion>-</urbanizacion>
                <provinciaEmisor>' . $emisor['provincia'] . '</provinciaEmisor>
                <departamentoEmisor>' . $emisor['departamento'] . '</departamentoEmisor>
                <distritoEmisor>' . $emisor['distrito'] . '</distritoEmisor>
                <paisEmisor>PE</paisEmisor>
                <numeroDocumentoAdquiriente>' . $adquiriente['numero_documento'] . '</numeroDocumentoAdquiriente>
                <tipoDocumentoAdquiriente>' . $adquiriente['tipodoc'] . '</tipoDocumentoAdquiriente>
                <razonSocialAdquiriente>' . $adquiriente['razon_social'] . '</razonSocialAdquiriente>
                <tipoMoneda>' . $comprobante['moneda'] . '</tipoMoneda>
                <' . $comprobante['tag'] . '>' . number_format($comprobante['subtotal'],2, '.', '') . '</' . $comprobante['tag'] . '>';
                if($dataNote['type_operation'] == '03'){
                    $soapMensaje .= '
                <totalValorVenta>0.00</totalValorVenta>
			    <totalPrecioVenta>0.00</totalPrecioVenta>
                <totalIgv>0.00</totalIgv>
                <totalImpuestos>0.00</totalImpuestos>
                <totalVenta>0.00</totalVenta>';
                } else {
                    $soapMensaje .= '
                <totalValorVenta>' . number_format($comprobante['subtotal'],2, '.', '') . '</totalValorVenta>
			    <totalPrecioVenta>' . number_format($comprobante['total'],2, '.', '') . '</totalPrecioVenta>
                <totalIgv>' . number_format($comprobante['igv'],2, '.', '') . '</totalIgv>
                <totalImpuestos>' . number_format($comprobante['igv'], 2, '.', '') . '</totalImpuestos>
                <totalVenta>' . number_format($comprobante['total'],2, '.', '') . '</totalVenta>';
                }
                $soapMensaje .= '
                <codigoSerieNumeroAfectado>' . $comprobante['motive_code'] . '</codigoSerieNumeroAfectado>
                <motivoDocumento>' . $comprobante['motive'] . '</motivoDocumento>
                <tipoDocumentoReferenciaPrincipal>' . $comprobante['type_reference'] . '</tipoDocumentoReferenciaPrincipal>
                <numeroDocumentoReferenciaPrincipal>' . $comprobante['reference'] . '</numeroDocumentoReferenciaPrincipal>
                <codigoLeyenda_1>1000</codigoLeyenda_1>
                <textoLeyenda_1>' . $comprobante['total_texto'] . '</textoLeyenda_1>
                <codigoAuxiliar40_1>9011</codigoAuxiliar40_1>
                <textoAuxiliar40_1>18%</textoAuxiliar40_1>
                <codigoAuxiliar100_1>9435</codigoAuxiliar100_1>
                <textoAuxiliar100_1>' . $emisor['usuario'] . '</textoAuxiliar100_1>
                <codigoAuxiliar100_2>9157</codigoAuxiliar100_2>
                <textoAuxiliar100_2>' . $adquiriente['condicion_pago'] . '</textoAuxiliar100_2>
                <codigoAuxiliar100_3>9351</codigoAuxiliar100_3>
                <textoAuxiliar100_3>' . $comprobante['exchange'] . '</textoAuxiliar100_3>
                <codigoAuxiliar100_4>9218</codigoAuxiliar100_4>
                <textoAuxiliar100_4>' . $comprobante['vendedor'] . '</textoAuxiliar100_4>
                <tipoOperacion>0101</tipoOperacion>
                <horaEmision>' . $comprobante['hora'] . '</horaEmision>
                <codigoLocalAnexoEmisor>0000</codigoLocalAnexoEmisor>
                <direccionAdquiriente>' . $adquiriente['direccion'] . '</direccionAdquiriente>
                <ubigeoAdquiriente>' . $adquiriente['ubigeo'] . '</ubigeoAdquiriente>
                <urbanizacionAdquiriente>-</urbanizacionAdquiriente>
                <provinciaAdquiriente>' . $adquiriente['provincia'] . '</provinciaAdquiriente>
                <departamentoAdquiriente>' . $adquiriente['departamento'] . '</departamentoAdquiriente>
                <distritoAdquiriente>' . $adquiriente['distrito'] . '</distritoAdquiriente>
                <formaPagoNegociable>' . $comprobante['forma_pago'] . '</formaPagoNegociable>';
                if($comprobante['forma_pago'] == 1){                    
                    $soapMensaje .= '<montoNetoPendiente>' . number_format($comprobante['total'],2, '.', '') . '</montoNetoPendiente>';
                    foreach ($detalleCronograma as $key => $value) {
                        $soapMensaje .= '
                        <montoPagoCuota'.($key+1).'>'. number_format($value['amount'],2, '.', '') .'</montoPagoCuota'.($key+1).'>
                        <fechaPagoCuota'.($key+1).'>'. $value['date_payd'] .'</fechaPagoCuota'.($key+1).'>';
                    }
                }
                $soapMensaje .= '<paisAdquiriente>PE</paisAdquiriente>';
                if($dataNote['type_operation'] == '03'){
                    $soapMensaje .= '
                <totalTributosOpeGratuitas>'.number_format($comprobante['gratuita'],2, '.', '').'</totalTributosOpeGratuitas>';
                }
        foreach ($detalle as $key => $value) {
            $soapMensaje .= '
                    <item>
                        <numeroOrdenItem>' . ($key + 1) . '</numeroOrdenItem>
                        <codigoProducto>' . $value['codigo_producto'] . '</codigoProducto>
                        <codigoProductoSUNAT>25100000</codigoProductoSUNAT>
                        <codigoAuxiliar100_5>9037</codigoAuxiliar100_5>
                        <textoAuxiliar100_5>' . $value['marca'] . '</textoAuxiliar100_5>
                        <codigoAuxiliar100_6>9038</codigoAuxiliar100_6>
                        <textoAuxiliar100_6>' . $value['modelo'] . '</textoAuxiliar100_6>
                        <codigoAuxiliar100_7>9052</codigoAuxiliar100_7>
                        <textoAuxiliar100_7>' . $value['serie_chasis'] . '</textoAuxiliar100_7>
                        <codigoAuxiliar100_8>9047</codigoAuxiliar100_8>
                        <textoAuxiliar100_8>' . $value['motor'] . '</textoAuxiliar100_8>
                        <codigoAuxiliar100_9>9041</codigoAuxiliar100_9>
                        <textoAuxiliar100_9>' . $value['color'] . '</textoAuxiliar100_9>
                        <codigoAuxiliar100_10>9042</codigoAuxiliar100_10>
                        <textoAuxiliar100_10>' . $value['fabricacion'] . '</textoAuxiliar100_10>
                        <codigoAuxiliar250_1>9991</codigoAuxiliar250_1>
                        <textoAuxiliar250_1>' . $value['dam'] . '</textoAuxiliar250_1>
                        <descripcion>' . $value['categoria'] . '</descripcion>
                        <cantidad>1.00</cantidad>
                        <unidadMedida>NIU</unidadMedida>
                        <importeTotalSinImpuesto>' . number_format($value['total_sin_impuesto'],2, '.', '') . '</importeTotalSinImpuesto>';
                        if($dataNote['type_operation'] == '03'){
                            $soapMensaje .= '
                        <importeUnitarioSinImpuesto>0.00</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>0.00</importeUnitarioConImpuesto>';
                        }else {
                            $soapMensaje .= '
                        <importeUnitarioSinImpuesto>' . number_format($value['unitario_sin_impuesto'],2, '.', '') . '</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>' . number_format($value['unitario_con_impuesto'],2, '.', '') . '</importeUnitarioConImpuesto>';
                        }
                        $soapMensaje .= '
                        <codigoImporteUnitarioConImpuesto>01</codigoImporteUnitarioConImpuesto>
                        <montoBaseIgv>' . number_format($value['monto_base_igv'],2, '.', '') . '</montoBaseIgv>
                        <tasaIgv>' . number_format($value['tasa_igv'],2, '.', '') . '</tasaIgv>
                        <importeIgv>' . number_format($value['importe_igv'],2, '.', '') . '</importeIgv>
                        <importeTotalImpuestos>' . number_format($value['total_impuesto'],2, '.', '') . '</importeTotalImpuestos>
                        <codigoRazonExoneracion>' . $value['exoneracion'] . '</codigoRazonExoneracion>';
                        if($dataNote['type_operation'] == '03'){
                            $soapMensaje .= '
                        <codigoImporteReferencial>02</codigoImporteReferencial>
                        <importeReferencial>'.number_format($value['total_sin_impuesto'],2, '.', '').'</importeReferencial>';
                        }
                        $soapMensaje .= '
                    </item>';
        }
        $key = ($key + 1);
        if ($dataNote['price_tramit'] != NULL) {
            $key = ($key + 1);
            $soapMensaje .= '
                    <item>
                        <numeroOrdenItem>' . $key . '</numeroOrdenItem>
                        <codigoProducto>TRAT</codigoProducto>
                        <codigoProductoSUNAT>25100000</codigoProductoSUNAT>
                        <descripcion>Precio por tramites</descripcion>
                        <cantidad>1.00</cantidad>
                        <unidadMedida>NIU</unidadMedida>
                        <importeTotalSinImpuesto>' . number_format($dataNote['subtotal_tramit'], 2, '.', '') . '</importeTotalSinImpuesto>
                        <importeUnitarioSinImpuesto>' . number_format($dataNote['subtotal_tramit'], 2, '.', '') . '</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>' . number_format($dataNote['price_tramit'], 2, '.', '') . '</importeUnitarioConImpuesto>
                        <codigoImporteUnitarioConImpuesto>01</codigoImporteUnitarioConImpuesto>
                        <montoBaseIgv>' . number_format($dataNote['subtotal_tramit'], 2, '.', '') . '</montoBaseIgv>
                        <tasaIgv>' . $dataNote['tasaIgv'] . '</tasaIgv>
                        <importeIgv>' . number_format($dataNote['importe_igv_tramit'], 2, '.', '') . '</importeIgv>
                        <importeTotalImpuestos>' . number_format($dataNote['importe_igv_tramit'], 2, '.', '') . '</importeTotalImpuestos>
                        <codigoRazonExoneracion>' . $comprobante['codigo_exonerado'] . '</codigoRazonExoneracion>
                    </item>';
        }

        if ($dataNote['price_transport'] != NULL) {
            $key = ($key + 1);
            $soapMensaje .= '
                    <item>
                        <numeroOrdenItem>' . $key . '</numeroOrdenItem>
                        <codigoProducto>TRANS</codigoProducto>
                        <codigoProductoSUNAT>25100000</codigoProductoSUNAT>
                        <descripcion>Precio por transporte</descripcion>
                        <cantidad>1.00</cantidad>
                        <unidadMedida>NIU</unidadMedida>
                        <importeTotalSinImpuesto>' . number_format($dataNote['subtotal_transport'], 2, '.', '') . '</importeTotalSinImpuesto>
                        <importeUnitarioSinImpuesto>' . number_format($dataNote['subtotal_transport'], 2, '.', '') . '</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>' . number_format($dataNote['price_transport'], 2, '.', '') . '</importeUnitarioConImpuesto>
                        <codigoImporteUnitarioConImpuesto>01</codigoImporteUnitarioConImpuesto>
                        <montoBaseIgv>' . number_format($dataNote['subtotal_transport'], 2, '.', '') . '</montoBaseIgv>
                        <tasaIgv>' . $dataNote['tasaIgv'] . '</tasaIgv>
                        <importeIgv>' . number_format($dataNote['importe_igv_transport'], 2, '.', '') . '</importeIgv>
                        <importeTotalImpuestos>' . number_format($dataNote['importe_igv_transport'], 2, '.', '') . '</importeTotalImpuestos>
                        <codigoRazonExoneracion>' . $comprobante['codigo_exonerado'] . '</codigoRazonExoneracion>
                    </item>';
        }

        if ($dataNote['price_transport'] != NULL) {
            $key = ($key + 1);
            $soapMensaje .= '
                    <item>
                        <numeroOrdenItem>' . $key . '</numeroOrdenItem>
                        <codigoProducto>PLACA</codigoProducto>
                        <codigoProductoSUNAT>25100000</codigoProductoSUNAT>
                        <descripcion>Precio por placa</descripcion>
                        <cantidad>1.00</cantidad>
                        <unidadMedida>NIU</unidadMedida>
                        <importeTotalSinImpuesto>' . number_format($dataNote['subtotal_placa'], 2, '.', '') . '</importeTotalSinImpuesto>
                        <importeUnitarioSinImpuesto>' . number_format($dataNote['subtotal_placa'], 2, '.', '') . '</importeUnitarioSinImpuesto>
                        <importeUnitarioConImpuesto>' . number_format($dataNote['price_placa'], 2, '.', '') . '</importeUnitarioConImpuesto>
                        <codigoImporteUnitarioConImpuesto>01</codigoImporteUnitarioConImpuesto>
                        <montoBaseIgv>' . number_format($dataNote['subtotal_placa'], 2, '.', '') . '</montoBaseIgv>
                        <tasaIgv>' . $dataNote['tasaIgv'] . '</tasaIgv>
                        <importeIgv>' . number_format($dataNote['importe_igv_placa'], 2, '.', '') . '</importeIgv>
                        <importeTotalImpuestos>' . number_format($dataNote['importe_igv_placa'], 2, '.', '') . '</importeTotalImpuestos>
                        <codigoRazonExoneracion>' . $comprobante['codigo_exonerado'] . '</codigoRazonExoneracion>
                    </item>';
        }
        $soapMensaje .= '
            </documento>
        </SignOnLineCmd>]]>';

        // XML DEL MENSAJE SOAP  
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.ce.ebiz.com/">
        <soapenv:Header/>
          <soapenv:Body>
            <ws:invoke> 
              <command>' . $soapMensaje . '</command> 
            </ws:invoke>
          </soapenv:Body>
        </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "D:/ebiz/app/pse-php/bizlinkzClient/bizlinks-com-pe.crt");
        curl_setopt($ch, CURLOPT_URL, $soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $soapUsuario . ":" . $soapPassword);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpcode == 200) { // COMUNICACION CORRECTA

            // PREPARAR INFORMACIÓN PARA INVOICING
            $data_invoicing = array(
                'document_type'   => $comprobante['tipodoc'],
                'serial_number'   => $comprobante['serie'],
                'correlative'     => $comprobante['correlativo'],
                'status_response' => '',
                'status_document' => '',
                'pdf_file'        => '',
                'xml'             => '',
                'message_response' => '',
                'request_xml'     => $soapMensaje,
                'response_xml'    => html_entity_decode($response),
                'user_create'     => $_SESSION['id_user'],
                'date_create'     => $dataNote['date_create']
            );

            if (empty($response)) {
                $rpt = 'vacio';
            } else {
                // RECORRIENDO RESPUESTA PARA SACAR LOS DATOS
                $xmlSoap = simplexml_load_string($response);
                $xmlEbiz = simplexml_load_string(
                    (string)$xmlSoap->children('soapenv', true)->Body
                        ->children('ns2', true)->invokeResponse
                        ->children('', true)->return
                );

                //COMPROBANDO SI LA RESPUESTA DE LA WS FUE CORRECTA O INCORRECTA
                if (isset($xmlEbiz->genericInvokeResponse->xmlResult->document->statusSunat)) { // SI HAY RESPUESTA DE SUNAT
                    $statusResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->status;
                    $statusSunat = $xmlEbiz->genericInvokeResponse->xmlResult->document->statusSunat;
                    $pdffile = $xmlEbiz->genericInvokeResponse->xmlResult->document->pdfFileUrl;
                    $xml = $xmlEbiz->genericInvokeResponse->xmlResult->document->xmlFileSignUrl;
                    if($statusSunat == 'AC_03'){
                        $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messageSunat;
                        $rpt = 'ok_ac';
                    }else {
                        $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messages->descriptionDetail;
                        $rpt = 'ok_pe';
                    }
                    

                    // ASIGNANDO DATOS A INVOICING
                    $data_invoicing['status_response'] = $statusResponse;
                    $data_invoicing['status_document'] = $statusSunat;
                    $data_invoicing['pdf_file'] = $pdffile;
                    $data_invoicing['xml'] = $xml;
                    $data_invoicing['message_response'] = $messageResponse;

                } else { // SI NO PASO LA VALIDACION DE BIZLINKS
                    $statusResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->status;
                    $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messages->descriptionDetail;

                    $data_invoicing['status_response'] = $statusResponse;
                    $data_invoicing['message_response'] = $messageResponse;

                    $rpt = 'ok_er';
                }
            }

            // INSERTAR DATA A INVOICING
            $id_invoicing_insert = ModelFacturation::mdlCreateInvoicing('invoicing', $data_invoicing);
            $dataNote['id_invoicing'] = $id_invoicing_insert;

            // VERFICIANDO SI SE ESTÁ CREANDO O ACTUALIZANDO LA NOTA
            if (isset($dataNote['id_sale'])) { // ACTUALIZANDO LA NOTA
                // ACTUALIZAR INFORMACIÓN A SALES
                $updateSales = ModelSales::mdlUpdateNote('sales', $dataNote);
                $response_detail_sales = ModelSales::mdlShowDetailSales('detail_sales', 'id_sales', $dataNote['id_sale']);
                
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
                $delete = ModelSales::mdlDelete('detail_sales', 'id_sales', $dataNote['id_sale']);

                // INSERTANDO DETALLE EN SALES
                while (true) {
                    $idmovil = current($idmoviles);
                    $pricemovil = current($priceMoviles);

                    $idm = (($idmovil !== false) ? $idmovil : ", &nbsp;");
                    $price = (($pricemovil !== false) ? $pricemovil : ", &nbsp;");

                    // DESCONTANDO EL STOCK DEL MOVIL
                    $dataMovilStock = array(
                        "id_movil" => $idm,
                        "status" => 5,
                        "user_update" => $_SESSION['id_user'],
                        "date_update" => $dataNote['date_create']
                    );
                    $responseMovil = ModelSales::mdlUpdateMovil('moviles', $dataMovilStock);

                    $valores = '(null,' . $dataNote['id_sale'] . ',"' . $idm . '","' . $price . '"),';
                    $valoresQ = substr($valores, 0, -1);
                    // INSERTAR DETALLE DE VENTAS
                    $responseDetalle = ModelSales::mdlCreateDetailSales('detail_sales', $valoresQ);

                    $idmovil = next($idmoviles);
                    $pricemovil = next($priceMoviles);

                    if ($idmovil === false && $pricemovil === false) break;
                }
                // VERIFICANDO SI ES A CRÉDITO
                if($date_payds != NULL){

                    // ELIMINANDO EL DETALLE DE LA TABLA CRONOGRAMA NEGOCIABLE
                    $delete = ModelSales::mdlDelete('cronograma_negociable', 'id_sale', $dataNote['id_sale']);

                    // INSERTANDO DETALLE DE CRONOGRAMA DE PAGOS
                    while (true) {
                        $date_payd = current($date_payds);
                        $amount = current($amounts);

                        $date = (($date_payd !== false) ? $date_payd : ", &nbsp;");
                        $amou = (($amount !== false) ? $amount : ", &nbsp;");

                        $valores = '(null,' . $dataNote['id_sale'] . ',"' . $date . '","' . $amou . '",1,"' . $_SESSION['id_user'] . '","' . $currentDate . '", NULL, NULL),';
                        $valoresQ = substr($valores, 0, -1);
                        // INSERTAR CRONOGRAMA DE NEGOCIABLE
                        $responseDetalle = ModelSales::mdlCreateCronogramaNegociable('cronograma_negociable', $valoresQ);

                        $date_payd = next($date_payds);
                        $amount = next($amounts);

                        if ($date_payd === false && $amount === false) break;
                    }
                }else {
                    if($dataNote['payment_condition'] == 'Contado'){
                        // ELIMINANDO EL DETALLE DE LA TABLA CRONOGRAMA NEGOCIABLE
                        $delete = ModelSales::mdlDelete('cronograma_negociable', 'id_sale', $dataNote['id_sale']);
                    }
                }

            } else { // CREANDO NUEVA NOTA
                // INSERTAR INFORMACIÓN A SALES
                $id_sales = ModelSales::mdlCreateNotes('sales', $dataNote);

                // INSERTANDO DETALLE EN SALES
                while (true) {
                    $idmovil = current($idmoviles);
                    $pricemovil = current($priceMoviles);

                    $idm = (($idmovil !== false) ? $idmovil : ", &nbsp;");
                    $price = (($pricemovil !== false) ? $pricemovil : ", &nbsp;");

                    $valores = '(null,' . $id_sales . ',"' . $idm . '","' . $price . '"),';
                    $valoresQ = substr($valores, 0, -1);
                    // INSERTAR DETALLE DE VENTAS
                    $responseDetalle = ModelSales::mdlCreateDetailSales('detail_sales', $valoresQ);

                    $idmovil = next($idmoviles);
                    $pricemovil = next($priceMoviles);

                    if ($idmovil === false && $pricemovil === false) break;
                }

                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                if($date_payds != NULL){
                    // INSERTANDO DETALLE DE CRONOGRAMA DE PAGOS
                    while (true) {
                        $date_payd = current($date_payds);
                        $amount = current($amounts);

                        $date = (($date_payd !== false) ? $date_payd : ", &nbsp;");
                        $amou = (($amount !== false) ? $amount : ", &nbsp;");

                        $valores = '(null,' . $id_sales . ',"' . $date . '","' . $amou . '",1,"' . $_SESSION['id_user'] . '","' . $currentDate . '", NULL, NULL),';
                        $valoresQ = substr($valores, 0, -1);
                        // INSERTAR CRONOGRAMA DE NEGOCIABLE
                        $responseDetalle = ModelSales::mdlCreateCronogramaNegociable('cronograma_negociable', $valoresQ);

                        $date_payd = next($date_payds);
                        $amount = next($amounts);

                        if ($date_payd === false && $amount === false) break;
                    }
                }
            }
        } else { // ERROR DE COMUNICACION
            $error = curl_error($ch);
            $rpt = 'error';
        }
        curl_close($ch);
        return $rpt;
    }

    # FUNCION PARA ENVIAR LA INFORMACIÓN EN EL XML DE GUIAS DE REMISION
    static public function prepareXMLGuias($emisor, $adquiriente, $comprobante, $detalle, $idmoviles, $dataGuia)
    {
        $soapUrl = $emisor['urlsoap'];
        $soapUsuario = $emisor['usuariosoap'];
        $soapPassword = $emisor['passwordsoap'];
        $soapMensaje = '<![CDATA[
           <SignOnLineDespatchCmd declare-sunat="1" declare-direct-sunat="1" publish="1" output="PDF">
               <parameter value="' . $emisor['ruc'] . '" name="idEmisor"/>
               <parameter value="' . $comprobante['tipodoc'] . '" name="tipoDocumento"/>
               <documento>
                    <version>2.0</version>
                    <versionUBL>2.1</versionUBL>
                    <serieNumeroGuia>' . $comprobante['serie'] . '-' . $comprobante['correlativo'] . '</serieNumeroGuia>
                    <fechaEmisionGuia>' . $comprobante['fecha_emision'] . '</fechaEmisionGuia>
                    <tipoDocumentoGuia>' . $comprobante['tipodoc'] . '</tipoDocumentoGuia>
                    <observaciones>' . $comprobante['observaciones'] . '</observaciones>
                    <numeroDocumentoRelacionado>' . $comprobante['numeroDocumento_relacionado'] . '</numeroDocumentoRelacionado>
                    <codigoDocumentoRelacionado>06</codigoDocumentoRelacionado>
                    <rucRazonSocialRemitente>' . $emisor['ruc'] . '</rucRazonSocialRemitente>
                    <numeroDocumentoRemitente>' . $emisor['ruc'] . '</numeroDocumentoRemitente>
                    <tipoDocumentoRemitente>' . $emisor['tipodoc'] . '</tipoDocumentoRemitente>
                    <razonSocialRemitente>' . $emisor['razon_social'] . '</razonSocialRemitente>
                    <numeroDocumentoDestinatario>' . $adquiriente['numero_documento'] . '</numeroDocumentoDestinatario>
                    <tipoDocumentoDestinatario>' . $adquiriente['tipodoc'] . '</tipoDocumentoDestinatario>
                    <razonSocialDestinatario>' . $adquiriente['razon_social'] . '</razonSocialDestinatario>
                    <IDShipment>1</IDShipment>
                    <motivoTraslado>' . $comprobante['motivo_traslado'] . '</motivoTraslado>
                    <descripcionMotivoTraslado>' . $comprobante['mensaje_motivo'] . '</descripcionMotivoTraslado>
                    <indTransbordoProgramado>false</indTransbordoProgramado>
                    <pesoBrutoTotalBienes>' . $comprobante['peso'] . '</pesoBrutoTotalBienes>
                    <unidadMedidaPesoBruto>KG</unidadMedidaPesoBruto>
                    <modalidadTraslado>' . $comprobante['modalidad_traslado'] . '</modalidadTraslado>
                    <fechaInicioTraslado>' . $comprobante['fechaInicio_traslado'] . 'T' . $comprobante['hora'] . '-05:00</fechaInicioTraslado>
                    <numeroPlacaVehiculo>' . $comprobante['numeroPlaca_vehiculo'] . '</numeroPlacaVehiculo>
                    <numeroDocumentoConductor>' . $comprobante['numeroDocumento_conductor'] . '</numeroDocumentoConductor>
                    <tipoDocumentoConductor>' . $comprobante['tipoDocumento_conductor'] . '</tipoDocumentoConductor>
                    <ubigeoPtoLLegada>' . $comprobante['ubigeo_llegada'] . '</ubigeoPtoLLegada>
                    <direccionPtoLLegada>' . $comprobante['direccion_llegada'] . '</direccionPtoLLegada>
                    <ubigeoPtoPartida>' . $comprobante['ubigeo_partida'] . '</ubigeoPtoPartida>
                    <direccionPtoPartida>' . $comprobante['direccion_partida'] . '</direccionPtoPartida>
                    <correoEmisor>' . $emisor['email'] . '</correoEmisor>
                    <correoAdquiriente>' . $adquiriente['email'] . '</correoAdquiriente>
                    <inHabilitado>1</inHabilitado>
                    <coTipoEmision>RE</coTipoEmision>';

        foreach ($detalle as $key => $value) {
            $soapMensaje .= '<GuiaItem>
                                            <numeroOrdenItem>' . ($key + 1) . '</numeroOrdenItem>
                                            <codigo>' . $value['id_movil'] . '</codigo>
                                            <unidadMedida>NIU</unidadMedida>
                                            <descripcion>MOTOR: ' . $value['motor'] . '</descripcion>
                                            <cantidad>1</cantidad>
                                        </GuiaItem>';
        }
        $soapMensaje .= '</documento>
           </SignOnLineDespatchCmd>]]>';

        // XML DEL MENSAJE SOAP  
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.ce.ebiz.com/">
        <soapenv:Header/>
          <soapenv:Body>
            <ws:invoke> 
              <command>' . $soapMensaje . '</command> 
            </ws:invoke>
          </soapenv:Body>
        </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "D:/ebiz/app/pse-php/bizlinkzClient/bizlinks-com-pe.crt");
        curl_setopt($ch, CURLOPT_URL, $soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $soapUsuario . ":" . $soapPassword);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpcode == 200) { // COMUNICACION CORRECTA

            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            // INSERTAR INFORMACIÓN A INVOICING
            $data_invoicing = array(
                'document_type'   => $comprobante['tipodoc'],
                'serial_number'   => $comprobante['serie'],
                'correlative'     => $comprobante['correlativo'],
                'status_response' => '',
                'status_document' => '',
                'pdf_file'        => '',
                'xml'        => '',
                'message_response' => '',
                'request_xml'     => $soapMensaje,
                'response_xml'    => html_entity_decode($response),
                'user_create'     => $_SESSION['id_user'],
                'date_create'     => $currentDate
            );


            if (empty($response)) {
                $rpt = 'vacio';
            } else {

                // RECORRIENDO RESPUESTA PARA SACAR LOS DATOS
                $xmlSoap = simplexml_load_string($response);
                $xmlEbiz = simplexml_load_string(
                    (string)$xmlSoap->children('soapenv', true)->Body
                        ->children('ns2', true)->invokeResponse
                        ->children('', true)->return
                );

                //COMPROBANDO SI LA RESPUESTA DE LA WS FUE CORRECTA O INCORRECTA
                if (isset($xmlEbiz->genericInvokeResponse->xmlResult->document->statusSunat)) { // SI HAY RESPUESTA DE SUNAT
                    $statusResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->status;
                    $statusSunat = $xmlEbiz->genericInvokeResponse->xmlResult->document->statusSunat;
                    $pdffile = $xmlEbiz->genericInvokeResponse->xmlResult->document->pdfFileUrl;
                    $xml = $xmlEbiz->genericInvokeResponse->xmlResult->document->xmlFileSignUrl;
                    $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messageSunat;

                    // ASIGNANDO DATOS A INVOICING
                    $data_invoicing['status_response'] = $statusResponse;
                    $data_invoicing['status_document'] = $statusSunat;
                    $data_invoicing['pdf_file'] = $pdffile;
                    $data_invoicing['xml'] = $xml;
                    $data_invoicing['message_response'] = $messageResponse;

                    $rpt = 'ok_ac';
                } else { // SI NO PASO LA VALIDACION DE BIZLINKS
                    $statusResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->status;
                    $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messages->descriptionDetail;

                    $data_invoicing['status_response'] = $statusResponse;
                    $data_invoicing['message_response'] = $messageResponse;

                    $rpt = 'ok_er';
                }
            }

            $id_invoicing_insert = ModelFacturation::mdlCreateInvoicing('invoicing', $data_invoicing);
            $dataGuia['id_invoicing'] = intval($id_invoicing_insert);

            // ASIGNANDO EL MENSAJE DEL MOTIVO
            $dataGuia['reason_message'] = $comprobante['mensaje_motivo'];

            ModelGuias::mdlCreateGuias('guias', $dataGuia);
            return $dataGuia;
        } else { // ERROR DE COMUNICACION
            $error = curl_error($ch);
            $rpt = 'error';
        }

        curl_close($ch);
        return $rpt;
    }

    # FUNCION PARA ENVIAR LA INFORMACIÓN EN EL XML DE RESUMEN DE COMPROBANTES
    static public function prepareXMLRc($emisor, $adquiriente, $comprobante, $data_rc)
    {
        $soapUrl = $emisor['urlsoap'];
        $soapUsuario = $emisor['usuariosoap'];
        $soapPassword = $emisor['passwordsoap'];
        $soapMensaje = '<![CDATA[
            <SignOnLineSummaryCmd declare-sunat="1" replicate="1" output="">
            <parameter value="' . $emisor['ruc'] . '" name="idEmisor"/>
            <parameter value="RC" name="tipoDocumento"/>
            <parameter value="185" name="version"/>
                <resumen>>
                    <numeroDocumentoEmisor>' . $emisor['ruc'] . '</numeroDocumentoEmisor>
                    <version>1.1</version>
                    <versionUBL>2.0</versionUBL>
                    <tipoDocumentoEmisor>' . $emisor['tipodoc'] . '</tipoDocumentoEmisor>
                    <resumenId>RC-' . $data_rc['serie'] . '-' . $data_rc['correlative'] . '</resumenId>
                    <fechaEmisionComprobante>' . $comprobante['fecha_emision'] . '</fechaEmisionComprobante>
                    <fechaGeneracionResumen>' . $comprobante['fecha_emision'] . '</fechaGeneracionResumen>
                    <razonSocialEmisor>' . $emisor['razon_social'] . '</razonSocialEmisor>
                    <correoEmisor>' . $emisor['email'] . '</correoEmisor>
                    <resumenTipo>RC</resumenTipo>
                    <SummaryItem>
                        <numeroFila>1</numeroFila>
                        <tipoDocumento>' . $comprobante['tipodoc'] . '</tipoDocumento>
                        <tipoMoneda>' . $comprobante['moneda'] . '</tipoMoneda>
                        <totalValorVentaOpGravadasConIgv>' . $comprobante['subtotal'] . '</totalValorVentaOpGravadasConIgv>
                        <totalIsc>0</totalIsc>
                        <totalIgv>' . $comprobante['igv'] . '</totalIgv>
                        <totalVenta>' . $comprobante['total'] . '</totalVenta>
                        <numeroCorrelativo>' . $comprobante['serie'] . '-' . $comprobante['correlativo'] . '</numeroCorrelativo>
                        <numeroDocumentoAdquiriente>' . $adquiriente['numero_documento'] . '</numeroDocumentoAdquiriente>
                        <tipoDocumentoAdquiriente>' . $adquiriente['tipodoc'] . '</tipoDocumentoAdquiriente>
                        <estadoItem>1</estadoItem>
                    </SummaryItem>
                    <resumenVersion>185</resumenVersion>
                </resumen>
            </SignOnLineSummaryCmd>]]>';

        // XML DEL MENSAJE SOAP  
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.ce.ebiz.com/">
        <soapenv:Header/>
          <soapenv:Body>
            <ws:invoke> 
              <command>' . $soapMensaje . '</command> 
            </ws:invoke>
          </soapenv:Body>
        </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "D:/ebiz/app/pse-php/bizlinkzClient/bizlinks-com-pe.crt");
        curl_setopt($ch, CURLOPT_URL, $soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $soapUsuario . ":" . $soapPassword);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode == 200) { // COMUNICACION CORRECTA

            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            // INSERTAR INFORMACIÓN A INVOICING
            $data_invoicing = array(
                'document_type'   => 'RC',
                'serial_number'   => $data_rc['serie'],
                'correlative'     => $data_rc['correlative'],
                'status_response' => '',
                'status_document' => '',
                'pdf_file'        => '',
                'xml'             => '',
                'message_response' => '',
                'request_xml'     => $soapMensaje,
                'response_xml'    => html_entity_decode($response),
                'user_create'     => $_SESSION['id_user'],
                'date_create'     => $currentDate
            );

            if (empty($response)) {
                $rpt = 'vacio';
            } else {
                // RECORRIENDO RESPUESTA PARA SACAR LOS DATOS
                $xmlSoap = simplexml_load_string($response);
                $xmlEbiz = simplexml_load_string(
                    (string)$xmlSoap->children('soapenv', true)->Body
                        ->children('ns2', true)->invokeResponse
                        ->children('', true)->return
                );

                //COMPROBANDO SI LA RESPUESTA DE LA WS FUE CORRECTA O INCORRECTA
                if (isset($xmlEbiz->genericInvokeResponse->xmlResult->document->statusSunat)) { // SI HAY RESPUESTA DE SUNAT
                    $statusResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->status;
                    $statusSunat = $xmlEbiz->genericInvokeResponse->xmlResult->document->statusSunat;
                    $pdffile = $xmlEbiz->genericInvokeResponse->xmlResult->document->pdfFileUrl;
                    $xml = $xmlEbiz->genericInvokeResponse->xmlResult->document->xmlFileSignUrl;
                    $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messageSunat;

                    // ASIGNANDO DATOS A INVOICING
                    $data_invoicing['status_response'] = $statusResponse;
                    $data_invoicing['status_document'] = $statusSunat;
                    $data_invoicing['pdf_file'] = $pdffile;
                    $data_invoicing['xml'] = $xml;
                    $data_invoicing['message_response'] = $messageResponse;

                    $rpt = 'ok_ac';
                } else { // SI NO PASO LA VALIDACION DE BIZLINKS
                    $statusResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->status;
                    $messageResponse = $xmlEbiz->genericInvokeResponse->xmlResult->document->messages->descriptionDetail;

                    $data_invoicing['status_response'] = $statusResponse;
                    $data_invoicing['message_response'] = $messageResponse;

                    $rpt = 'ok_er';
                }
            }

            $id_invoicing_insert = ModelFacturation::mdlCreateInvoicing('invoicing', $data_invoicing);
            $data_rc['id_invoicing'] = $id_invoicing_insert;
            // PREPARANDO DATOS DE VOUCHER AFECTADO
            $affected = array(
                'voucher_affected' => $comprobante['serie'] . '-' . $comprobante['correlativo'],
                'type_voucher_affected' => $comprobante['tipodoc']
            );
            // INSERTAR INFORMACIÓN A RC
            $insert_sales = ModelRc::mdlCreateRc('rc', $affected, $data_rc);
        } else { // ERROR DE COMUNICACION
            $error = curl_error($ch);
            $rpt = 'error';
        }
        curl_close($ch);
        return $rpt;
    }
}
