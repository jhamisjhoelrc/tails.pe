<?php

class ControllerMant
{

    # MOSTRAR LOS DATOS DE MANTENIMIENTO
    static public function ctrShowMant($table, $item, $value)
    {
        $response = ModelMant::mdlShowMant($table, $item, $value);
        return $response;
    }

}