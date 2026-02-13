<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateLeitosTable extends AbstractMigration
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
        $table = $this->table('leitos', ['id' => true, 'primary_key' => ['id']]);
        $table->addColumn('numero', 'string', ['limit' => 50])
            ->addColumn('tipo', 'enum', ['values' => ['Enfermaria', 'UTI', 'Privado', 'Isolamento'], 'default' => 'Enfermaria'])
            ->addColumn('status', 'enum', ['values' => ['Disponível', 'Ocupado', 'Manutenção', 'Limpeza'], 'default' => 'Disponível'])
            ->addColumn('descricao', 'text', ['null' => true])
            ->addTimestamps() // created_at, updated_at
            ->create();
    }
}
