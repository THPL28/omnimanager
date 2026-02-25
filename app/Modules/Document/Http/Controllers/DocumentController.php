<?php

namespace App\Modules\Document\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    public function index()
    {
        return view('modules.document.index');
    }

    public function download(Document $document, $version = null)
    {
        // Authorization
        if (!\Illuminate\Support\Facades\Gate::allows('view', $document)) {
            abort(403);
        }

        if ($version) {
            $v = DocumentVersion::where('document_id', $document->id)->where('id', $version)->firstOrFail();
            $path = $v->path;
        } else {
            $path = $document->current_path;
        }

        if (!$path || !Storage::exists($path)) {
            abort(404, 'Arquivo não encontrado');
        }

        return Storage::download($path);
    }

    public function show(Document $document)
    {
        if (!\Illuminate\Support\Facades\Gate::allows('view', $document)) {
            abort(403);
        }

        $document->load('versions');
        return view('modules.document.show', compact('document'));
    }
}
