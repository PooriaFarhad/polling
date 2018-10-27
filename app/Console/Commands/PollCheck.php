<?php

namespace App\Console\Commands;

use App\Poll;
use Illuminate\Console\Command;

class PollCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poll:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To check all polls and update the status to the right value';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $polls = Poll::where('status', 'running')->get();

        $this->info('Today is:' . date('Y-m-d H:i:s'));
        foreach ($polls as $poll) {
            if ($poll->expires_at) {
                if (strtotime('now') > strtotime($poll->expires_at)) {
                    Poll::where('id', $poll->id)->update(['status' => 'expired']);
                    $this->warn($poll->id . ' has been expired.');
                }
            }
        }
    }
}
