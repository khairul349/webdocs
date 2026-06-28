<?php

namespace App\Http\Controllers;

use App\Models\Document;

class SharedDocumentController extends Controller
{
    public function show(string $token)
    {
        $document = Document::where(
            'share_token',
            $token
        )->firstOrFail();

        return view(
            'documents.shared',
            compact('document')
        );
    }
}