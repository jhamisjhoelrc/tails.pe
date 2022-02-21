<?php

class Connection
{
    static public function connect()
    {
        # access testing
        $link = new PDO("mysql:host=localhost;dbname=test_tails", "root", "");
        # prueba en servidor
        #$link = new PDO("mysql:host=localhost;dbname=grupoact_test_luckimotors", "grupoact_fernand", "03530425lopezF");
        # produccion
        #$link = new PDO("mysql:host=localhost;dbname=grupoact_prdsystem", "grupoact_system_adm", "Wmn}w-}5*R-N");

        $link->exec("set names utf8");
        return $link;
    }
}
