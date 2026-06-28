<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $documentId;
    public $userName;

    public function __construct($documentId, $userName)
    {
        $this->documentId = $documentId;
        $this->userName = $userName;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel(
                'document.' . $this->documentId
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }
}