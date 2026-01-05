<?php
namespace App\export;

use App\contracts\DocumentExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv as WCsv;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;

class Csv implements DocumentExport
{

    private string $nomeArquivo;

    private const string EXTENSAO= '.csv';

    // Defina um nome temporário para o arquivo ou o diretório de exportação no servidor
    private string $caminhoPadrao = STORE_PATH;

    /**
     * Exporta os dados para um arquivo CSV usando PhpSpreadsheet.
     *
     * @param array $dadosArray Um array que contém a chave 'nome_arquivo' e os dados.
     * @throws \InvalidArgumentException Se a estrutura do array estiver incorreta.
     * @throws WriterException Se houver um erro ao salvar o arquivo.
     */
    public function exportar(array $dadosArray): void
    {
        // Validar e extrair o nome do arquivo
        if (!isset($dadosArray['nome_arquivo']) || !is_string($dadosArray['nome_arquivo'])) {
            throw new \InvalidArgumentException('A chave "nome_arquivo" com um valor string é obrigatória no array de dados.');
        }

        // Combina o caminho padrão com o nome do arquivo fornecido
        $nomeArquivoCompleto = $this->caminhoPadrao . $dadosArray['nome_arquivo'];

        // CORREÇÃO: use array_values() para garantir que os dados tenham índices numéricos
        $dadosReais = array_values($dadosArray['dados']);

        // Validar se os dados reais existem e não estão vazios
        if ($dadosReais === []) {
            throw new \InvalidArgumentException('O array de dados para exportação não pode estar vazio.');
        }

        $this->setNomeArquivo($nomeArquivoCompleto);

        // Criar um novo objeto Spreadsheet e a aba de trabalho
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Usar o método fromArray para adicionar os dados de forma eficiente
        try {
            $sheet->fromArray($dadosReais, null, 'A1');
        } catch (\PhpOffice\PhpSpreadsheet\Exception $exception) {
            throw new \InvalidArgumentException('Formato de dados inválido: ' . $exception->getMessage(), $exception->getCode(), $exception);
        }

        // Criar o objeto Writer para o formato CSV com alias WCsv
        $writer = new WCsv($spreadsheet);

        // Enviar o arquivo para o navegador
        try {
            // Cabeçalhos para forçar o download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . basename($this->nomeArquivo) . '"');
            header('Pragma: no-cache');
            header('Expires: 0');

            // Abrir o fluxo de saída do PHP
            $writer->save('php://output');
            exit;
        } catch (WriterException $writerException) {
            throw new WriterException('Não foi possível gerar o arquivo: ' . $writerException->getMessage());
        }
    }

    // Método privado para definir e formatar o nome do arquivo.
    public function setNomeArquivo(string $nome): void
    {
        // Adiciona a extensão se ela não existir.
        if (pathinfo($nome, PATHINFO_EXTENSION) !== 'csv') {
            $nome .= self::EXTENSAO;
        }

        $this->nomeArquivo = $nome;
    }
}