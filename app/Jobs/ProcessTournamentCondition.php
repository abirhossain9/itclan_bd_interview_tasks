<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\TournamentConditionMet;

class ProcessTournamentCondition implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $unassignedIdeas;

    /**
     * Create a new job instance.
     *
     * @param array $unassignedIdeas
     */
    public function __construct(array $unassignedIdeas)
    {
        $this->unassignedIdeas = $unassignedIdeas;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        event(new TournamentConditionMet($this->unassignedIdeas));
    }
}
