<?php

require_once 'connection.php';

class ModelNational
{
    # CREACION DE NUEVAS COMPRAS NACIONALES AL SISTEMA
    static public function mdlCreateNational($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:id_provider,:date_emision,:date_llegada,:id_subsidiary,:id_model,:observation,:transport_guide, 1,:user_create,:date_create,null,null)");

        
        $statement->bindParam(":id_provider", $data['id_provider'], PDO::PARAM_INT);
        $statement->bindParam(":date_emision", $data['date_emision'], PDO::PARAM_STR);
        $statement->bindParam(":date_llegada", $data['date_llegada'], PDO::PARAM_STR);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":id_model", $data['id_model'], PDO::PARAM_INT);
        $statement->bindParam(":observation", $data['observation'], PDO::PARAM_STR);
        $statement->bindParam(":transport_guide", $data['transport_guide'], PDO::PARAM_STR);
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

    # CREACION DE NUEVAS COMPRAS NACIONALES AL SISTEMA
    static public function mdlCreateNationalDetail($query, $insert_data)
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

    #MOSTRAR LOS DATOS DE LAS COMPRAS NACIONALES
    static public function mdlShowNational($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT n.id,n.id_provider,n.date_emision,n.date_llegada,n.id_subsidiary,n.id_model,n.observation,n.transport_guide,n.status,n.user_create,n.date_create,n.user_update,n.date_update,pr.name 'provider'
            , s.description 'subsidiary', m.name_lucki 'model'
                        FROM $table n
                        INNER JOIN providers pr ON n.id_provider = pr.id
                        INNER JOIN subsidiarys s ON n.id_subsidiary = s.id
                        INNER JOIN models m ON n.id_model = m.id
            WHERE n.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT n.id,n.id_provider,n.date_emision,n.date_llegada,n.id_subsidiary,n.id_model,n.observation,n.transport_guide,n.status,n.user_create,n.date_create,n.user_update,n.date_update,pr.name 'provider'
            , s.description 'subsidiary', m.name_lucki 'model'
            FROM $table n
                INNER JOIN providers pr ON n.id_provider = pr.id
                INNER JOIN subsidiarys s ON n.id_subsidiary = s.id
                INNER JOIN models m ON n.id_model = m.id
            WHERE n.status != 3 ORDER BY n.id ASC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA LEER LOS DATOS DETALLE DE LAS COMPRAS NACIONALES
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

    # FUNCION PARA CONSULTAR LOS DATOS DEL MOVIL DETALLE DE LAS COMPRAS NACIONALES
    static public function mdlConsultMovilesDetail($table, $item, $value){
        $statement = Connection::connect()->prepare("SELECT d.dam, d.chasis, d.motor, d.color, d.fabricacion, n.id_model, n.id_subsidiary, n.transport_guide
        FROM $table n INNER JOIN detail_national d ON n.id = d.id_national
        WHERE n.id = :value");
        $statement->bindParam(":value", $value, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();

        $statement->close();
        $statement = null;
    }

    /* ACTUALIZAR COMPRAS NACIONALES */
    static public function mdlEditNational($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET id_provider = :id_provider, date_emision = :date_emision, date_llegada = :date_llegada, id_subsidiary = :id_subsidiary, id_model = :id_model, observation = :observation, transport_guide = :transport_guide, status = :status, user_update = :user_update, date_update = :date_update WHERE id = :id ");

        $statement->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $statement->bindParam(":id_provider", $data['id_provider'], PDO::PARAM_INT);
        $statement->bindParam(":date_emision", $data['date_emision'], PDO::PARAM_STR);
        $statement->bindParam(":date_llegada", $data['date_llegada'], PDO::PARAM_STR);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":id_model", $data['id_model'], PDO::PARAM_INT);
        $statement->bindParam(":observation", $data['observation'], PDO::PARAM_STR);
        $statement->bindParam(":transport_guide", $data['transport_guide'], PDO::PARAM_STR);
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

    # ELIMINAR COMPRA NACIONAL
    static public function mdlDeleteNational($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET status = 3 WHERE id = :id ");
        $statement->bindParam(":id", $data, PDO::PARAM_INT);

        if ($statement->execute()) {

            $statement2 = Connection::connect()->prepare("DELETE FROM detail_national WHERE id_national = :id ");
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