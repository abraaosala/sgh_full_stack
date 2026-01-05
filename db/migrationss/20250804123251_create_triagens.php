<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTriagens extends AbstractMigration
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
 $table = $this->table('triagens');
    $table->addColumn('id_paciente', 'integer')
          ->addColumn('data', 'datetime')
          ->addColumn('saturacao', 'float')
          ->addColumn('frequencia_respiratoria', 'integer')
          ->addColumn('classificacao_risco', 'string', ['limit' => 50])
        //   ->addForeignKey('id_paciente', 'pacientes', 'id')
          ->create();
    }
}
