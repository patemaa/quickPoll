<?php

namespace App\Http\Controllers;

use App\Http\Requests\VotePollRequest;
use App\Models\Vote;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Option;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Request as FacadeRequest;

class PollController extends Controller
{
    /**
     * @return Factory|View|Application|object
     */
    public function index()
    {
        return view('index');
    }

    /**
     * @param int $id
     * @return Factory|View|Application|RedirectResponse|object
     */
    public function show(int $id)
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

    /**
     * @param VotePollRequest $request
     * @param int $pollId
     * @return RedirectResponse
     */
    public function vote(VotePollRequest $request, int $pollId)
    {
        if (!auth()->check()) {
            return redirect()
                ->route('polls.show', ['slug' => $pollId])
                ->with('vote_fail', __('poll.vote_fail'));
        }

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

    /**
     * @param int $id
     * @return Factory|View|Application|object
     */
    public function result(int $id)
    {
        $poll = Poll::with('options.votes')->findOrFail($id);
        $totalVotes = $poll->options->sum(fn($opt) => $opt->votes->count());

        return view('polls.result', compact('poll', 'totalVotes'));
    }


    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|object
     */
    public function redirect(Request $request)
    {
        $url = $request->input('pollLink');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            abort(404);
        }

        $host = parse_url($url, PHP_URL_HOST);
        if (!in_array($host, ['localhost', '127.0.0.1', 'quick-poll.test'])) {
            abort(404);
        }

        return redirect($url);
    }
}
