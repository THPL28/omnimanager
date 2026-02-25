@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-900">Central de Documentos</h1>
        <p class="mt-2 text-sm text-gray-600">Upload e organização por empresa e setor (esqueleto de módulo).</p>

        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Voltar</a>
        </div>

            <div class="mt-6 border-t pt-6 text-sm text-gray-700">
                @livewire('document-center')
            </div>
    </div>
</div>
@endsection
