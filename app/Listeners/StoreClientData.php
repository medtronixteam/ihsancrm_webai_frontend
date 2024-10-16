<?php namespace App\Listeners;

use App\Events\ClientDataReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ClientData;

class StoreClientData
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ClientDataReceived  $event
     * @return void
     */
    public function handle(ClientDataReceived $event)
    {
        // Store data in the database
        // ClientData::create([
        //     'data' => $event->data
        // ]);
        
    }
}
