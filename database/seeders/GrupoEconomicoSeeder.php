<?php

namespace Database\Seeders;

use App\Models\GrupoEconomico;
use Illuminate\Database\Seeder;

class GrupoEconomicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = [
            ['nome' => 'Grupo Varejo Brasil'],
            ['nome' => 'Grupo Alimentício Nacional'],
            ['nome' => 'Grupo Tecnologia Inovação'],
            ['nome' => 'Grupo Construção Civil'],
            ['nome' => 'Grupo Serviços Financeiros'],
        ];

        foreach ($grupos as $grupo) {
            GrupoEconomico::firstOrCreate(
                ['nome' => $grupo['nome']],
                $grupo
            );
        }
    }
}



