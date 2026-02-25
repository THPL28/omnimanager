@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Assinatura Digital (D4Sign)</h1>
    <form method="POST" action="{{ route('d4sign.sign') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label for="document" class="block font-medium">Documento para assinatura:</label>
            <input type="file" name="document" id="document" required class="mt-1 block w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enviar para assinatura</button>
    </form>
    @if(session('status'))
        <div class="mt-4 text-green-600">{{ session('status') }}</div>
    @endif
</div>
@endsection
