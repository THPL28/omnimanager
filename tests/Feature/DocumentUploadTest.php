<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use App\Http\Livewire\DocumentCenter;
use App\Models\User;
use App\Models\Document;

class DocumentUploadTest extends TestCase
{
    public function test_user_can_upload_document_via_livewire()
    {
        Storage::fake('local');

        $group = \App\Models\GrupoEconomico::create(['nome' => 'Grupo Upload']);
        $user = User::factory()->create(['role' => 'user', 'grupo_economico_id' => $group->id]);

        $file = UploadedFile::fake()->create('doc.pdf', 100);

        Livewire::actingAs($user)
            ->test(DocumentCenter::class)
            ->set('empresa_id', $group->id)
            ->set('setor', 'Financeiro')
            ->set('descricao', 'Teste upload')
            ->set('file', $file)
            ->call('upload')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('documents', ['grupo_economico_id' => $group->id, 'setor' => 'Financeiro']);
        $doc = Document::firstWhere('grupo_economico_id', $group->id);
        $this->assertNotNull($doc->current_path);
        Storage::assertExists($doc->current_path);
    }

    public function test_user_can_upload_new_version()
    {
        Storage::fake('local');

        $group = \App\Models\GrupoEconomico::create(['nome' => 'Grupo Versao']);
        $user = User::factory()->create(['role' => 'user', 'grupo_economico_id' => $group->id]);

        // create initial document
        $doc = Document::create(['grupo_economico_id' => $group->id, 'descricao' => 'orig', 'uploaded_by' => $user->id]);
        $initialPath = "documents/{$group->id}/{$doc->id}/orig.pdf";
        Storage::put($initialPath, 'conteudo');
        $doc->update(['current_path' => $initialPath]);

        $newFile = UploadedFile::fake()->create('v2.pdf', 50);

        Livewire::actingAs($user)
            ->test(DocumentCenter::class)
            ->call('startVersion', $doc->id)
            ->set('versionFile', $newFile)
            ->call('uploadVersion', $doc->id)
            ->assertHasNoErrors();

        $doc->refresh();
        $this->assertNotEquals($initialPath, $doc->current_path);
        Storage::assertExists($doc->current_path);
    }
}
