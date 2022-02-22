<?php

require_once('connection.php');

class ModelMovil
{

    # FUNCION PARA CREAR MOVILES
    static public function mdlCreateMovil($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:dam,:id_model,:chasis,:motor,:colour,:id_subsidiary,'desarmada',:guia,:fabricacion,null,null,null,null,1,:user_create,:date_create,null,null)");


        $statement->bindParam(":dam", $data['dam'], PDO::PARAM_STR);
        $statement->bindParam(":id_model", $data['id_model'], PDO::PARAM_INT);
        $statement->bindParam(":chasis", $data['chasis'], PDO::PARAM_STR);
        $statement->bindParam(":motor", $data['motor'], PDO::PARAM_STR);
        $statement->bindParam(":colour", $data['colour'], PDO::PARAM_STR);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":guia", $data['guia'], PDO::PARAM_STR);
        $statement->bindParam(":fabricacion", $data['fabricacion'], PDO::PARAM_INT);
        $statement->bindParam(":user_create", $data['user_create'], PDO::PARAM_INT);
        $statement->bindParam(":date_create", $data['date_create'], PDO::PARAM_STR);

        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
    }

    #MOSTRAR LOS DATOS DE LOS MOVILES
    static public function mdlShowMoviles($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT m.id, m.dam, m.chasis, m.motor, m.colour, m.status, m.condition_movil, m.guia, m.fabricacion, m.observation,
            mo.name_lucki 'model', b.descripction 'brand', c.descripction 'category', s.description 'subsidiary', m.id_assembler, m.date_assembly, m.observation_assembly, a.names 'assembler'
            FROM $table m INNER JOIN models mo ON m.id_model = mo.id
            INNER JOIN brands b ON mo.id_brand = b.id
            INNER JOIN categories c ON mo.id_categories = c.id
            INNER JOIN subsidiarys s ON m.id_subsidiary = s.id
            LEFT JOIN assemblers a ON m.id_assembler = a.id
            WHERE m.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT m.id, m.dam, m.chasis, m.motor, m.colour, m.status, m.condition_movil, m.guia, m.fabricacion, m.observation,
            mo.name_lucki 'model', b.descripction 'brand', c.descripction 'category', s.description 'subsidiary'
            FROM $table m INNER JOIN models mo ON m.id_model = mo.id
            INNER JOIN brands b ON mo.id_brand = b.id
            INNER JOIN categories c ON mo.id_categories = c.id
            INNER JOIN subsidiarys s ON m.id_subsidiary = s.id
            WHERE m.status != 3 ORDER BY m.id DESC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # ACTUALIZAR MOVIL ASSEMBLER
    static public function mdlUpdateAssembler($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET id_assembler = :id_assembler, date_assembly = :date_assembly, observation_assembly = :observation_assembly, condition_movil = 'ensamblada', user_update = :user_update, date_update = :date_update WHERE id = :id ");

        $statement->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $statement->bindParam(":id_assembler", $data['id_assembler'], PDO::PARAM_INT);
        $statement->bindParam(":date_assembly", $data['date_assembly'], PDO::PARAM_STR);
        $statement->bindParam(":observation_assembly", $data['observation_assembly'], PDO::PARAM_STR);
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

    # ELIMINAR MOVIL
    static public function mdlDeleteMovil($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET status = 3 WHERE id = :id ");
        $statement->bindParam(":id", $data, PDO::PARAM_INT);

        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }
}
