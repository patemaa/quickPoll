<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Option;
use Illuminate\Support\Facades\Request as FacadeRequest;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::latest()->get();
        return view('list', compact('polls'));
    }
    public function show($id)
    {
        $poll = Poll::with('options')->findOrFail($id);

        $userIp = FacadeRequest::ip();
        $hasVoted = Option::where('poll_id', $poll->id)
            ->whereHas('votes', function ($query) use ($userIp) {
                $query->where('ip_address', $userIp);
            })->exists();

        if ($hasVoted) {
            return redirect()->route('polls.result', $poll->id);
        }

        return view('polls.show', compact('poll'));
    }
    public function vote(Request $request, $pollId)
    {
        $request->validate([
            'option_id' => 'required|exists:polls_options,id'
        ]);

        $option = Option::findOrFail($request->input('option_id'));
        $poll = Poll::findOrFail($pollId);

        $userIp = FacadeRequest::ip();

        $alreadyVoted = Vote::where('poll_id', $poll->id)
            ->where('ip_address', $userIp)
            ->exists();

        if ($alreadyVoted) {
            return redirect()->route('polls.result', $poll->id)
                ->with('vote_error', __('poll.vote_error'));
        }

        Vote::create([
            'poll_id' => $poll->id,
            'option_id' => $option->id,
            'ip_address' => $userIp,
        ]);

        return redirect()->route('polls.result', $poll->id)
            ->with('vote_success', __('poll.vote_success'));
    }
    public function result($id)
    {
        $poll = Poll::with('options.votes')->findOrFail($id);
        $totalVotes = $poll->options->sum(fn($opt) => $opt->votes->count());

        return view('polls.result', compact('poll', 'totalVotes'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|object
     */
    public function redirect(Request $request)
    {
        $url = $request->input('pollLink');
        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            abort(404);
        }

        $parsed = parse_url($url);

        $allowedHosts = ['127.0.0.1', 'localhost'];

        if (!in_array($parsed['host'], $allowedHosts)) {
            abort(404);
        }

        return redirect($url);
    }
}
