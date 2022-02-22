<?php

class ModelModel{

    # FUNCION PARA LISTAR LOS MODELOS
    static public function mdlShowModel($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT m.id,m.name_dua,m.name_lucki,m.id_brand,m.id_categories,m.status, b.descripction 'brand', c.descripction 'category' 
            FROM $table m INNER JOIN brands b ON m.id_brand = b.id
                          INNER JOIN categories c ON m.id_categories = c.id 
            WHERE m.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT m.id,m.name_dua,m.name_lucki,m.id_brand,m.id_categories,m.status,b.descripction 'brand', c.descripction 'category'
            FROM $table m INNER JOIN brands b ON m.id_brand = b.id
                          INNER JOIN categories c ON m.id_categories = c.id 
            WHERE m.status != 3 ORDER BY m.id DESC;");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA CREAR NUEVO MODELO
    static public function mdlCreateModel($table, $data){
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:name_dua,:name_lucki,:id_brand ,:id_categories ,1 ,:user_create ,:date_create ,null ,null)");

        $statement->bindParam(":name_dua", $data['name_dua'], PDO::PARAM_STR);
        $statement->bindParam(":name_lucki", $data['name_lucki'], PDO::PARAM_STR);
        $statement->bindParam(":id_brand", $data['id_brand'], PDO::PARAM_INT);
        $statement->bindParam(":id_categories", $data['id_categories'], PDO::PARAM_INT);
        $statement->bindParam(":user_create", $data['user_create'], PDO::PARAM_INT);
        $statement->bindParam(":date_create", $data['date_create'], PDO::PARAM_STR);

        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA EDITAR MODELO
    static public function mdlUpdateModel($table, $data){
        $statement = Connection::connect()->prepare("UPDATE $table SET name_dua = :name_dua, name_lucki = :name_lucki, id_brand  = :id_brand , id_categories  = :id_categories, user_update = :user_update, date_update = :date_update WHERE id = :id ");

        $statement->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $statement->bindParam(":name_dua", $data['name_dua'], PDO::PARAM_STR);
        $statement->bindParam(":name_lucki", $data['name_lucki'], PDO::PARAM_STR);
        $statement->bindParam(":id_brand", $data['id_brand'], PDO::PARAM_INT);
        $statement->bindParam(":id_categories", $data['id_categories'], PDO::PARAM_INT);
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

    # FUNCION PARA ELIMINAR MODELO
    static public function mdlDeleteModel($table, $data){
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