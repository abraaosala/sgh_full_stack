<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class EspecialidadesSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->execute('DELETE FROM especialidades');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');

        $data = [
            ['nome' => 'Pneumologia'], // Especialista principal
            ['nome' => 'Imunoalergologia'], // Asma e alergias
            ['nome' => 'Otorrinolaringologia'], // Vias aéreas superiores
            ['nome' => 'Infectologia'], // Tuberculose, Pneumonias
            ['nome' => 'Clínica Geral'], // Triagem
            ['nome' => 'Pediatria'], // Doenças respiratórias infantis
            ['nome' => 'Fisioterapia Respiratória'], // Reabilitação
            ['nome' => 'Cardiologia'], // Comorbidades
            ['nome' => 'Oncologia'], // Câncer de pulmão
            ['nome' => 'Cirurgia Torácica'],
        ];

        $table = $this->table('especialidades');
        $table->insert($data)
            ->saveData();
    }
}
