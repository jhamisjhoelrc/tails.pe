<?php

require_once 'connection.php';

class ModelSales
{
    # FUNCION PARA CONSULTAR EL ULTIMO ID
    static public function mdlConsultId($table){
        $statement = Connection::connect()->prepare("SELECT max(id) 'id' FROM $table");
        $statement->execute();
        $array_id =  $statement->fetch();
        $id = $array_id['id'];
        return $id;
    }

    # FUNCION PARA CONSULTAR LOS DATOS DE DISTRITO, PROVINCIA Y DEPARTAMENTO
    static public function mdlShowDistricts($item, $value, $table){
        $statement = Connection::connect()->prepare("SELECT d.name 'distrito', p.name 'province', de.name 'department' FROM $table d 
            INNER JOIN ubigeo_peru_provinces p ON d.province_id = p.id
            INNER JOIN ubigeo_peru_departments de ON d.department_id = de.id
        WHERE d.$item = :$item");
        $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    # FUNCION PARA CONSULTAR EL DETALLE DE LA VENTA
    static public function mdlShowDetailSales($table, $item, $value){
        $statement = Connection::connect()->prepare("SELECT ds.id, ds.id_movil, c.descripction 'category', b.descripction 'brand', mo.name_lucki 'model', 
        m.chasis, m.motor, m.colour, ds.priceMovil, m.fabricacion
        FROM $table ds INNER JOIN moviles m ON ds.id_movil = m.id
                                      INNER JOIN models mo ON m.id_model = mo.id
                                      INNER JOIN categories c ON mo.id_categories = c.id
                                      INNER JOIN brands b ON mo.id_brand = b.id
        WHERE ds.$item = :$item");
        $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }

    # FUNCION PARA CONSULTAR LOS DATOS ESPECIFICOS DE LA VENTA
    static public function mdlShowSalesNotacredito($table, $item, $value){
        $statement = Connection::connect()->prepare("SELECT s.type_voucher,c.id 'id_customer', c.names,c.document_number,do.description 'document_type',c.id_document, c.address, ca.descripction 'categories', b.descripction 'marca', m.name_lucki 'model', mo.chasis, mo.motor, mo.colour,
        s.total_price, i.serial_number, i.correlative
                FROM $table s INNER JOIN customers c ON s.id_customer = c.id
                             INNER JOIN documents_type do ON c.id_document = do.id
                             INNER JOIN moviles mo ON s.id_movil = mo.id
                             INNER JOIN models m ON mo.id_model = m.id
                             INNER JOIN brands b ON m.id_brand = b.id
                             INNER JOIN categories ca ON m.id_categories = ca.id
                             INNER JOIN invoicing i ON s.id_invoicing = i.id
        WHERE s.$item = :$item");
        $statement->bindParam(":" . $item, $value, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    # FUNCION PARA CONSULTAR INVOICING DE LA VENTA
    static public function mdlShowInvoicing($table, $item, $value){
        $statement = Connection::connect()->prepare("SELECT message_response FROM $table
        WHERE $item = :$item");
        $statement->bindParam(":" . $item, $value, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    # FUNCION PARA CONSULTAR PAGOS DE LA VENTA
    static public function mdlShowPayd($table, $item, $value){
        $statement = Connection::connect()->prepare("SELECT * FROM $table
        WHERE $item = :$item");
        $statement->bindParam(":" . $item, $value, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    # FUNCION PARA CONSULTAR CRONOGRAMA NEGOCIABLE DE LA VENTA
    static public function mdlShowCronograma($table, $item, $value){
        $statement = Connection::connect()->prepare("SELECT * FROM $table
        WHERE $item = :$item");
        $statement->bindParam(":" . $item, $value, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    # FUNCION PARA MOSTRAR LAS VENTAS
    static public function mdlShowSales($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT s.id,s.id_invoicing, s.id_customer,s.id_district,s.id_subsidiary,s.id_seller,s.currency,s.date_sale,s.send_sunat,s.payment_condition,s.price_tramit,s.price_transport,s.price_placa, s.type_reference, s.reference, s.motive,
            s.type_operation, s.type_voucher,s.total_price,s.status,c.names 'customer', i.document_type, c.id_document, d.description 'document', c.document_number, c.phone, c.email, c.address, c.customer_type,  i.serial_number, i.correlative, i.status_response, i.status_document, i.message_response, i.pdf_file, i.xml, ud.name 'district', up.name 'province', ude.name 'department', su.description 'subsidiary', se.names 'seller'
                FROM sales s
                        INNER JOIN customers c ON s.id_customer = c.id
                        INNER JOIN documents_type d ON c.id_document = d.id
                        INNER JOIN ubigeo_peru_districts ud ON s.id_district = ud.id
                        INNER JOIN ubigeo_peru_provinces up ON ud.province_id = up.id
                        INNER JOIN ubigeo_peru_departments ude ON ud.department_id = ude.id 
                        INNER JOIN subsidiarys su ON s.id_subsidiary = su.id
                        INNER JOIN sellers se ON s.id_seller = se.id
                        LEFT JOIN invoicing i ON s.id_invoicing = i.id
            WHERE s.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT s.id,s.id_invoicing, s.id_customer,s.id_district,s.id_subsidiary,s.id_seller,s.currency,s.date_sale,s.payment_condition,s.price_tramit,s.price_transport,s.price_placa,
            s.type_operation, s.type_voucher,s.total_price,s.status,c.names 'customer', i.document_type, i.serial_number, 
            i.correlative, i.status_response, i.status_document, i.message_response, i.pdf_file, i.xml  FROM $table s
                        INNER JOIN customers c ON s.id_customer = c.id
                        LEFT JOIN invoicing i ON s.id_invoicing = i.id
            WHERE s.type_voucher in ('01','03') AND s.status != 3 ORDER BY s.id DESC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # CREACION DE NUEVAS VENTAS
    static public function mdlCreateSales($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:id_invoicing, :id_customer, :id_district, :id_subsidiary, :id_seller, :currency, :date_sale, :payment_condition, :price_tramit, :price_transport, :price_placa, :type_operation, :type_voucher, :total_price, :exchange, 1, :send_sunat, null, null, null, :user_create, :date_create, null, null)");
        
        $statement->bindParam(":id_invoicing", $data['id_invoicing'], PDO::PARAM_INT);
        $statement->bindParam(":id_customer", $data['id_customer'], PDO::PARAM_INT);
        $statement->bindParam(":id_district", $data['id_district'], PDO::PARAM_STR);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":id_seller", $data['id_seller'], PDO::PARAM_INT);
        $statement->bindParam(":currency", $data['currency'], PDO::PARAM_STR);
        $statement->bindParam(":date_sale", $data['date_sale'], PDO::PARAM_STR);
        $statement->bindParam(":payment_condition", $data['payment_condition'], PDO::PARAM_STR);
        $statement->bindParam(":price_tramit", $data['price_tramit'], PDO::PARAM_STR);
        $statement->bindParam(":price_transport", $data['price_transport'], PDO::PARAM_STR);
        $statement->bindParam(":price_placa", $data['price_placa'], PDO::PARAM_STR);
        $statement->bindParam(":type_operation", $data['type_operation'], PDO::PARAM_STR);
        $statement->bindParam(":type_voucher", $data['type_voucher'], PDO::PARAM_STR);
        $statement->bindParam(":total_price", $data['total_price'], PDO::PARAM_STR);
        $statement->bindParam(":exchange", $data['exchange'], PDO::PARAM_STR);
        $statement->bindParam(":send_sunat", $data['send_sunat'], PDO::PARAM_STR);
        $statement->bindParam(":user_create", $data['user_create'], PDO::PARAM_INT);
        $statement->bindParam(":date_create", $data['date_create'], PDO::PARAM_STR);

        if ($statement->execute()) {
            $statement2 = Connection::connect()->prepare("SELECT max(id) 'id' FROM $table");
            $statement2->execute();
            $array_id =  $statement2->fetch();
            $id = $array_id['id'];
            return $id;
        }else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # CREACION DE NUEVAS NOTAS
    static public function mdlCreateNotes($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:id_invoicing, :id_customer, :id_district, :id_subsidiary, :id_seller, :currency, :date_sale, :payment_condition, :price_tramit, :price_transport, :price_placa, :type_operation, :type_voucher, :total_price, :exchange, 1, :send_sunat, :type_reference, :reference, :motive, :user_create, :date_create, null, null)");
        
        $statement->bindParam(":id_invoicing", $data['id_invoicing'], PDO::PARAM_INT);
        $statement->bindParam(":id_customer", $data['id_customer'], PDO::PARAM_INT);
        $statement->bindParam(":id_district", $data['id_district'], PDO::PARAM_STR);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":id_seller", $data['id_seller'], PDO::PARAM_INT);
        $statement->bindParam(":currency", $data['currency'], PDO::PARAM_STR);
        $statement->bindParam(":date_sale", $data['date_sale'], PDO::PARAM_STR);
        $statement->bindParam(":payment_condition", $data['payment_condition'], PDO::PARAM_STR);
        $statement->bindParam(":price_tramit", $data['price_tramit'], PDO::PARAM_STR);
        $statement->bindParam(":price_transport", $data['price_transport'], PDO::PARAM_STR);
        $statement->bindParam(":price_placa", $data['price_placa'], PDO::PARAM_STR);
        $statement->bindParam(":type_operation", $data['type_operation'], PDO::PARAM_STR);
        $statement->bindParam(":type_voucher", $data['type_voucher'], PDO::PARAM_STR);
        $statement->bindParam(":total_price", $data['total_price'], PDO::PARAM_STR);
        $statement->bindParam(":exchange", $data['exchange'], PDO::PARAM_STR);
        $statement->bindParam(":send_sunat", $data['send_sunat'], PDO::PARAM_STR);
        $statement->bindParam(":type_reference", $data['type_reference'], PDO::PARAM_STR);
        $statement->bindParam(":reference", $data['reference'], PDO::PARAM_STR);
        $statement->bindParam(":motive", $data['msj_motive'], PDO::PARAM_STR);
        $statement->bindParam(":user_create", $data['user_create'], PDO::PARAM_INT);
        $statement->bindParam(":date_create", $data['date_create'], PDO::PARAM_STR);

        if ($statement->execute()) {
            $statement2 = Connection::connect()->prepare("SELECT max(id) 'id' FROM $table");
            $statement2->execute();
            $array_id =  $statement2->fetch();
            $id = $array_id['id'];
            return $id;
        }else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA ACTUALIZAR EL MOVIL STOCK VENDIDO
    static public function mdlUpdateMovil($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET status = :status, user_update = :user_update, date_update = :date_update WHERE id = :id ");

        $statement->bindParam(":id", $data['id_movil'], PDO::PARAM_INT);
        $statement->bindParam(":status", $data['status'], PDO::PARAM_INT);
        $statement->bindParam(":user_update", $data['user_update'], PDO::PARAM_INT);
        $statement->bindParam(":date_update", $data['date_update'], PDO::PARAM_STR);


        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA ACTUALIZAR EL MONTO TOTAL DE LA VENTA
    static public function mdlUpdateTotalSales($table, $id, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET total_price = :total_price WHERE id = :id ");

        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->bindParam(":total_price", $data, PDO::PARAM_STR);


        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA INSERTAR DETALLE DE LAS VENTAS
    static public function mdlCreateDetailSales($table, $data){
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES $data");

        if ($statement->execute()) {
            return 'ok';
        }else {
            return 'error';
        }
    }

    # FUNCION PARA INSERTAR CRONOGRAMA NEGOCIABLE
    static public function mdlCreateCronogramaNegociable($table, $data){
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES $data");

        if ($statement->execute()) {
            return 'ok';
        }else {
            return 'error';
        }
    }

    # FUNCION PARA INSERTAR DETALLE DE LOS PAGOS
    static public function mdlCreateDetailPayment($table, $data){
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES $data");

        if ($statement->execute()) {
            return 'ok';
        }else {
            return 'error';
        }
    }

    # FUNCION PARA ACTUALIZAR LA VENTA
    static public function mdlUpdateSale($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET id_invoicing = :id_invoicing, id_customer = :id_customer, id_district = :id_district, id_subsidiary = :id_subsidiary, id_seller = :id_seller, currency = :currency, date_sale = :date_sale, payment_condition = :payment_condition, price_tramit = :price_tramit, price_transport = :price_transport, price_placa = :price_placa, type_operation = :type_operation, type_voucher = :type_voucher, total_price = :total_price, exchange = :exchange, send_sunat = :send_sunat, user_update = :user_update, date_update = :date_update   WHERE id = :id ");

        $statement->bindParam(":id_invoicing", $data['id_invoicing'], PDO::PARAM_INT);
        $statement->bindParam(":id_customer", $data['id_customer'], PDO::PARAM_INT);
        $statement->bindParam(":id_district", $data['id_district'], PDO::PARAM_STR);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":id_seller", $data['id_seller'], PDO::PARAM_INT);
        $statement->bindParam(":currency", $data['currency'], PDO::PARAM_STR);
        $statement->bindParam(":date_sale", $data['date_sale'], PDO::PARAM_STR);
        $statement->bindParam(":payment_condition", $data['payment_condition'], PDO::PARAM_STR);
        $statement->bindParam(":price_tramit", $data['price_tramit'], PDO::PARAM_STR);
        $statement->bindParam(":price_transport", $data['price_transport'], PDO::PARAM_STR);
        $statement->bindParam(":price_placa", $data['price_placa'], PDO::PARAM_STR);
        $statement->bindParam(":type_operation", $data['type_operation'], PDO::PARAM_STR);
        $statement->bindParam(":type_voucher", $data['type_voucher'], PDO::PARAM_STR);
        $statement->bindParam(":total_price", $data['total_price'], PDO::PARAM_STR);
        $statement->bindParam(":exchange", $data['exchange'], PDO::PARAM_STR);
        $statement->bindParam(":send_sunat", $data['send_sunat'], PDO::PARAM_STR);
        $statement->bindParam(":user_update", $data['user_update'], PDO::PARAM_INT);
        $statement->bindParam(":date_update", $data['date_update'], PDO::PARAM_STR);
        $statement->bindParam(":id", $data['id_sale'], PDO::PARAM_INT);


        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA ACTUALIZAR LA VENTA
    static public function mdlUpdateNote($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET id_invoicing = :id_invoicing, id_customer = :id_customer, id_district = :id_district, id_subsidiary = :id_subsidiary, id_seller = :id_seller, currency = :currency, date_sale = :date_sale, payment_condition = :payment_condition, price_tramit = :price_tramit, price_transport = :price_transport, price_placa = :price_placa, type_operation = :type_operation, type_voucher = :type_voucher, total_price = :total_price, exchange = :exchange, send_sunat = :send_sunat, type_reference = :type_reference, reference = :reference, motive = :motive,  user_update = :user_update, date_update = :date_update   WHERE id = :id ");

        $statement->bindParam(":id_invoicing", $data['id_invoicing'], PDO::PARAM_INT);
        $statement->bindParam(":id_customer", $data['id_customer'], PDO::PARAM_INT);
        $statement->bindParam(":id_district", $data['id_district'], PDO::PARAM_STR);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":id_seller", $data['id_seller'], PDO::PARAM_INT);
        $statement->bindParam(":currency", $data['currency'], PDO::PARAM_STR);
        $statement->bindParam(":date_sale", $data['date_sale'], PDO::PARAM_STR);
        $statement->bindParam(":payment_condition", $data['payment_condition'], PDO::PARAM_STR);
        $statement->bindParam(":price_tramit", $data['price_tramit'], PDO::PARAM_STR);
        $statement->bindParam(":price_transport", $data['price_transport'], PDO::PARAM_STR);
        $statement->bindParam(":price_placa", $data['price_placa'], PDO::PARAM_STR);
        $statement->bindParam(":type_operation", $data['type_operation'], PDO::PARAM_STR);
        $statement->bindParam(":type_voucher", $data['type_voucher'], PDO::PARAM_STR);
        $statement->bindParam(":total_price", $data['total_price'], PDO::PARAM_STR);
        $statement->bindParam(":exchange", $data['exchange'], PDO::PARAM_STR);
        $statement->bindParam(":send_sunat", $data['send_sunat'], PDO::PARAM_STR);
        $statement->bindParam(":type_reference", $data['type_reference'], PDO::PARAM_STR);
        $statement->bindParam(":type_reference", $data['type_reference'], PDO::PARAM_STR);
        $statement->bindParam(":reference", $data['reference'], PDO::PARAM_STR);
        $statement->bindParam(":motive", $data['motive'], PDO::PARAM_STR);
        $statement->bindParam(":user_update", $data['user_update'], PDO::PARAM_INT);
        $statement->bindParam(":date_update", $data['date_update'], PDO::PARAM_STR);
        $statement->bindParam(":id", $data['id_sale'], PDO::PARAM_INT);


        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA ELIMINAR EL CONTENIDO DE UNA TABLA
    static public function mdlDelete($table, $item, $value)
    {
        $statement = Connection::connect()->prepare("DELETE FROM $table WHERE $item = $value");

        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }


    
}