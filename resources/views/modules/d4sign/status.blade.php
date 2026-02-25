@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">Status da Assinatura</h1>
    <div class="bg-gray-100 p-4 rounded">
        <p>Documento: <span class="font-mono">{{ $document }}</span></p>
        <p>Status: <span class="font-semibold">(em breve: integração D4Sign)</span></p>
    </div>
    <a href="{{ route('d4sign.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">Voltar</a>
</div>
@endsection
