@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-semibold">Detalhe do Documento</h1>
        <p class="mt-2 text-sm text-gray-600">Documento #{{ $document->id }}</p>

        <div class="mt-4 grid grid-cols-1 gap-4">
            <div>
                <strong>Descrição:</strong>
                <div class="text-sm text-gray-700">{{ $document->descricao }}</div>
            </div>

            <div>
                <strong>Setor:</strong>
                <div class="text-sm text-gray-700">{{ $document->setor }}</div>
            </div>

            <div>
                <strong>Empresa (Grupo):</strong>
                <div class="text-sm text-gray-700">{{ $document->grupo?->nome ?? '—' }}</div>
            </div>

            <div>
                <strong>Versões:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach($document->versions as $v)
                        <li class="py-1">
                            v{{ $v->version }} — {{ $v->mime }} — {{ number_format($v->size/1024, 2) }} KB
                            <a href="{{ route('documentos.download', ['document' => $document->id, 'version' => $v->id]) }}" class="ml-3 text-indigo-600 hover:underline">Baixar</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-4">
                <a href="{{ route('documentos.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Voltar</a>
            </div>
        </div>
    </div>
</div>
@endsection
