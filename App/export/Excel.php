<?php

declare(strict_types=1);

namespace App\export;

use App\contracts\DocumentExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;

class Excel implements DocumentExport
{
    private const string EXTENSAO = '.xlsx';

    /**
     * Exporta os dados para um arquivo Excel (.xlsx) e força o download no navegador.
     *
     * @param array $data O array de dados com as chaves 'nome_arquivo' e 'dados'.
     * Exemplo: ['nome_arquivo' => 'relatorio', 'dados' => [['Header1'], ['Valor1']]]
     * @throws \InvalidArgumentException Se a estrutura do array de dados for inválida.
     * @throws WriterException Se houver um problema ao salvar o arquivo.
     */
    public function exportar(array $data): void
    {
        // Validar e extrair o nome do arquivo e os dados
        if (!isset($data['nome_arquivo']) || !is_string($data['nome_arquivo'])) {
            throw new \InvalidArgumentException('A chave "nome_arquivo" é obrigatória e deve ser uma string.');
        }

        if (!isset($data['dados']) || !is_array($data['dados'])) {
            throw new \InvalidArgumentException('A chave "dados" é obrigatória e deve ser um array.');
        }

        $nomeArquivo = $data['nome_arquivo'] . self::EXTENSAO;
        $dadosPlanilha = $data['dados'];

        // Criar e preencher a planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        try {
            $sheet->fromArray($dadosPlanilha, null, 'A1');
        } catch (\PhpOffice\PhpSpreadsheet\Exception $exception) {
            throw new \InvalidArgumentException('Formato de dados inválido: ' . $exception->getMessage(), $exception->getCode(), $exception);
        }

        // Configurar o "escritor" e os cabeçalhos HTTP para o download
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nomeArquivo . '"');
        header('Cache-Control: max-age=0');
        
        // Salvar o arquivo diretamente na saída do navegador e encerrar
        try {
            $writer->save('php://output');
        } catch (WriterException $writerException) {
            // É crucial tratar exceções do escritor
            throw new WriterException('Não foi possível salvar o arquivo Excel: ' . $writerException->getMessage());
        }

        exit();
    }

     
}