<?php

declare(strict_types=1);

namespace App\contracts;

interface DocumentExport
{
    /**
     * Define o método de exportação.
     *
     * @param array $data Os dados a serem exportados.
     * @return string O caminho ou o conteúdo do arquivo gerado.
     */
    public function exportar(array $data): void ;

    
}