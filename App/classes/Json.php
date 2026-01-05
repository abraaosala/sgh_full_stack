<?php

namespace App\classes;

use App\Dao\Entity\Entity;

class Json
{
    // public static $header = JSON;
    public static function encode(mixed $data)
    {
        echo json_encode($data);
    }

    public static function decode(string $json)
    {
        return json_decode($json);
    }

    public static function convertData(mixed $data)
    {
        /*   if (!is_array($data)) {
            return $data;
        } */

        if ($data instanceof Entity) {
            // Se for um único objeto Entity
            $data = $data->getAtributes();
        } elseif (is_array($data)) {
            // Se for um array, mapeia normalmente
            $data = array_map(function ($value) {
                if ($value instanceof Entity) {
                    return $value->getAtributes();
                }

                return $value;
            }, $data);
        }

        return $data;
    }

    public static function data()
    {

        // Obtém o corpo da requisição como uma string
        $data = sanitizeInput(json_decode(file_get_contents("php://input"), true));;
        // Decodifica a string JSON em um objeto PHP
        return $data;
    }
}
