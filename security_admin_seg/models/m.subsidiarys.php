<?php

require_once 'connection.php';

class ModelSubsidiary
{


    # MOSTRAR VENDEDORES
    static public function mdlShowSubsidiary($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT s.id,s.responsible,s.description,s.address,s.phone,s.id_district,s.serie,
            s.correlative_f,s.correlative_b, s.correlative_nc, s.correlative_nc_b, s.correlative_nd, s.correlative_nd_b, s.correlative_g, s.exonerated,s.status, d.name 'district', p.name 'province', de.name 'department'
            FROM $table s INNER JOIN ubigeo_peru_districts d ON s.id_district = d.id
                          INNER JOIN ubigeo_peru_provinces p ON d.province_id = p.id
                          INNER JOIN ubigeo_peru_departments de ON p.department_id = de.id
            WHERE s.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT s.id,s.responsible,s.description,s.address,s.phone,s.id_district,s.serie,
            s.correlative_f, s.correlative_b, s.correlative_nc, s.correlative_nc_b, s.correlative_nd, s.correlative_nd_b, s.correlative_g, s.exonerated,s.status, d.name 'district', p.name 'province', de.name 'department'
            FROM $table s INNER JOIN ubigeo_peru_districts d ON s.id_district = d.id
                          INNER JOIN ubigeo_peru_provinces p ON d.province_id = p.id
                          INNER JOIN ubigeo_peru_departments de ON p.department_id = de.id
            WHERE s.status != 3 ORDER BY s.id ASC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # MOSTRAR UBIGEO
    static public function mdlShowUbigeo($item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT d.id,d.name 'district',d.province_id,d.department_id,p.id,p.name 'province',p.department_id,de.id,de.name 'department'
            FROM ubigeo_peru_districts d 
                          INNER JOIN ubigeo_peru_provinces p ON d.province_id = p.id
                          INNER JOIN ubigeo_peru_departments de ON p.department_id = de.id
            WHERE d.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT d.id,d.name 'district',d.province_id,d.department_id,p.id,p.name 'province',p.department_id,de.id,de.name 'department'
            FROM ubigeo_peru_districts d 
                          INNER JOIN ubigeo_peru_provinces p ON d.province_id = p.id
                          INNER JOIN ubigeo_peru_departments de ON p.department_id = de.id
            WHERE d.status != 3 ORDER BY d.id ASC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # CREACION DE NUEVAS SUCURSALES
    static public function mdlCreateSubsidiary($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:responsible,:description,:address,:phone,:id_district,1,:user_create,:date_create,null,null)");

        $statement->bindParam(":description", $data['description'], PDO::PARAM_STR);
        $statement->bindParam(":address", $data['address'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
        $statement->bindParam(":responsible", $data['responsible'], PDO::PARAM_STR);
        $statement->bindParam(":id_district", $data['id_district'], PDO::PARAM_STR);
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

    # ACTUALIZACION DE SUCURSALES
    static public function mdlEditSubsidiary($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET description = :description, address = :address, phone = :phone, responsible = :responsible, id_district = :id_district, user_update = :user_update, date_update = :date_update WHERE id = :id ");

        $statement->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $statement->bindParam(":description", $data['description'], PDO::PARAM_STR);
        $statement->bindParam(":address", $data['address'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
        $statement->bindParam(":responsible", $data['responsible'], PDO::PARAM_STR);
        $statement->bindParam(":id_district", $data['id_district'], PDO::PARAM_STR);
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

    # ELIMINAR SUCURSAL
    static public function mdlDeleteSubsidiary($table, $data)
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
