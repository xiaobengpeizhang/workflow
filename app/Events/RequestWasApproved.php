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

    public $history;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(History $history)
    {
        $this->history = $history;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [
            'request'
        ];
        //TODO:实现私有广播
//        return new PrivateChannel('reuqest.'.$this->history->requestNo);
    }

    public function broadcastAs()
    {
        return 'reuqest.approved';
    }

    public function broadcastWith()
    {
        return [
            'user_code' => $this->history->user->user_code,
            'user_name' => $this->history->user->realName,
            'requestNo' => $this->history->requestNo,
            'action' => $this->history->route->action,
            'message' => $this->history->message,
            'created_at' =>$this->history->created_at
        ];
    }
}
