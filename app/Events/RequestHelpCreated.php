<?php

namespace App\Events;

use App\Models\RequestHelp;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class RequestHelpCreated implements ShouldBroadcast
{
    use SerializesModels;

    public $requestHelp;

    public function __construct(RequestHelp $requestHelp)
    {
        $this->requestHelp = $requestHelp;
    }

    public function broadcastOn()
    {
        return new Channel('admin-channel');
    }

    // Tambahkan method ini:
    public function broadcastWith()
    {
        return [
            'ip_address' => $this->requestHelp->ip_address,
            'label' => optional($this->requestHelp->mapping)->label ?? '-',
        ];
    }
}
