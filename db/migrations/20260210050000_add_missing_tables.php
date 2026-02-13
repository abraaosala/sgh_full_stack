<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddMissingTables extends AbstractMigration
{
    public function change(): void
    {
        // Tabela Funcionários
        if (!$this->hasTable('funcionarios')) {
            $funcionarios = $this->table('funcionarios', ['id' => true, 'primary_key' => ['id']]);
            $funcionarios->addColumn('usuario_id', 'integer', ['signed' => false])
                ->addColumn('numero_ordem', 'string', ['limit' => 50])
                ->addColumn('nivel', 'enum', ['values' => ['Generalista', 'Especialista', 'Interno'], 'null' => true])
                ->addColumn('hospital', 'string', ['limit' => 100, 'null' => true])
                ->addColumn('provincia_id', 'integer', ['null' => true, 'signed' => false])
                ->addColumn('telefone', 'string', ['limit' => 30, 'null' => true])
                ->addForeignKey('usuario_id', 'usuarios', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->addForeignKey('provincia_id', 'provincias', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                ->create();
        }

        // Tabela Exames
        if (!$this->hasTable('exames')) {
            $exames = $this->table('exames', ['id' => true, 'primary_key' => ['id']]);
            $exames->addColumn('paciente_id', 'integer', ['signed' => false])
                ->addColumn('medico_id', 'integer', ['signed' => false])
                ->addColumn('tipo', 'string', ['limit' => 100, 'null' => true])
                ->addColumn('resultado', 'text', ['null' => true])
                ->addColumn('data_exame', 'date', ['null' => true])
                ->addForeignKey('paciente_id', 'pacientes', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->addForeignKey('medico_id', 'medicos', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();
        }
    }
}
