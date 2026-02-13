<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class ProvinciasSeeder extends AbstractSeed
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
        $this->execute('DELETE FROM provincias');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');

        $data = [
            ['nome' => 'Bengo'],
            ['nome' => 'Benguela'],
            ['nome' => 'Bié'],
            ['nome' => 'Cabinda'],
            ['nome' => 'Cuando Cubango'],
            ['nome' => 'Cuanza Norte'],
            ['nome' => 'Cuanza Sul'],
            ['nome' => 'Cunene'],
            ['nome' => 'Huambo'],
            ['nome' => 'Huíla'],
            ['nome' => 'Luanda'],
            ['nome' => 'Lunda Norte'],
            ['nome' => 'Lunda Sul'],
            ['nome' => 'Malanje'],
            ['nome' => 'Moxico'],
            ['nome' => 'Namibe'],
            ['nome' => 'Uíge'],
            ['nome' => 'Zaire'],
            // Novas províncias 2025
            ['nome' => 'Icolo e Bengo'],
            ['nome' => 'Moxico Leste'],
            ['nome' => 'Cuando']
        ];

        $provincias = $this->table('provincias');
        $provincias->insert($data)
            ->saveData();
    }
}
