<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollQuestionRequest;
use App\Http\Requests\PollRequest;
use App\Http\Requests\VoteRequest;
use App\Jobs\SendSMS;
use App\Poll;
use App\PollOption;
use Illuminate\Http\Request;
use Symfony\Component\Console\Question\Question;

class PollOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $pollId
     * @param null $pollOptionId
     * @return \Illuminate\Http\Response
     */
    public function index($pollId, $pollOptionId = null)
    {
        $pollOption = null;
        $poll = Poll::find($pollId);
        $pollOptions = $poll->pollOptions;
        if ($pollOptionId)
            $pollOption = PollOption::findOrFail($pollOptionId);

        return view('polls.options.index', ['poll' => $poll, 'pollOptions' => $pollOptions, 'pollOption' => $pollOption]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $pollId
     * @param PollRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store($pollId, PollRequest $request)
    {
        $poll = Poll::findOrFail($pollId);
        $pollOption = Poll::findOrFail($pollId);

        $this->authorize('create', [PollOption::class, $poll]);

        $pollOption->pollOptions()->save(new PollOption($request->only('title') + ['poll_id' => $pollId]));
        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\PollOption $pollOption
     * @return \Illuminate\Http\Response
     */
    public function update($pollId, $pollOptionId, PollQuestionRequest $request, PollOption $pollOption)
    {
        $pollOption = PollOption::findOrFail($pollOptionId);

        $this->authorize('update', $pollOption);

        $pollOption->update($request->only('title'));

        return redirect()->route('polls.options.index', $pollId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PollOption $pollOption
     * @return \Illuminate\Http\Response
     */
    public function destroy($pollId, $pollOptionId, PollOption $pollOption)
    {
        $pollOption = PollOption::findOrFail($pollOptionId);
        $this->authorize('delete', $pollOption);

        $pollOption->delete();

        return back();
    }

    public function vote($pollId, VoteRequest $voteRequest)
    {
        \Auth::user()->pollOptions()->attach(PollOption::findOrFail($voteRequest->get('option_id')));
        SendSMS::dispatch();
        return redirect()->route('polls.options.vote.result', $pollId);
    }
}
