<?php

namespace App\Dao\Entity;

use App\utils\Hash;

abstract class Entity
{
    
    /** @var array<string, mixed> */
    protected array $atributes = [];

    // Set
    public function __set(string $property, mixed $value): void
    {
        $this->atributes[$property] = $value;
    }

    // Get
    public function __get(string $property): mixed
    {
        return $this->atributes[$property] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    // Retorna todos os atributos
    public function getAtributes(): array
    {
        return $this->atributes;
    }
    
    public function create(){
        return (new static ());
    }
    /**
     * Preenche os atributos da entidade a partir de um array ou objeto.
     *
     * Exemplos:
     *   $entity->fill($data);
     *   $entity->fill($data, ['id','name']); // somente esses campos
     *
     * @param array<string,mixed>|object $data Dados de entrada
     * @param array<int,string>|null $allowed Lista branca de campos permitidos (null = todos)
     * @param bool $overwrite Se false, não sobrescreve atributos já definidos
     * @return $this
     */
    public function fill(array|object $data, ?array $allowed = null, bool $overwrite = true): static
    {
        if (isset($data['senha'])) {
            $data['senha']= $this->hash($data['senha']);
        }
        
        if (isset($data['password'])) {
            $data['password']= $this->hash($data['password']);
        }
        
        foreach ((array) $data as $key => $value) {
            // se houver whitelist, ignore campos não permitidos
            if ($allowed !== null && !in_array((string) $key, $allowed, true)) {
                continue;
            };

            // se não deve sobrescrever e atributo já existe, pula
            if (!$overwrite && array_key_exists($key, $this->atributes)) {
                continue;
            }

            // se já existe um Entity e o valor é array/objeto, delega fill recursivamente
            if (
                array_key_exists($key, $this->atributes)
                && $this->atributes[$key] instanceof Entity
                && (is_array($value) || is_object($value))
            ) {
                
                $this->atributes[$key]->fill($value, null, $overwrite);
                continue;
            }

            $this->atributes[$key] = $value;
        }

        return $this;
    }

    /**
     * Cria uma instância da entidade preenchida a partir de um array/objeto.
     *
     * @param array<string,mixed>|object $data
     * @param array<int,string>|null $allowed
     */
    public static function from(array|object $data, ?array $allowed = null, bool $overwrite = true): static
    {
        return $this->create->fill($data, $allowed, $overwrite);
    }
    
    public function hash($password, $alg = PASSWORD_BCRYPT)
    {
        return Hash::make($password, $alg);
    }


    
}