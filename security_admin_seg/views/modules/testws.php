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
                        <li class="breadcrumb-item active">Nueva guia</li>
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
                                <h3 class="card-title">test WS</h3>
                            </div>
                            <div class="card-body">
                                <?php 
                                    
$soapUrl = 'http://testing.bizlinks.com.pe/integrador21/ws/invoker?wsdl';
$soapUsuario = 'LUCKIMOTORS';
$soapPassword = '20531452055';
$soapMensaje = '<![CDATA[
    <SignOnLineCmd declare-sunat="1" declare-direct-sunat="1" publish="1" output="PDF">
        <parameter value="20531452055" name="idEmisor"/>
        <parameter value="01" name="tipoDocumento"/>
        <documento>
            <correoEmisor>fernandolopez@luckimotors.com</correoEmisor>
            <correoAdquiriente>fer.lop.sot@gmail.com</correoAdquiriente>
            <numeroDocumentoEmisor>20531452055</numeroDocumentoEmisor>
            <tipoDocumentoEmisor>6</tipoDocumentoEmisor>
            <tipoDocumento>01</tipoDocumento>
            <razonSocialEmisor>LUCKI MOTORS DEL PERU S.R.L.</razonSocialEmisor>
            <nombreComercialEmisor>-</nombreComercialEmisor>
            <serieNumero>FBIZ-09799999</serieNumero>
            <fechaEmision>2021-06-25</fechaEmision>
            <ubigeoEmisor>220901</ubigeoEmisor>
            <direccionEmisor>JR. PLAZA MAYOR 301 - TARAPOTO</direccionEmisor>
            <urbanizacion>-</urbanizacion>
            <provinciaEmisor>SAN MARTIN</provinciaEmisor>
            <departamentoEmisor>SAN MARTIN</departamentoEmisor>
            <distritoEmisor>TARAPOTO</distritoEmisor>
            <paisEmisor>PE</paisEmisor>
            <numeroDocumentoAdquiriente>10715904247</numeroDocumentoAdquiriente>
            <tipoDocumentoAdquiriente>6</tipoDocumentoAdquiriente>
            <razonSocialAdquiriente>FERNANDO ANTONIO LOPEZ SOTOMAYOR</razonSocialAdquiriente>
            <tipoMoneda>PEN</tipoMoneda>
            <totalValorVentaNetoOpGravadas>4152.54</totalValorVentaNetoOpGravadas>
            <totalIgv>747.46</totalIgv>
            <totalImpuestos>747.46</totalImpuestos>
            <totalVenta>4900.00</totalVenta>
            <codigoLeyenda_1>1000</codigoLeyenda_1>
            <textoLeyenda_1>CUATRO MIL NOVECIENTOSNOVECIENTOS CEROCERO CEROCERO  CON 00/100 SOLES</textoLeyenda_1>
            <codigoAuxiliar40_1>9011</codigoAuxiliar40_1>
            <textoAuxiliar40_1>18%</textoAuxiliar40_1>
            <tipoReferencia_1>09</tipoReferencia_1>
            <numeroDocumentoReferencia_1>-</numeroDocumentoReferencia_1>
            <codigoAuxiliar100_1>9435</codigoAuxiliar100_1>
            <textoAuxiliar100_1>USU-FA</textoAuxiliar100_1>
            <codigoAuxiliar100_2>9157</codigoAuxiliar100_2>
            <textoAuxiliar100_2>Contado</textoAuxiliar100_2>
            <codigoAuxiliar100_3>9351</codigoAuxiliar100_3>
            <textoAuxiliar100_3>3.90</textoAuxiliar100_3>
            <codigoAuxiliar100_4>9218</codigoAuxiliar100_4>
            <textoAuxiliar100_4>vendedor 1 up</textoAuxiliar100_4>
            <tipoOperacion>0101</tipoOperacion>
            <horaEmision>00:26:20</horaEmision>
            <codigoLocalAnexoEmisor>0000</codigoLocalAnexoEmisor>
            <direccionAdquiriente>calle mz e lt 8 santa anita</direccionAdquiriente>
            <ubigeoAdquiriente>150137</ubigeoAdquiriente>
            <urbanizacionAdquiriente>-</urbanizacionAdquiriente>
            <provinciaAdquiriente>Lima </provinciaAdquiriente>
            <departamentoAdquiriente>Lima</departamentoAdquiriente>
            <distritoAdquiriente>Santa Anita</distritoAdquiriente>
            <paisAdquiriente>PE</paisAdquiriente>
            <item>
                <numeroOrdenItem>1</numeroOrdenItem>
                <codigoProducto>14888</codigoProducto>
                <codigoProductoSUNAT>25100000</codigoProductoSUNAT>
                <codigoAuxiliar100_5>9037</codigoAuxiliar100_5>
                <textoAuxiliar100_5>WANXIN</textoAuxiliar100_5>
                <codigoAuxiliar100_6>9038</codigoAuxiliar100_6>
                <textoAuxiliar100_6>MOTOR150A</textoAuxiliar100_6>
                <codigoAuxiliar100_7>9052</codigoAuxiliar100_7>
                <textoAuxiliar100_7>LHJYJLLA5MB435535</textoAuxiliar100_7>
                <codigoAuxiliar100_8>9047</codigoAuxiliar100_8>
                <textoAuxiliar100_8>WX169FML21A04004</textoAuxiliar100_8>
                <codigoAuxiliar100_9>9041</codigoAuxiliar100_9>
                <textoAuxiliar100_9>ROJO/NEGRO </textoAuxiliar100_9>
                <codigoAuxiliar100_10>9042</codigoAuxiliar100_10>
                <textoAuxiliar100_10>2021</textoAuxiliar100_10>
                <descripcion>TRIMOTO DE PASAJEROS</descripcion>
                <cantidad>1.00</cantidad>
                <unidadMedida>UND</unidadMedida>
                <importeTotalSinImpuesto>4152.54</importeTotalSinImpuesto>
                <importeUnitarioSinImpuesto>4152.54</importeUnitarioSinImpuesto>
                <importeUnitarioConImpuesto>4900.00</importeUnitarioConImpuesto>
                <codigoImporteUnitarioConImpuesto>01</codigoImporteUnitarioConImpuesto>
                <montoBaseIgv>4152.54</montoBaseIgv>
                <tasaIgv>18.00</tasaIgv>
                <importeIgv>747.46</importeIgv>
                <importeTotalImpuestos>747.46</importeTotalImpuestos>
                <codigoRazonExoneracion>10</codigoRazonExoneracion>
            </item>
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
                                        "Content-type: aplication/xml;charset=\"utf-8\"",
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
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_USERPWD, $soapUsuario . ":" . $soapPassword);
                                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                                    curl_setopt($ch, CURLOPT_POST, true);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                                    $response = curl_exec($ch);

                                    /* $xmlSoap = simplexml_load_string($response);
                                    $xmlEbiz = simplexml_load_string( (string)$xmlSoap->children('soapenv',true)->Body
                                                                                      ->children('ns2',true)->invokeResponse
                                                                                      ->children('',true)->return
                                                                    );
                                    $status = $xmlEbiz->genericInvokeResponse->xmlResult->document->messages->descriptionDetail; */

                                    echo '<h4>Response: </h4>';
                                    echo '<pre>';
                                    print_r($response);
                                    /* echo 'RECORRIENDO:' .$status; */
                                    echo '</pre>';

                                    curl_close($ch);
                                ?>
                            </div>
                        </div>
                        <div class="card-footer">
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