<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AdminSeeder extends AbstractSeed
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
        $this->execute('DELETE FROM usuarios');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
        
        $data = [
            [
                'nome'    => 'Abraão Sala',
                'genero'  => 'M',
                'email'   => 'admin@sgh.com',
                'data_nascimento' => '1990-10-28',
                'senha'   => password_hash('super123', PASSWORD_BCRYPT),
                'perfil'  => 'superadmin',
                'criado_em' => '2025-09-21 17:16:39'
            ],
            [
                'nome'    => 'Ana Diko',
                'genero'  => 'F',
                'email'   => 'anadiiko@gmail.com',
                'data_nascimento' => '2000-09-28',
                'senha'   => password_hash('admin123', PASSWORD_BCRYPT),
                'perfil'  => 'admin',
                'criado_em' => '2025-09-22 04:13:22'
            ]
        ];

        $posts = $this->table('usuarios');
        $posts->insert($data)
            ->saveData();
    }
}
