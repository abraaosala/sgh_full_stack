<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePrescricoes extends AbstractMigration
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
  $table = $this->table('prescricoes');
    $table->addColumn('id_consulta', 'integer')
          ->addColumn('medicamento', 'string', ['limit' => 100])
          ->addColumn('dosagem', 'string', ['limit' => 50])
          ->addColumn('frequencia', 'string', ['limit' => 50])
          // ->addForeignKey('id_consulta', 'consultas', 'id')
          ->create();
    }
}
