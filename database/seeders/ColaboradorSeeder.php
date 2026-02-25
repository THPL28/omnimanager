<?php

namespace Database\Seeders;

use App\Models\Colaborador;
use App\Models\Unidade;
use Illuminate\Database\Seeder;

class ColaboradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidade1 = Unidade::where('cnpj', '12.345.678/0001-90')->first();
        $unidade2 = Unidade::where('cnpj', '12.345.678/0002-71')->first();
        $unidade3 = Unidade::where('cnpj', '23.456.789/0001-82')->first();
        $unidade4 = Unidade::where('cnpj', '34.567.890/0001-73')->first();
        $unidade5 = Unidade::where('cnpj', '45.678.901/0001-64')->first();

        $colaboradores = [
            [
                'nome' => 'João Silva',
                'email' => 'joao.silva@example.com',
                'cpf' => '123.456.789-00',
                'unidade_id' => $unidade1?->id,
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria.santos@example.com',
                'cpf' => '234.567.890-11',
                'unidade_id' => $unidade1?->id,
            ],
            [
                'nome' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@example.com',
                'cpf' => '345.678.901-22',
                'unidade_id' => $unidade2?->id,
            ],
            [
                'nome' => 'Ana Costa',
                'email' => 'ana.costa@example.com',
                'cpf' => '456.789.012-33',
                'unidade_id' => $unidade2?->id,
            ],
            [
                'nome' => 'Carlos Pereira',
                'email' => 'carlos.pereira@example.com',
                'cpf' => '567.890.123-44',
                'unidade_id' => $unidade3?->id,
            ],
            [
                'nome' => 'Fernanda Lima',
                'email' => 'fernanda.lima@example.com',
                'cpf' => '678.901.234-55',
                'unidade_id' => $unidade3?->id,
            ],
            [
                'nome' => 'Roberto Alves',
                'email' => 'roberto.alves@example.com',
                'cpf' => '789.012.345-66',
                'unidade_id' => $unidade4?->id,
            ],
            [
                'nome' => 'Juliana Ferreira',
                'email' => 'juliana.ferreira@example.com',
                'cpf' => '890.123.456-77',
                'unidade_id' => $unidade4?->id,
            ],
            [
                'nome' => 'Lucas Martins',
                'email' => 'lucas.martins@example.com',
                'cpf' => '901.234.567-88',
                'unidade_id' => $unidade5?->id,
            ],
            [
                'nome' => 'Patricia Rocha',
                'email' => 'patricia.rocha@example.com',
                'cpf' => '012.345.678-99',
                'unidade_id' => $unidade5?->id,
            ],
        ];

        foreach ($colaboradores as $colaborador) {
            if ($colaborador['unidade_id']) {
                Colaborador::firstOrCreate(
                    ['email' => $colaborador['email']],
                    $colaborador
                );
            }
        }
    }
}



