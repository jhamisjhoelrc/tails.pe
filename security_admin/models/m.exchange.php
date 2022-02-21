<?php

require_once 'connection.php';

class ModelExchange
{
    /* CREAR TIPO DE CAMBIO */
    static public function mdlCreateExchange($table, $data){
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:value_exchange,:date_exchange, 1, :user_create, :date_create,null,null)");

        
        $statement->bindParam(":value_exchange", $data['value_exchange'], PDO::PARAM_STR);
        $statement->bindParam(":date_exchange", $data['date_exchange'], PDO::PARAM_STR);
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
    
    /* ACTUALIZAR TIPO DE CAMBIO */
    static public function mdlUpdateExchange($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET value_exchange = :value_exchange, user_update = :user_update, date_update = :date_update WHERE id = :id;");

        $statement->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $statement->bindParam(":value_exchange", $data['value_exchange'], PDO::PARAM_STR);
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

    # MOSTRAR LOS DATOS DE LOS TIPOS DE CAMBIO
    static public function mdlShowExchange($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT e.id, e.value_exchange, e.date_exchange FROM $table e
            WHERE e.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT e.id, e.value_exchange, e.date_exchange FROM $table e
            WHERE e.status != 3 ORDER BY e.date_exchange DESC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }
}