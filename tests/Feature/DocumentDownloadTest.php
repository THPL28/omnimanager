<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentVersion;

class DocumentDownloadTest extends TestCase
{
    public function test_user_in_same_group_can_download_document()
    {
        Storage::fake('local');

        $group = \App\Models\GrupoEconomico::create(['nome' => 'Grupo Teste']);
        $user = User::factory()->create(['role' => 'user', 'grupo_economico_id' => $group->id]);

        $doc = Document::create([
            'grupo_economico_id' => $group->id,
            'descricao' => 'teste',
            'uploaded_by' => $user->id,
        ]);

        $path = "documents/{$group->id}/{$doc->id}/file.pdf";
        Storage::put($path, 'conteudo');

        $version = DocumentVersion::create([
            'document_id' => $doc->id,
            'version' => 1,
            'path' => $path,
            'mime' => 'application/pdf',
            'size' => 7,
            'uploaded_by' => $user->id,
        ]);

        $doc->update(['current_path' => $path]);

        $response = $this->actingAs($user)->get(route('documentos.download', ['document' => $doc->id]));
        $response->assertStatus(200);
    }

    public function test_user_from_other_group_cannot_download()
    {
        Storage::fake('local');

        $owner = User::factory()->create(['role' => 'user', 'grupo_economico_id' => 1]);
        $other = User::factory()->create(['role' => 'user', 'grupo_economico_id' => 2]);

        $doc = Document::create([
            'grupo_economico_id' => 1,
            'descricao' => 'teste2',
            'uploaded_by' => $owner->id,
        ]);

        $path = 'documents/1/'.$doc->id.'/file2.pdf';
        Storage::put($path, 'conteudo');

        DocumentVersion::create([
            'document_id' => $doc->id,
            'version' => 1,
            'path' => $path,
            'mime' => 'application/pdf',
            'size' => 7,
            'uploaded_by' => $owner->id,
        ]);

        $doc->update(['current_path' => $path]);

        $response = $this->actingAs($other)->get(route('documentos.download', ['document' => $doc->id]));
        $response->assertStatus(403);
    }
}
