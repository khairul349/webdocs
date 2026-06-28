<?php

namespace App\Events;

use App\Models\Document;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $document;

    public function __construct(Document $document)
    {
        $this->document = [
            'id' => $document->id,
            'title' => $document->title,
            'content' => $document->content,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel(
                'document.' . $this->document['id']
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'document.updated';
    }
}