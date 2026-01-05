<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class NovaMigration extends AbstractMigration
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
 // Tabela de usuários
        if (!$this->hasTable('usuarios')) {
            $this->table('usuarios')
                ->addColumn('nome', 'string', ['limit' => 100])
                ->addColumn('email', 'string', ['limit' => 100])
                ->addColumn('senha_hash', 'string', ['limit' => 255])
                ->addColumn('perfil', 'enum', ['values' => ['admin', 'medico', 'paciente']])
                ->addColumn('criado_em', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                ->addIndex(['email'], ['unique' => true])
                ->create();
        }

        // Tabela de especialidades
        if (!$this->hasTable('especialidades')) {
            $this->table('especialidades')
                ->addColumn('nome', 'string', ['limit' => 100])
                ->create();
        }

        // Tabela de médicos
        if (!$this->hasTable('medicos')) {
            $this->table('medicos')
                ->addColumn('usuario_id', 'integer')
                ->addColumn('especialidade_id', 'integer', ['null' => true])
                ->addColumn('crm', 'string', ['limit' => 50, 'null' => true])
                ->addColumn('telefone', 'string', ['limit' => 30, 'null' => true])
                ->addForeignKey('usuario_id', 'usuarios', 'id')
                ->addForeignKey('especialidade_id', 'especialidades', 'id')
                ->create();
        }

        // Tabela de pacientes
        if (!$this->hasTable('pacientes')) {
            $this->table('pacientes')
                ->addColumn('usuario_id', 'integer', ['null' => true])
                ->addColumn('data_nascimento', 'date', ['null' => true])
                ->addColumn('sexo', 'enum', ['values' => ['masculino', 'feminino', 'outro'], 'null' => true])
                ->addColumn('telefone', 'string', ['limit' => 30, 'null' => true])
                ->addColumn('endereco', 'text', ['null' => true])
                ->addForeignKey('usuario_id', 'usuarios', 'id')
                ->create();
        }
    }
}
