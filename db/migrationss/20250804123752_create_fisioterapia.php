<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateFisioterapia extends AbstractMigration
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
        $table = $this->table('fisioterapia');
        $table->addColumn('id_paciente', 'integer')
            ->addColumn('data', 'datetime')
            ->addColumn('tecnica_aplicada', 'string', ['limit' => 100])
            ->addColumn('observacoes', 'text', ['null' => true])
            // ->addForeignKey('id_paciente', 'pacientes', 'id')
            ->create();
    }
}
