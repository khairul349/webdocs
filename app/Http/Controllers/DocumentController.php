<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Events\DocumentUpdated;
use App\Models\DocumentVersion;
use App\Events\UserActivity;
use App\Models\User;

class DocumentController extends Controller
{
    /**
     * Dashboard dokumen.
     */
    public function index()
{
    $documents = Document::where(
            'owner_id',
            Auth::id()
        )
        ->orWhereHas('collaborators', function ($query) {

            $query->where(
                'user_id',
                Auth::id()
            );

        })
        ->latest()
        ->get();

    return view(
        'documents.index',
        compact('documents')
    );
}
    /**
     * Buat dokumen baru.
     */
    public function store()
    {
        $document = Document::create([
            'owner_id' => Auth::id(),
            'title' => 'Untitled Document',
            'content' => '',
            'share_token' => Str::uuid(),
            'is_public' => false,
        ]);

        return redirect()->route(
            'documents.show',
            $document->id
        );
    }

    public function realtime(
    Request $request,
    Document $document
)
{
    $document->update([

        'title' => $request->title,
        'content' => $request->content

    ]);

    broadcast(
        new DocumentUpdated($document)
    )->toOthers();

    return response()->json([
        'success' => true
    ]);
}
    /**
     * Tampilkan editor.
     */
    public function show(Document $document)
{
    $isCollaborator =
        $document->collaborators
                 ->contains(Auth::id());

    if (
        $document->owner_id != Auth::id()
        && !$isCollaborator
    ) {
        abort(403);
    }

    $users = User::all();

    return view(
        'documents.show',
        compact(
            'document',
            'users'
        )
    );
}

    /**
     * Update dokumen.
     */
    public function update(Request $request, Document $document)
{
    $user = Auth::user();

    DocumentVersion::create([

        'document_id' => $document->id,
        'user_id' => $user->id,
        'title' => $document->title,
        'content' => $document->content

    ]);

    $document->update([

        'title' => $request->title,
        'content' => $request->content

    ]);

    broadcast(
        new DocumentUpdated($document)
    )->toOthers();

    broadcast(
        new UserActivity(
            $document->id,
            "💾 {$user->name} menyimpan dokumen"
        )
    )->toOthers();

    return back()->with(
        'success',
        'Dokumen berhasil disimpan'
    );
}
public function history(Document $document)
{
    $versions = $document->versions()
                         ->latest()
                         ->get();

    return view(
        'documents.history',
        compact(
            'document',
            'versions'
        )
    );
}

public function invite(
    Request $request,
    Document $document
)
{
    $document->collaborators()
             ->syncWithoutDetaching([
                 $request->user_id
             ]);

    return back()->with(
        'success',
        'Collaborator berhasil ditambahkan'
    );
}

    /**
     * Hapus dokumen.
     */
    public function destroy(Document $document)
    {
        if ($document->owner_id != Auth::id()) {
            abort(403);
        }

        $document->delete();

        return redirect()
            ->route('documents.index')
            ->with(
                'success',
                'Dokumen berhasil dihapus'
            );
    }
}