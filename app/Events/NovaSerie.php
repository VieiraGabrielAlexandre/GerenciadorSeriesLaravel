<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NovaSerie
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nomeSerie;
    public $qtdTemparada;
    public $qtdEpisodios;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nomeSerie, $qtdTemparada, $qtdEpisodios)
    {

        $this->nomeSerie = $nomeSerie;
        $this->qtdTemparada = $qtdTemparada;
        $this->qtdEpisodios = $qtdEpisodios;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}