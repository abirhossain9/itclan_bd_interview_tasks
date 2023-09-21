<?php

namespace App\Observers;

use App\Events\TournamentConditionMet;
use App\Jobs\ProcessTournamentCondition;
use App\Models\Idea;
use App\Models\Tournament;
use Carbon\Carbon;

class IdeaObserver
{
    public function created(Idea $idea)
    {
        $unassignedIdeas = $idea::where('tournament_id', null)->limit(8)->pluck('id')->toArray();
        if (count($unassignedIdeas) >= 8) {
            ProcessTournamentCondition::dispatch($unassignedIdeas);
        }
    }
}
