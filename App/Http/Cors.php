<?php

declare(strict_types=1);
/**
 * Classe utilitária para lidar com cabeçalhos HTTP, especialmente CORS.
 */

namespace App\Http;

class Cors
{
    private array $dominEnable;

    private array $methods;

    // private array $origin;
    private array $headers;

    public function setDomin(array|string $value):void
    {
        if (is_array($value)) {
            $this->dominEnable = $value;
        }

         $this->dominEnable[] = $value;    



    }

    public function getDomin():array{
        return $this->dominEnable;
    }

    public function setMethod(array|string $value):void
    {
        if (is_array($value)) {
            $this->methods = $value;
        }

         $this->methods[] = $value;    

    }

    public function getMethod():string
    {
        return implode(',', $this->methods)??'GET, POST, PUT, DELETE, OPTIONS, PATCH';

    }

    public function getOrigin():string
    {
        return implode(',', $this->dominEnable)??'*';
    }

    public function setHeader(array|string $value):void
    {
        if (is_array($value)) {
            $this->headers = $value;
        }

         $this->headers[] = $value;    

    }

    public function getHeader():string
    {
        return implode(',', $this->headers)??'Content-Type, Authorization, X-Requested-With';

    }

    public function setMaxAge(string $value): void
    {
    }

    public function getMaxAge():string
    {
        return $this->getMaxAge()??86400;         
    }


    public function send()
    {
        //Habilitar Cors
        header('Access-Control-Allow-Origin: ' . $this->getOrigin());



        // Define métodos e cabeçalhos comuns permitidos
        header('Access-Control-Allow-Methods: ' . $this->getMethod());
        header('Access-Control-Allow-Headers: ' . $this->getHeader());



        // Define o tempo de cache (preflight)
        header('Access-Control-Max-Age: ' . $this->getMaxAge()); // 24 horas padrao

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            // Define o código 204 No Content (padrão para preflight, mas 200 também funciona)
            http_response_code(204); 

            // Encerra o script após enviar os headers CORS.
            exit(); 
        }
    }
   
    

    
    
}