<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $jadwalId;
    public ?int $nomorSedangDilayani;

    public function __construct(
        int $jadwalId,
        ?int $nomorSedangDilayani
    ) {
        $this->jadwalId = $jadwalId;
        $this->nomorSedangDilayani = $nomorSedangDilayani;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('antrian'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'antrian.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'jadwal_id' => $this->jadwalId,
            'nomor_sedang_dilayani' => $this->nomorSedangDilayani,
        ];
    }
}
