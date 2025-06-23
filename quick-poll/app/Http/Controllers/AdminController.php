<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePollRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Models\Option;
use App\Models\Poll;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $polls = Poll::latest()->get();

        return view('dashboard', compact('polls'));
    }
    /**
     * @return Factory|View|Application|object
     */
    public function create()
    {
        return view('polls.create');
    }

    /**
     * @param StorePollRequest $request
     * @return RedirectResponse
     */
    public function store(StorePollRequest $request)
    {
        $options = array_filter($request->polls_options, fn($opt) => trim($opt) !== '');

        $poll = Poll::create([
            'question' => $request->question,
            'slug' => Str::slug($request->question)
        ]);

        foreach ($options as $optionText) {
            Option::create([
                'poll_id' => $poll->id,
                'text' => $optionText,
            ]);
        }

        return redirect()->route('polls.admin', $poll->id)->with('success', __('poll.success'));
    }

    /**
     * @param int $id
     * @return Factory|View|Application|object
     */
    public function viewAdmin(int $id)
    {
        $poll = Poll::with('options')->findOrFail($id);
        return view('polls.admin', compact('poll'));
    }

    /**
     * @param $id
     * @return Factory|View|Application|object
     */
    public function edit(int $id)
    {
        $poll = Poll::with('options')->findOrFail($id);
        return view('polls.edit', compact('poll'));
    }

    /**
     * @param UpdatePollRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdatePollRequest $request, int $id)
    {
        $poll = Poll::findOrFail($id);
        $options = array_filter($request->input('polls_options'), fn($opt) => trim($opt) !== '');
        if (count($options) < 2 || count($options) > 4) {
            return back()->withErrors(['options_error' => __('poll.options_error')])->withInput();
        }
        $request->merge(['polls_options' => $options]);

        $poll->update([
            'question' => $request->question,
            'slug' => Str::slug($request->question),
        ]);
        $poll->options()->delete();

        foreach ($options as $optionText) {
            $poll->options()->create(['text' => $optionText]);
        }

        return redirect()->route('polls.admin', $poll->id)->with('update_success', __('poll.update_success'));
    }

    /**
     * @param string $slug
     * @return Application|RedirectResponse|Redirector|object
     */
    public function destroy(string $slug)
    {
        $poll = Poll::where('slug', $slug)->firstOrFail();
        foreach ($poll->options as $option) {
            $option->votes()->delete();
            $option->delete();
        }
        $poll->delete();

        return redirect('polls')->with('destroy_success', __('poll.destroy_success'));
    }
}
