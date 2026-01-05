<?php

declare(strict_types=1);

namespace App\classes;

use App\contracts\DocumentExport;

class Export
{

    public function __construct(private  $exporter)
    {
       
        
        $this->exporter = new $exporter();

         if(!$this->exporter instanceof DocumentExport){
            throw new \Exception(sprintf('Class %s is not type of DocumentExport', $exporter));
        }
    }
    
    public function export(array $data): void
    {
         $this->exporter->exportar($data);
    }
}