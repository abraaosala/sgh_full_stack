<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class DoencasSeeder extends AbstractSeed
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
        $this->execute('DELETE FROM doencas_respiratorias');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');

        $data = [
            [
                'nome' => 'Asma',
                'descricao' => 'Doença inflamatória crônica das vias aéreas que causa dificuldade em respirar.',
                'icon' => 'wind'
            ],
            [
                'nome' => 'Pneumonia',
                'descricao' => 'Infecção que inflama os sacos de ar em um ou ambos os pulmões.',
                'icon' => 'activity'
            ],
            [
                'nome' => 'Tuberculose',
                'descricao' => 'Doença infecciosa grave que afeta principalmente os pulmões.',
                'icon' => 'alert-triangle'
            ],
            [
                'nome' => 'Bronquite',
                'descricao' => 'Inflamação do revestimento dos brônquios, que transportam ar de e para os pulmões.',
                'icon' => 'thermometer'
            ],
            [
                'nome' => 'DPOC',
                'descricao' => 'Doença Pulmonar Obstrutiva Crônica, grupo de doenças pulmonares que bloqueiam o fluxo de ar.',
                'icon' => 'x-octagon'
            ],
            [
                'nome' => 'Rinite Alérgica',
                'descricao' => 'Reação alérgica que causa coceira, olhos lacrimejantes, espirros e outros sintomas.',
                'icon' => 'feather'
            ],
            [
                'nome' => 'Sinusite',
                'descricao' => 'Inflamação ou inchaço do tecido que reveste os seios da face.',
                'icon' => 'frown'
            ],
            [
                'nome' => 'Gripe (Influenza)',
                'descricao' => 'Infecção viral que ataca o sistema respiratório.',
                'icon' => 'thermometer'
            ],
            [
                'nome' => 'COVID-19',
                'descricao' => 'Doença infecciosa causada pelo vírus SARS-CoV-2.',
                'icon' => 'globe'
            ],
            [
                'nome' => 'Embolia Pulmonar',
                'descricao' => 'Bloqueio em uma das artérias pulmonares nos pulmões.',
                'icon' => 'zap'
            ]
        ];

        $table = $this->table('doencas_respiratorias');
        $table->insert($data)
            ->saveData();
    }
}
