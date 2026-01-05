<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePacientes extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
$table = $this->table('pacientes');
    $table->addColumn('nome', 'string', ['limit' => 100])
          ->addColumn('data_nascimento', 'date')
          ->addColumn('sexo', 'enum', ['values' => ['M', 'F']])
          ->addColumn('cpf', 'string', ['limit' => 14])
          ->addColumn('telefone', 'string', ['limit' => 20])
          ->addColumn('endereco', 'string', ['limit' => 255])
          ->addColumn('historico_respiratorio', 'text')
          ->create();
    }
}
