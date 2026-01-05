<?php

namespace App\classes;

class Password
{
    public static function generate($complexiblity, $size = 12)
    {
        // Definindo caracteres para diferentes níveis de complexidade
        $niveis = [
            'abcdefghijklmnopqrstuvwxyz',                         // Nível 1: Apenas letras minúsculas
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', // Nível 2: Letras minúsculas e maiúsculas
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', // Nível 3: Letras e números
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()', // Nível 4: Letras, números e caracteres especiais
        ];


        // Limita o nível de complexidade ao número de níveis disponíveis
        $caracteres = $niveis[min($complexiblity - 1, count($niveis) - 1)];
        $hash = '';

        // Gera a hash com o conjunto de caracteres do nível de complexidade escolhido
        for ($i = 0; $i < $size; $i++) {
            $hash .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }

        return $hash;
    }

    public static function hash($password)
    {
        return password_hash((string) $password, PASSWORD_DEFAULT);
    }

    public static function verify($password, $hash)
    {
        return password_verify((string) $password, (string) $hash);
    }
}
