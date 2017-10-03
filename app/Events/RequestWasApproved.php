<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\History;

class RequestWasApproved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $application;
    public $history;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($application,History $history)
    {
        $this->application = $application;
        $this->history = $history;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['reuqest'];
    }

    public function broadcastAs()
    {
        return 'reuqest.approved';
    }

    public function broadcastWith()
    {
        return [
            'user_code' => $this->application->user_code,  //申请人user_code
            'user_name' => $this->history->user->realName,
            'requestNo' => $this->history->requestNo,
            'action' => $this->history->route->action,
            'message' => $this->history->message,
            'created_at' =>$this->history->created_at
        ];
    }
}
