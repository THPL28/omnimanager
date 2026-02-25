<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\GrupoEconomico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Executar seeders na ordem correta (respeitando dependências)
        $this->call([
            GrupoEconomicoSeeder::class,
            BandeiraSeeder::class,
            UnidadeSeeder::class,
            ColaboradorSeeder::class,
        ]);

        // Criar usuários para login
        $grupoAdmin = GrupoEconomico::where('nome', 'Grupo Varejo Brasil')->first();
        $grupoUser = GrupoEconomico::where('nome', 'Grupo Alimentício Nacional')->first();

        // Usuário Administrador
        User::firstOrCreate(
            ['email' => 'admin@gestao.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@gestao.com',
                'password' => Hash::make('password'),
                'grupo_economico_id' => $grupoAdmin?->id,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Usuário Gerente
        User::firstOrCreate(
            ['email' => 'gerente@gestao.com'],
            [
                'name' => 'Gerente',
                'email' => 'gerente@gestao.com',
                'password' => Hash::make('password'),
                'grupo_economico_id' => $grupoAdmin?->id,
                'role' => 'manager',
                'email_verified_at' => now(),
            ]
        );

        // Usuário Comum
        User::firstOrCreate(
            ['email' => 'usuario@gestao.com'],
            [
                'name' => 'Usuário',
                'email' => 'usuario@gestao.com',
                'password' => Hash::make('password'),
                'grupo_economico_id' => $grupoUser?->id,
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Usuário de Teste (sem grupo)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'grupo_economico_id' => null,
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}
