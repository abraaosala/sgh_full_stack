<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitialSchema extends AbstractMigration
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
        // Desativar chaves estrangeiras para permitir DROP TABLE limpo
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');

        $tables = [
            'exames',
            'leitos',
            'funcionarios',
            'historicos_clinicos',
            'estados_clinicos',
            'tratamentos',
            'diagnosticos',
            'consultas',
            'agendas',
            'pacientes',
            'medicos',
            'usuarios',
            'doencas_respiratorias',
            'provincias',
            'especialidades'
        ];

        foreach ($tables as $table) {
            $this->table($table)->drop()->save();
        }

        // Tabela Especialidades
        $especialidades = $this->table('especialidades', ['id' => true, 'primary_key' => ['id']]);
        $especialidades->addColumn('nome', 'string', ['limit' => 100])
            ->create();

        // Tabela Provincias
        $provincias = $this->table('provincias', ['id' => true, 'primary_key' => ['id']]);
        $provincias->addColumn('nome', 'string', ['limit' => 100])
            ->create();

        // Tabela Doenças Respiratórias
        $doencas = $this->table('doencas_respiratorias', ['id' => true, 'primary_key' => ['id']]);
        $doencas->addColumn('nome', 'string', ['limit' => 100])
            ->addColumn('descricao', 'text', ['null' => true])
            ->addColumn('icon', 'string', ['limit' => 50, 'null' => true])
            ->create();

        // Tabela Usuarios
        $usuarios = $this->table('usuarios', ['id' => true, 'primary_key' => ['id']]);
        $usuarios->addColumn('nome', 'string', ['limit' => 100])
            ->addColumn('genero', 'enum', ['values' => ['M', 'F', 'O']])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('data_nascimento', 'date', ['null' => true])
            ->addColumn('senha', 'string', ['limit' => 255])
            ->addColumn('senha_gerada', 'integer', ['limit' => \Phinx\Db\Adapter\MysqlAdapter::INT_TINY, 'null' => true])
            ->addColumn('perfil', 'enum', ['values' => ['superadmin', 'admin', 'medico', 'paciente', 'enfermeiro', 'recepcionista']])
            ->addColumn('criado_em', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['email'], ['unique' => true])
            ->create();

        // Tabela Medicos
        $medicos = $this->table('medicos', ['id' => true, 'primary_key' => ['id']]);
        $medicos->addColumn('usuario_id', 'integer', ['signed' => false])
            ->addColumn('especialidade_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('numero_ordem', 'string', ['limit' => 50])
            ->addColumn('nivel', 'enum', ['values' => ['Generalista', 'Especialista', 'Interno']])
            ->addColumn('hospital', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('provincia_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('telefone', 'string', ['limit' => 30, 'null' => true])
            ->addForeignKey('usuario_id', 'usuarios', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('especialidade_id', 'especialidades', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('provincia_id', 'provincias', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();

        // Tabela Pacientes
        $pacientes = $this->table('pacientes', ['id' => true, 'primary_key' => ['id']]);
        $pacientes->addColumn('usuario_id', 'integer', ['signed' => false])
            ->addColumn('code', 'string', ['limit' => 10, 'null' => true])
            ->addColumn('telefone', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('endereco', 'text', ['null' => true])
            ->addColumn('provincia_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('criado_em', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['code'], ['unique' => true])
            ->addForeignKey('usuario_id', 'usuarios', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('provincia_id', 'provincias', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();

        // Tabela Agendas
        $agendas = $this->table('agendas', ['id' => true, 'primary_key' => ['id']]);
        $agendas->addColumn('medico_id', 'integer', ['signed' => false])
            ->addColumn('title', 'string', ['limit' => 244])
            ->addColumn('color', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('start', 'datetime')
            ->addColumn('end', 'datetime')
            ->addColumn('create_time', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['medico_id'])
            ->addIndex(['start'])
            ->addForeignKey('medico_id', 'medicos', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();

        // Tabela Consultas
        $consultas = $this->table('consultas', ['id' => true, 'primary_key' => ['id']]);
        $consultas->addColumn('paciente_id', 'integer', ['signed' => false])
            ->addColumn('medico_id', 'integer', ['signed' => false])
            ->addColumn('agenda_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('marcacao', 'datetime')
            ->addColumn('motivo', 'text', ['null' => true])
            ->addColumn('observacao', 'text', ['null' => true])
            ->addColumn('status', 'enum', ['values' => ['Agendada', 'Realizada', 'Cancelada'], 'default' => 'Agendada'])
            ->addColumn('criado_em', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['marcacao'], ['unique' => true])
            ->addForeignKey('paciente_id', 'pacientes', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('medico_id', 'medicos', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('agenda_id', 'agendas', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();

        // Tabela Diagnósticos
        $diagnosticos = $this->table('diagnosticos', ['id' => true, 'primary_key' => ['id']]);
        $diagnosticos->addColumn('paciente_id', 'integer', ['signed' => false])
            ->addColumn('medico_id', 'integer', ['signed' => false])
            ->addColumn('doenca_id', 'integer', ['signed' => false])
            ->addColumn('data_diagnostico', 'date')
            ->addColumn('observacoes', 'text', ['null' => true])
            ->addForeignKey('paciente_id', 'pacientes', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('medico_id', 'medicos', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('doenca_id', 'doencas_respiratorias', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();

        // Tabela Tratamentos
        $tratamentos = $this->table('tratamentos', ['id' => true, 'primary_key' => ['id']]);
        $tratamentos->addColumn('diagnostico_id', 'integer', ['signed' => false])
            ->addColumn('descricao', 'text')
            ->addColumn('data_inicio', 'date', ['null' => true])
            ->addColumn('data_fim', 'date', ['null' => true])
            ->addForeignKey('diagnostico_id', 'diagnosticos', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();

        // Tabela Estados Clínicos
        $estados = $this->table('estados_clinicos', ['id' => true, 'primary_key' => ['id']]);
        $estados->addColumn('paciente_id', 'integer', ['signed' => false])
            ->addColumn('estado_atual', 'text')
            ->addColumn('data_atualizacao', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();

        // Tabela Históricos Clínicos
        $historicos = $this->table('historicos_clinicos', ['id' => true, 'primary_key' => ['id']]);
        $historicos->addColumn('paciente_id', 'integer', ['signed' => false])
            ->addColumn('descricao', 'text')
            ->addColumn('data_registro', 'date')
            ->addForeignKey('paciente_id', 'pacientes', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();

        // Reativar chaves estrangeiras
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
