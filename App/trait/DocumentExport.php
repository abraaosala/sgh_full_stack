<?php

declare(strict_types=1);

namespace App\trait;

use App\classes\Export;
use App\export\Csv;
use App\export\Excel;
use App\export\Pdf;

trait DocumentExport
{
   public function export(array $data, string $type): void
   {
       // Lógica para exportar documentos
      switch ($type) {
         case 'pdf':

            $view = $data['view'] ?? 'reports.document';
            
            $dataView = $data['data'] ?? [];
         
            $datafinal = [
               'nome_arquivo' =>  $data['nome_arquivo'] ?? 'documento',
               'html' => $this->vcontent($dataView, $view),
               'download' => $data['download']
            ];
            // var_dump($data);
            $pdf = new Export(Pdf::class);
            $pdf->export($datafinal);
            break;
            
         case 'csv':
            $model = $data['model'] ?? [];

            // Preparar o array de dados para a exportação
            $dadosParaExportar = processarDadosParaExportacao($model);

            $nome_arquivo = $data['nome_arquivo'] ?? 'documento.csv';
            // Gerar CSV
            $data = [
               'nome_arquivo' => $nome_arquivo, // Nome do arquivo
               'dados' => $dadosParaExportar
            ];

            $exportador = new Export(Csv::class);
            $exportador->export($data);
            break;
         case 'excel':
            $nome_arquivo = $data['nome_arquivo'] ?? 'documento';


            $model = $data['model'] ?? [];

            // Preparar o array de dados para a exportação
            $dadosParaExportar = processarDadosParaExportacao($model);


            $data = [
               'nome_arquivo' => $nome_arquivo, // Nome do arquivo
               'dados' => $dadosParaExportar
            ];


            $exportador = new Export(Excel::class);
            $exportador->export($data);
            break;
         default:
              throw new \Exception(" O Tipo indefinido");
      }
     
   }
}