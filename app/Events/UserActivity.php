<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivity implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $documentId;
    public $message;

    public function __construct(
        $documentId,
        $message
    ) {
        $this->documentId = $documentId;
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel(
                'document.' . $this->documentId
            )
        ];
    }

    public function broadcastAs(): string
    {
        return 'user.activity';
    }
}