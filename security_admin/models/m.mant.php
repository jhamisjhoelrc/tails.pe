<?php

require_once('connection.php');

class ModelMant
{

    # FUNCION PARA LEER LOS DATOS
    static public function mdlShowMant($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item AND status NOT IN(2,3)");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT * FROM $table WHERE status NOT IN(2,3) ORDER BY id ASC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # ACTUALIZAR DATOS CON UN PARAMETRO
    static public function mdlUpdate($table, $item1, $value1, $item2, $value2)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET $item1 = :$item1 WHERE $item2 = :$item2 ");
        $statement->bindParam(":" . $item1, $value1, PDO::PARAM_STR);
        $statement->bindParam(":" . $item2, $value2, PDO::PARAM_STR);

        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

}