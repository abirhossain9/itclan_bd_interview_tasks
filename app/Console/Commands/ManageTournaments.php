<?php

namespace App\Console\Commands;

use App\Mail\SendWinningMail;
use App\Models\Idea;
use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ManageTournaments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tournaments:manage {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tournament manage';

    protected  $tournament;
    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $data = json_decode($this->argument('data'), true);

        if ($data === null) {
            $this->error('Invalid data provided.');
            return;
        }
        $candidates = $data;
        $this->createTournament();
        $this->updateIdeas($data);
        $endTime = Carbon::now()->addMinutes(15);
        $step = 1;

        while (Carbon::now() < $endTime) {
            if ($step<4){
                $stepStartTime = microtime(true);
                $winner = collect($candidates)->random(count($candidates)/2);
                $this->info('winners '.implode(', ', $winner->toArray())); ;
                $candidates = $winner->toArray();
                $this->sendMailToWinners($winner->toArray(), $step);
                $this->tournamentUpdate($step, $winner->toArray());
                $mailSendEndTime = microtime(true);
                $timeTakenInSeconds = $mailSendEndTime - $stepStartTime;
                sleep(300-$timeTakenInSeconds);
                $step = $step+1;
            }
        }
    }

    private function sendMailToWinners($winner, $step)
    {
        $winnerEmails = Idea::query()
            ->whereIn('id', $winner)
            ->pluck('email')
            ->toArray();
        $details['tournament'] =  $this->tournament;
        $details['step'] = $step;
        Mail::to($winnerEmails)->send(new SendWinningMail($details));
        $this->info('sent mails to'.implode(', ', $winnerEmails)); ;
    }

    private function tournamentUpdate($step, $winners){
        $this->tournament
            ->update([
                'tournament_step' => $step,
                'winner_idea_id'  =>  implode(', ', $winners)
            ]);

    }

    private function createTournament(){
        $this->tournament = new Tournament();
        $this->tournament->tournament_id = uniqid();
        $this->tournament->start_time = Carbon::now();
        $this->tournament->end_time = Carbon::now()->addMinutes(15);
        $this->tournament->tournament_step = 1;
        $this->tournament->save();
    }

    private function  updateIdeas($data){
        $updateData = [
            'tournament_id' => $this->tournament->id,
        ];
        Idea::query()->whereIn('id', $data)->update($updateData);
    }
}
