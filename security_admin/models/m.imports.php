<?php

require_once 'connection.php';

class ModelImport
{
    # CREACION DE NUEVAS IMPORTACIONES AL SISTEMA
    static public function mdlCreateImport($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:id_provider,:id_subsidiary,:guia,:bl,:chine_code,:container,:contract,:invoice_number,:invoice_date,:id_model,:date_zarpe,:date_arribo,:date_numeration,:date_emision,:date_llegada,:price_flete,:dam_moto,:dam_repuesto,:dam_total,:real_moto,:real_repuesto,:real_total,:diferent,1,:user_create,:date_create,null,null)");


        $statement->bindParam(":id_provider", $data['id_provider'], PDO::PARAM_INT);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":guia", $data['guia'], PDO::PARAM_STR);
        $statement->bindParam(":bl", $data['bl'], PDO::PARAM_STR);
        $statement->bindParam(":chine_code", $data['chine_code'], PDO::PARAM_STR);
        $statement->bindParam(":container", $data['container'], PDO::PARAM_STR);
        $statement->bindParam(":contract", $data['contract'], PDO::PARAM_STR);
        $statement->bindParam(":invoice_number", $data['invoice_number'], PDO::PARAM_STR);
        $statement->bindParam(":invoice_date", $data['invoice_date'], PDO::PARAM_STR);
        $statement->bindParam(":id_model", $data['id_model'], PDO::PARAM_INT);
        $statement->bindParam(":date_zarpe", $data['date_zarpe'], PDO::PARAM_STR);
        $statement->bindParam(":date_arribo", $data['date_arribo'], PDO::PARAM_STR);
        $statement->bindParam(":date_numeration", $data['date_numeration'], PDO::PARAM_STR);
        $statement->bindParam(":date_emision", $data['date_emision'], PDO::PARAM_STR);
        $statement->bindParam(":date_llegada", $data['date_llegada'], PDO::PARAM_STR);
        $statement->bindParam(":price_flete", $data['price_flete'], PDO::PARAM_STR);
        $statement->bindParam(":dam_moto", $data['dam_moto'], PDO::PARAM_STR);
        $statement->bindParam(":dam_repuesto", $data['dam_repuesto'], PDO::PARAM_STR);
        $statement->bindParam(":dam_total", $data['dam_total'], PDO::PARAM_STR);
        $statement->bindParam(":real_moto", $data['real_moto'], PDO::PARAM_STR);
        $statement->bindParam(":real_repuesto", $data['real_repuesto'], PDO::PARAM_STR);
        $statement->bindParam(":real_total", $data['real_total'], PDO::PARAM_STR);
        $statement->bindParam(":diferent", $data['diferent'], PDO::PARAM_STR);
        $statement->bindParam(":user_create", $data['user_create'], PDO::PARAM_INT);
        $statement->bindParam(":date_create", $data['date_create'], PDO::PARAM_STR);


        if ($statement->execute()) {
            $statement2 = Connection::connect()->prepare("SELECT max(id) 'id' FROM $table");
            $statement2->execute();
            $array_id =  $statement2->fetch();
            $id = $array_id['id'];
            return $id;
        }

        $statement->close();
        $statement = null;
    }

    # CREACION DE NUEVAS IMPORTACIONES AL SISTEMA
    static public function mdlCreateImportDetail($query, $insert_data)
    {
        $statement = Connection::connect()->prepare($query);

        if ($statement->execute($insert_data)) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    #MOSTRAR LOS DATOS DE LAS IMPORTACIONES
    static public function mdlShowImport($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT i.id,i.id_provider,i.id_subsidiary,i.guia,i.bl,i.chine_code,i.container,i.contract,i.invoice_number,i.invoice_date,i.id_model,i.date_zarpe,i.date_arribo,i.date_numeration,i.date_emision,i.date_llegada,i.price_flete,i.dam_moto,i.dam_repuesto,i.dam_total,i.real_moto,i.real_repuesto,i.real_total,i.diferent,i.status,pr.name 'provider', s.description 'subsidiary',m.name_lucki 'model'
            FROM $table i
            INNER JOIN providers pr ON i.id_provider = pr.id
            INNER JOIN subsidiarys s ON i.id_subsidiary = s.id
            INNER JOIN models m ON i.id_model = m.id
            WHERE i.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT  i.id,i.id_provider,i.id_subsidiary,i.guia,i.bl,i.chine_code,i.container,i.contract,i.invoice_number,i.invoice_date,i.id_model,i.date_zarpe,i.date_arribo,i.date_numeration,i.date_emision,i.date_llegada,i.price_flete,i.dam_moto,i.dam_repuesto,i.dam_total,i.real_moto,i.real_repuesto,i.real_total,i.diferent,i.status,pr.name 'provider', s.description 'subsidiary',m.name_lucki 'model'
            FROM $table i
            INNER JOIN providers pr ON i.id_provider = pr.id
            INNER JOIN subsidiarys s ON i.id_subsidiary = s.id
            INNER JOIN models m ON i.id_model = m.id
            WHERE i.status != 3 ORDER BY i.id ASC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA LEER LOS DATOS DETALLE DE LAS IMPORTACIONES
    static public function mdlShowDetail($table, $item, $value)
    {

        $statement = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item;");
        $statement->bindParam(":" . $item, $value, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA LEER LOS DATOS DE PROVEEDORES AUTORIZADOS
    static public function mdlShowProvider($table, $item, $value)
    {

        $statement = Connection::connect()->prepare("SELECT id,name FROM $table WHERE $item = :$item AND status = 1;");
        $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA CONSULTAR LOS DATOS DEL MOVIL DETALLE DE LAS IMPORTACIONES
    static public function mdlConsultMovilesDetail($table, $item, $value)
    {
        $statement = Connection::connect()->prepare("SELECT d.dam, d.chasis, d.motor, d.color, d.fabricacion, i.id_model, i.id_subsidiary, i.guia
        FROM $table i INNER JOIN detail_import d ON i.id = d.id_import
        WHERE i.id = :value");
        $statement->bindParam(":value", $value, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();

        $statement->close();
        $statement = null;
    }
    /* ACTUALIZAR IMPORTACIONES */
    static public function mdlEditImport($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET id_provider = :id_provider, id_subsidiary = :id_subsidiary, guia = :guia, bl = :bl, chine_code = :chine_code, container = :container, contract = :contract, invoice_number = :invoice_number, invoice_date = :invoice_date, id_model = :id_model, date_zarpe = :date_zarpe, date_arribo = :date_arribo, date_numeration = :date_numeration, date_emision = :date_emision, date_llegada = :date_llegada, price_flete = :price_flete, dam_moto =:dam_moto, dam_repuesto = :dam_repuesto, dam_total = :dam_total, real_moto = :real_moto, real_repuesto = :real_repuesto, real_total = :real_total, diferent = :diferent, status = :status, user_update = :user_update, date_update = :date_update WHERE id = :id ");

        $statement->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $statement->bindParam(":id_provider", $data['id_provider'], PDO::PARAM_INT);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":guia", $data['guia'], PDO::PARAM_STR);
        $statement->bindParam(":bl", $data['bl'], PDO::PARAM_STR);
        $statement->bindParam(":chine_code", $data['chine_code'], PDO::PARAM_STR);
        $statement->bindParam(":container", $data['container'], PDO::PARAM_STR);
        $statement->bindParam(":contract", $data['contract'], PDO::PARAM_STR);
        $statement->bindParam(":invoice_number", $data['invoice_number'], PDO::PARAM_STR);
        $statement->bindParam(":invoice_date", $data['invoice_date'], PDO::PARAM_STR);
        $statement->bindParam(":id_model", $data['id_model'], PDO::PARAM_INT);
        $statement->bindParam(":date_zarpe", $data['date_zarpe'], PDO::PARAM_STR);
        $statement->bindParam(":date_arribo", $data['date_arribo'], PDO::PARAM_STR);
        $statement->bindParam(":date_numeration", $data['date_numeration'], PDO::PARAM_STR);
        $statement->bindParam(":date_emision", $data['date_emision'], PDO::PARAM_STR);
        $statement->bindParam(":date_llegada", $data['date_llegada'], PDO::PARAM_STR);
        $statement->bindParam(":price_flete", $data['price_flete'], PDO::PARAM_STR);
        $statement->bindParam(":dam_moto", $data['dam_moto'], PDO::PARAM_STR);
        $statement->bindParam(":dam_repuesto", $data['dam_repuesto'], PDO::PARAM_STR);
        $statement->bindParam(":dam_total", $data['dam_total'], PDO::PARAM_STR);
        $statement->bindParam(":real_moto", $data['real_moto'], PDO::PARAM_STR);
        $statement->bindParam(":real_repuesto", $data['real_repuesto'], PDO::PARAM_STR);
        $statement->bindParam(":real_total", $data['real_total'], PDO::PARAM_STR);
        $statement->bindParam(":diferent", $data['diferent'], PDO::PARAM_STR);
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

    # ELIMINAR IMPORTACIÓN
    static public function mdlDeleteImport($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET status = 3 WHERE id = :id ");
        $statement->bindParam(":id", $data, PDO::PARAM_INT);

        if ($statement->execute()) {

            $statement2 = Connection::connect()->prepare("DELETE FROM detail_import WHERE id_import = :id ");
            $statement2->bindParam(":id", $data, PDO::PARAM_INT);
            if ($statement2->execute()) {
                return 'ok';
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }
}
