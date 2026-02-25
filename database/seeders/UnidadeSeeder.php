<?php

namespace Database\Seeders;

use App\Models\Bandeira;
use App\Models\Unidade;
use Illuminate\Database\Seeder;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bandeira1 = Bandeira::where('nome', 'Supermercado Central')->first();
        $bandeira2 = Bandeira::where('nome', 'Hipermercado Plus')->first();
        $bandeira3 = Bandeira::where('nome', 'Restaurante Sabor')->first();
        $bandeira4 = Bandeira::where('nome', 'Tech Solutions')->first();

        $unidades = [
            [
                'nome_fantasia' => 'Supermercado Central - Filial Centro',
                'razao_social' => 'Supermercado Central Centro Ltda',
                'cnpj' => '12.345.678/0001-90',
                'bandeira_id' => $bandeira1?->id,
            ],
            [
                'nome_fantasia' => 'Supermercado Central - Filial Norte',
                'razao_social' => 'Supermercado Central Norte Ltda',
                'cnpj' => '12.345.678/0002-71',
                'bandeira_id' => $bandeira1?->id,
            ],
            [
                'nome_fantasia' => 'Hipermercado Plus - Shopping',
                'razao_social' => 'Hipermercado Plus Shopping Ltda',
                'cnpj' => '23.456.789/0001-82',
                'bandeira_id' => $bandeira2?->id,
            ],
            [
                'nome_fantasia' => 'Restaurante Sabor - Unidade Principal',
                'razao_social' => 'Restaurante Sabor Principal Ltda',
                'cnpj' => '34.567.890/0001-73',
                'bandeira_id' => $bandeira3?->id,
            ],
            [
                'nome_fantasia' => 'Tech Solutions - Matriz',
                'razao_social' => 'Tech Solutions Tecnologia Ltda',
                'cnpj' => '45.678.901/0001-64',
                'bandeira_id' => $bandeira4?->id,
            ],
            [
                'nome_fantasia' => 'Tech Solutions - Filial SP',
                'razao_social' => 'Tech Solutions São Paulo Ltda',
                'cnpj' => '45.678.901/0002-55',
                'bandeira_id' => $bandeira4?->id,
            ],
        ];

        foreach ($unidades as $unidade) {
            if ($unidade['bandeira_id']) {
                Unidade::firstOrCreate(
                    ['cnpj' => $unidade['cnpj']],
                    $unidade
                );
            }
        }
    }
}



