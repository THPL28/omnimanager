<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use App\Models\GrupoEconomico;
use App\Models\Document;
use App\Models\DocumentVersion;

class DocumentCenter extends Component
{
    use WithFileUploads, WithPagination;

    public $file;
    public $empresa_id;
    public $setor;
    public $descricao;
    // versioning
    public $uploadingVersionFor = null;
    public $versionFile;
    // pagination / filters
    public $perPage = 10;
    public $search = '';
    public $filterSetor = '';
    public bool $showingUploadModal = false;

    // Reset pagination when filters change
    public function updatedEmpresaId() { $this->resetPage(); }
    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterSetor() { $this->resetPage(); }

    public function showCreateModal(): void
    {
        $this->resetValidation();
        $this->reset(['file', 'empresa_id', 'setor', 'descricao']);
        $this->showingUploadModal = true;
    }

    public function getEmpresasProperty()
    {
        return GrupoEconomico::orderBy('nome', 'asc')->get();
    }

    public function getRowsProperty()
    {
        $query = Document::with(['grupo', 'versions' => function($q) {
            $q->orderBy('version', 'desc')->limit(1); // Only load latest version
        }])->orderBy('created_at', 'desc');

        if ($this->empresa_id) {
            $query->where('grupo_economico_id', $this->empresa_id);
        }

        if ($this->filterSetor) {
            $query->where('setor', 'like', "%{$this->filterSetor}%");
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('descricao', 'like', "%{$this->search}%")
                  ->orWhere('current_path', 'like', "%{$this->search}%");
            });
        }

        // apply basic authorization in query: admins see all; others see their group or uploaded_by
        $user = auth()->user();
        if ($user && $user->role !== 'admin') {
            $query->where(function ($q) use ($user) {
                $q->where('grupo_economico_id', $user->grupo_economico_id)
                  ->orWhere('uploaded_by', $user->id);
            });
        }

        return $query->paginate($this->perPage);
    }

    public function upload()
    {
        $this->validate([
            'file' => 'required|file|max:10240', // 10MB
            'empresa_id' => 'nullable|exists:grupo_economicos,id',
            'setor' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:1000',
        ]);

        $empresa = $this->empresa_id ?: null;
        $filename = time().'_'.preg_replace('/[^A-Za-z0-9._-]/', '_', $this->file->getClientOriginalName());

        // Authorization: can the user create documents?
        if (!\Illuminate\Support\Facades\Gate::allows('create', Document::class)) {
            abort(403);
        }

        $doc = Document::create([
            'grupo_economico_id' => $empresa,
            'setor' => $this->setor,
            'descricao' => $this->descricao,
            'uploaded_by' => auth()->id(),
        ]);

        $storagePath = "documents/" . ($empresa ? $empresa : 'general') . "/{$doc->id}";
        $path = $this->file->storeAs($storagePath, $filename);

        $version = DocumentVersion::create([
            'document_id' => $doc->id,
            'version' => 1,
            'path' => $path, // path relativo
            'mime' => $this->file->getMimeType(),
            'size' => $this->file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        $doc->update([
            'current_path' => $path,
            'mime' => $this->file->getMimeType(),
            'size' => $this->file->getSize(),
        ]);

        $this->reset(['file', 'setor', 'descricao', 'showingUploadModal']);
        // No need to reload, computed property handles it.

        $this->dispatch('documentUploaded');
        session()->flash('message', 'Documento enviado com sucesso.');
    }

    public function startVersion(int $documentId)
    {
        $this->uploadingVersionFor = $documentId;
    }

    public function cancelVersion()
    {
        $this->uploadingVersionFor = null;
        $this->reset('versionFile');
    }

    public function uploadVersion(int $documentId)
    {
        $this->validate([
            'versionFile' => 'required|file|max:10240',
        ]);

        $document = Document::findOrFail($documentId);

        if (!\Illuminate\Support\Facades\Gate::allows('update', $document)) {
            abort(403);
        }

        $filename = time().'_'.preg_replace('/[^A-Za-z0-9._-]/', '_', $this->versionFile->getClientOriginalName());
        $empresa = $document->grupo_economico_id ?: 'general';
        $storagePath = "documents/{$empresa}/{$document->id}";
        $path = $this->versionFile->storeAs($storagePath, $filename);

        $lastVersion = DocumentVersion::where('document_id', $document->id)->orderBy('version', 'desc')->first();
        $nextVersion = $lastVersion ? $lastVersion->version + 1 : 1;

        $v = DocumentVersion::create([
            'document_id' => $document->id,
            'version' => $nextVersion,
            'path' => $path,
            'mime' => $this->versionFile->getMimeType(),
            'size' => $this->versionFile->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        $document->update([
            'current_path' => $path,
            'mime' => $this->versionFile->getMimeType(),
            'size' => $this->versionFile->getSize(),
        ]);

        $this->cancelVersion();
        
        session()->flash('message', 'Versão enviada com sucesso.');
    }

    public function render()
    {
        return view('livewire.document-center', [
            'documents' => $this->rows,
            'empresas' => $this->empresas // Uses computed getEmpresasProperty
        ])->layout('layouts.app');
    }
}
