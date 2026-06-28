<?php

namespace App\Http\Controllers;

use App\Events\UserTyping;
use App\Events\UserActivity;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class TypingController extends Controller
{
    public function typing(Document $document)
    {
        $user = Auth::user();

        broadcast(
            new UserTyping(
                $document->id,
                $user->name
            )
        )->toOthers();

        broadcast(
            new UserActivity(
                $document->id,
                "✏️ {$user->name} sedang mengetik"
            )
        )->toOthers();

        return response()->json([
            'success' => true
        ]);
    }
}