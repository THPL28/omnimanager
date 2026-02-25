<?php

namespace App\Modules\D4Sign\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class D4SignController extends Controller
{
    public function index()
    {
        // Exibe a dashboard de documentos para assinatura digital
        return view('modules.d4sign.index');
    }

    public function sign(Request $request)
    {
        // Lógica para enviar documento à D4Sign para assinatura
        // Exemplo: $request->file('document')
        return back()->with('status', 'Documento enviado para assinatura!');
    }

    public function status($document)
    {
        // Consulta o status da assinatura do documento
        // Exemplo: buscar status via API D4Sign
        return view('modules.d4sign.status', compact('document'));
    }
}
