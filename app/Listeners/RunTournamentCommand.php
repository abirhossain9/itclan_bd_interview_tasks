<?php

namespace App\Listeners;

use App\Events\TournamentConditionMet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class RunTournamentCommand
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TournamentConditionMet $event): void
    {
        $dataArray = $event->dataArray;
        Artisan::call('tournaments:manage',[
            'data' => json_encode($dataArray),
        ]);

    }
}
