<?php

namespace App\Events;

use App\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class chatEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;
  public $chats;
  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($chats)
  {
    //
    $this->chats = $chats;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    return new PrivateChannel('charming-bed-688');
  }
}
