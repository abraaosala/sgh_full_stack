<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class FakeDataSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['AdminSeeder', 'ProvinciasSeeder', 'DoencasSeeder', 'EspecialidadesSeeder'];
    }

    public function run(): void
    {
        $faker = null;
        if (class_exists('Faker\Factory')) {
            $faker = Faker\Factory::create('pt_PT');
        }

        // --- Limpar Tabelas que dependem de usuários ---
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->execute('DELETE FROM tratamentos');
        $this->execute('DELETE FROM diagnosticos');
        $this->execute('DELETE FROM consultas');
        $this->execute('DELETE FROM agendas');
        $this->execute('DELETE FROM exames');
        $this->execute('DELETE FROM medicos');
        $this->execute('DELETE FROM pacientes');
        // Manter administradores inseridos pelo AdminSeeder
        $this->execute('DELETE FROM usuarios WHERE perfil NOT IN ("superadmin", "admin")');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');

        // --- Usuários Adicionais ---
        $usuarios = [];
        $perfis = ['medico', 'paciente', 'enfermeiro', 'recepcionista'];
        
        for ($i = 0; $i < 20; $i++) {
            $perfil = $perfis[array_rand($perfis)];
            $usuarios[] = [
                'nome' => $faker ? $faker->name : "Falso Usuário " . ($i + 1),
                'genero' => ['M', 'F'][rand(0, 1)],
                'email' => $faker ? $faker->unique()->email : "user_fake_" . bin2hex(random_bytes(4)) . "@sgh.com",
                'data_nascimento' => $faker ? $faker->date('Y-m-d', '2005-01-01') : '1990-01-01',
                'senha' => password_hash('password', PASSWORD_BCRYPT),
                'perfil' => $perfil,
                'criado_em' => date('Y-m-d H:i:s')
            ];
        }
        $this->table('usuarios')->insert($usuarios)->saveData();

        // Recuperar IDs inseridos
        $all_users = $this->fetchAll('SELECT id, perfil FROM usuarios');
        $medico_ids = array_column(array_filter($all_users, fn($u) => $u['perfil'] === 'medico'), 'id');
        $paciente_ids = array_column(array_filter($all_users, fn($u) => $u['perfil'] === 'paciente'), 'id');

        // Buscar IDs de províncias e especialidades
        $prov_ids = array_column($this->fetchAll('SELECT id FROM provincias'), 'id');
        $esp_ids = array_column($this->fetchAll('SELECT id FROM especialidades'), 'id');

        // --- Médicos ---
        $medicos_data = [];
        foreach ($medico_ids as $uid) {
            $medicos_data[] = [
                'usuario_id' => $uid,
                'especialidade_id' => $esp_ids[array_rand($esp_ids)],
                'numero_ordem' => "ORD-" . rand(1000, 9999),
                'nivel' => ['Generalista', 'Especialista', 'Interno'][rand(0, 2)],
                'hospital' => 'Hospital Central de Luanda',
                'provincia_id' => $prov_ids[array_rand($prov_ids)],
                'telefone' => '9' . rand(10000000, 99999999)
            ];
        }
        $this->table('medicos')->insert($medicos_data)->saveData();
        
        $medico_db_ids = array_column($this->fetchAll('SELECT id FROM medicos'), 'id');

        // --- Pacientes ---
        $pacientes_data = [];
        foreach ($paciente_ids as $uid) {
            $pacientes_data[] = [
                'usuario_id' => $uid,
                'code' => strtoupper(substr(md5((string)$uid), 0, 8)),
                'telefone' => '9' . rand(10000000, 99999999),
                'endereco' => $faker ? $faker->address : "Bairro da Paz, Casa " . rand(1, 100),
                'provincia_id' => $prov_ids[array_rand($prov_ids)],
                'criado_em' => date('Y-m-d H:i:s')
            ];
        }
        $this->table('pacientes')->insert($pacientes_data)->saveData();
        
        $paciente_db_ids = array_column($this->fetchAll('SELECT id FROM pacientes'), 'id');

        // --- Leitos ---
        $this->execute('DELETE FROM leitos');
        $leitos = [];
        for ($i = 1; $i <= 10; $i++) {
            $leitos[] = [
                'numero' => "L-" . str_pad((string)$i, 3, '0', STR_PAD_LEFT),
                'tipo' => ['Enfermaria', 'UTI', 'Privado', 'Isolamento'][rand(0, 3)],
                'status' => 'Disponível',
                'descricao' => "Leito de demonstração $i",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        $this->table('leitos')->insert($leitos)->saveData();

        // --- Agendas ---
        $agendas = [];
        if (!empty($medico_db_ids)) {
            for ($i = 1; $i <= 20; $i++) {
                $mid = $medico_db_ids[array_rand($medico_db_ids)];
                $start = date('Y-m-d H:i:s', strtotime("+" . rand(1, 10) . " days " . rand(8, 16) . ":00:00"));
                $end = date('Y-m-d H:i:s', strtotime($start . " +4 hours"));
                $agendas[] = [
                    'medico_id' => $mid,
                    'title' => 'Turno de Atendimento',
                    'color' => '#' . str_pad(dechex(rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                    'start' => $start,
                    'end' => $end,
                    'create_time' => date('Y-m-d H:i:s')
                ];
            }
            $this->table('agendas')->insert($agendas)->saveData();
        }
    }
}
