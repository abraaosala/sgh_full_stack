<?php

namespace App\classes;

use Exception;

class FileManager
{
    private $directory;

    private $file;

    public function __construct($directory = 'store', $file = 'credencials.json')
    {
        // Garante que a extensão seja .json
        if (strtolower(substr((string) $file, -5)) !== '.json') {
            $file .= '.json';
        }

        $this->directory = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $directory;
        $this->file = $this->directory . DIRECTORY_SEPARATOR . $file;

        $this->initialize();
    }

    /**
     * Inicializa o diretório e o arquivo, caso não existam.
     */
    private function initialize()
    {
        if (!is_dir($this->directory) && (!mkdir($this->directory, 0777, true) && !is_dir($this->directory))) {
            throw new Exception('Falha ao criar o diretório: ' . $this->directory);
        }

        if (!file_exists($this->file) && file_put_contents($this->file, json_encode([])) === false) {
            throw new Exception('Falha ao criar o arquivo: ' . $this->file);
        }
    }

    /**
     * Verifica se um item existe com base em uma chave e valor.
     */
    public function exists($key, $value)
    {
        $content = $this->read();

        foreach ($content as $item) {
            if (isset($item[$key]) && $item[$key] === $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Lê o conteúdo do arquivo e retorna como um array.
     */
    public function read()
    {
        $content = file_get_contents($this->file);
        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Erro ao decodificar JSON: " . json_last_error_msg());
        }

        return $decoded;
    }

    /**
     * Adiciona um novo item ao arquivo, verificando duplicatas.
     */
    public function add(array $data, $uniqueKey = 'email')
    {
        $content = $this->read();

        // Verifica duplicata com base no valor de $uniqueKey
        foreach ($content as $item) {
            if (isset($item[$uniqueKey]) && $item[$uniqueKey] === $data[$uniqueKey]) {
                throw new Exception(sprintf("O item com chave '%s' já existe.", $uniqueKey));
            }
        }

        $content[] = $data;
        $this->write($content);

        return "Item adicionado com sucesso!";
    }

    /**
     * Escreve um array completo no arquivo, substituindo o conteúdo atual.
     */
    public function write(array $data)
    {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Remove um item do arquivo com base em uma chave única.
     */
    public function delete($key, $value)
    {
        $content = $this->read();

        $filtered = array_filter($content, fn($item) => !isset($item[$key]) || $item[$key] !== $value);

        if (count($filtered) === count($content)) {
            throw new Exception(sprintf("Nenhum item encontrado para excluir com '%s' igual a '%s'.", $key, $value));
        }

        $this->write(array_values($filtered)); // Reindexa o array
        return "Item removido com sucesso!";
    }

    /**
     * Atualiza um item do arquivo com base em uma chave única.
     */
    public function update($key, $value, array $newData)
    {
        $content = $this->read();
        $updated = false;

        foreach ($content as &$item) {
            if (isset($item[$key]) && $item[$key] === $value) {
                $item = array_merge($item, $newData);
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            throw new Exception(sprintf("Nenhum item encontrado para atualizar com '%s' igual a '%s'.", $key, $value));
        }

        $this->write($content);
        return "Item atualizado com sucesso!";
    }
}
