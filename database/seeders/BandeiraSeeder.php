<?php

namespace Database\Seeders;

use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use Illuminate\Database\Seeder;

class BandeiraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupo1 = GrupoEconomico::where('nome', 'Grupo Varejo Brasil')->first();
        $grupo2 = GrupoEconomico::where('nome', 'Grupo Alimentício Nacional')->first();
        $grupo3 = GrupoEconomico::where('nome', 'Grupo Tecnologia Inovação')->first();

        $bandeiras = [
            ['nome' => 'Supermercado Central', 'grupo_economico_id' => $grupo1?->id],
            ['nome' => 'Hipermercado Plus', 'grupo_economico_id' => $grupo1?->id],
            ['nome' => 'Restaurante Sabor', 'grupo_economico_id' => $grupo2?->id],
            ['nome' => 'Padaria Doce Vida', 'grupo_economico_id' => $grupo2?->id],
            ['nome' => 'Tech Solutions', 'grupo_economico_id' => $grupo3?->id],
            ['nome' => 'Software House Pro', 'grupo_economico_id' => $grupo3?->id],
        ];

        foreach ($bandeiras as $bandeira) {
            if ($bandeira['grupo_economico_id']) {
                Bandeira::firstOrCreate(
                    ['nome' => $bandeira['nome']],
                    $bandeira
                );
            }
        }
    }
}



