<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollRequest;
use App\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polls = Poll::where('user_id', \Auth::id())->paginate(10);

        return view('polls.index')->with(['polls' => $polls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('polls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PollRequest $request
     * @return void
     */
    public function store(PollRequest $request)
    {
        $imageName = null;
        if($request->hasFile('image')) {
            if($request->file('image')->isValid()) {
                $path = $request->file('image')->store('public/images');
                $imageName = (explode('/', $path))[2];
                $image = \Image::make(\Storage::get($path));
                $image->fit(300);
                $image->save(public_path('images/' . $imageName));
            }
        }
        Poll::create($request->only('title', 'content', 'expires_at') + ['user_id' => \Auth::id(), 'image' => $imageName]);

        return redirect()->route('polls.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poll = Poll::findOrFail($id);
        $pollOptions = $poll->pollOptions;
        return view('polls.show', ['poll' => $poll, 'pollOptions' => $pollOptions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poll = Poll::findOrFail($id);
        $this->authorize('update', $poll);

        return view('polls.edit', ['poll' => $poll]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PollRequest $request, $id)
    {
        $poll = Poll::findOrFail($id);
        $this->authorize('update', $poll);

        $imageName = $poll->image;
        if($request->hasFile('image')) {
            if($request->file('image')->isValid()) {
                $path = $request->file('image')->store('public/images');
                $imageName = (explode('/', $path))[2];
                $image = \Image::make(\Storage::get($path));
                $image->fit(300);
                $image->save(public_path('images/' . $imageName));
            }
        }

        $poll->update($request->only('title', 'content', 'expires_at') + [ 'image' => $imageName]);

        return redirect()->route('polls.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poll = Poll::findOrFail($id);
        $this->authorize('delete', $poll);

        $poll->delete();

        return redirect()->route('polls.index');
    }

    public function toggleActivation($id)
    {
        $poll = Poll::findOrFail($id);
        $this->authorize('update', $poll);

        $poll->is_active = ! $poll->is_active;
        $poll->save();

        return back();
    }

    public function getResult($pollId)
    {
        $poll = Poll::findOrFail($pollId);

        $results = \DB::table('poll_options')
            ->leftJoin('user_answer', 'poll_options.id', '=', 'user_answer.answer_id')
            ->where('poll_options.poll_id', $poll->id)
            ->groupBy('poll_options.id')
            ->get(['poll_options.title', \DB::raw('COUNT(user_answer.id) AS vote')]);

        $totalCounts = 0;

        foreach ($results as $result) {
            $totalCounts += $result->vote;
        }

        foreach ($results as $result) {
            $result->percentage = $result->vote/$totalCounts * 100;
        }

        return view('polls.results', ['poll' => $poll, 'results' => $results]);
    }
}
