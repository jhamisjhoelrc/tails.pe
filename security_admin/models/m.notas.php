<?php

require_once 'connection.php';

class ModelNotas
{
    # FUNCION PARA CONSULTAR LOS DATOS DEL COMPROBANTE AFECTADO
    static public function mdlShowComprobanteAfecto($value){
        $statement = Connection::connect()->prepare("SELECT s.id, s.id_invoicing, s.id_customer, s.id_district, s.id_subsidiary, s.id_seller, s.payment_condition, 
        s.type_voucher,s.id_movil,s.total_price,s.exchange,b.descripction 'brand', mo.name_lucki 'model',m.motor, m.colour,m.fabricacion,m.chasis,c.descripction 'category',
        i.serial_number, i.correlative, i.id 'id_invoicing',i.document_type 'tipo_comprobante'
        FROM sales s INNER JOIN invoicing i ON s.id_invoicing = i.id
                        INNER JOIN moviles m ON s.id_movil = m.id
                        INNER JOIN models mo ON m.id_model = mo.id
                        INNER JOIN brands b ON mo.id_brand = b.id
                        INNER JOIN categories c ON mo.id_categories = c.id
        WHERE i.id = $value");
        $statement->execute();
        return $statement->fetch();
    }

    # FUNCION PARA INSERTAR REGISTRO EN LAS NOTAS
    static public function mdlCreateNotacredito($table, $data){
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null, :id_invoicing, :serial_number_voucher_affected,:type_voucher_affected,:affection_motive,:reason_message, :broadcast_date, :id_customer, :total_price, 1, :user_create, :date_create,null,null)");

        $statement->bindParam(":id_invoicing", $data['id_invoicing'], PDO::PARAM_INT);
        $statement->bindParam(":serial_number_voucher_affected", $data['serial_number_voucher_affected'], PDO::PARAM_STR);
        $statement->bindParam(":type_voucher_affected", $data['type_voucher_affected'], PDO::PARAM_STR);
        $statement->bindParam(":affection_motive", $data['affection_motive'], PDO::PARAM_STR);
        $statement->bindParam(":reason_message", $data['reason_message'], PDO::PARAM_STR);
        $statement->bindParam(":broadcast_date", $data['broadcast_date'], PDO::PARAM_STR);
        $statement->bindParam(":id_customer", $data['id_customer'], PDO::PARAM_INT);
        $statement->bindParam(":total_price", $data['total_price'], PDO::PARAM_STR);
        $statement->bindParam(":user_create", $data['user_create'], PDO::PARAM_INT);
        $statement->bindParam(":date_create", $data['date_create'], PDO::PARAM_STR);

        if ($statement->execute()) {
            return 'ok';
        }else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA MOSTRAR LAS NOTAS
    static public function mdlShowNotas($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT s.id,s.id_invoicing, s.id_customer,s.id_district,s.id_subsidiary,s.id_seller,s.currency,s.date_sale,s.send_sunat,s.payment_condition,s.price_tramit,s.price_transport,s.price_placa,
            s.type_voucher,s.total_price,s.status,c.names 'customer', i.document_type, c.id_document, d.description 'document', c.document_number, c.phone, c.email, c.address, c.customer_type,  i.serial_number, i.correlative, i.status_response, i.status_document, i.message_response, i.pdf_file, ud.name 'district', up.name 'province', ude.name 'department', su.description 'subsidiary', se.names 'seller'
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
            s.type_voucher,s.total_price, s.type_reference, s.reference, s.motive, s.status,c.names 'customer', i.document_type, i.serial_number, 
            i.correlative, i.status_response, i.status_document, i.message_response, i.pdf_file, s.type_reference, s.reference, s.motive   FROM $table s
                        INNER JOIN customers c ON s.id_customer = c.id
                        LEFT JOIN invoicing i ON s.id_invoicing = i.id
            WHERE i.document_type in ('07','08') AND s.status != 3 ORDER BY s.id DESC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA MOSTRAR LAS NOTAS DE DEBITO
    static public function mdlShowNotadebito($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT d.id, d.voucher_affected, d.type_voucher_affected, d.affection_motive, d.reason_message, d.broadcast_date, d.id_customer, d.total_price, d.status,
            i.document_type, i.serial_number, i.correlative, i.document_type, i.status_response, i.status_document, i.pdf_file, c.names 'name_customer'
            FROM $table d INNER JOIN invoicing i ON d.id_invoicing = i.id
            INNER JOIN customers c ON d.id_customer = c.id
            WHERE d.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT d.id, d.voucher_affected, d.type_voucher_affected, d.affection_motive, d.reason_message, d.broadcast_date, d.id_customer, d.total_price, d.status,
            i.document_type, i.serial_number, i.correlative, i.document_type, i.status_response, i.status_document, i.pdf_file, c.names 'name_customer'
            from $table d INNER JOIN invoicing i ON d.id_invoicing = i.id
            INNER JOIN customers c ON d.id_customer = c.id
            WHERE d.status != 3 ORDER BY d.id ASC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA CONSULTAR LAS FACTURAS Y BOLETAS
    static public function mdlShowFactbol($table, $item, $value){
        $statement = Connection::connect()->prepare("SELECT * FROM $table
        WHERE document_type in ('01','03') ORDER BY id DESC");
        $statement->execute();
        return $statement->fetchAll();
    }
}