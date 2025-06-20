<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Poll;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * @return Factory|View|Application|object
     */
    public function create()
    {
        return view('polls.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $options = array_filter($request->input('options'), fn($opt) => trim($opt) !== '');
        $request->merge(['polls_options' => $options]);
        $request->validate([
            'question' => 'required|string|max:255',
            'polls_options' => 'required|array|min:2|max:4',
            'polls_options.*' => 'required|string|max:100'
        ]);

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
    public function admin(int $id)
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
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $poll = Poll::findOrFail($id);
        $options = array_filter($request->input('options'), fn($opt) => trim($opt) !== '');
        $request->merge(['polls_options' => $options]);
        $request->validate([
            'question' => 'required|string|max:255',
            'polls_options' => 'required|array|min:2|max:4',
            'polls_options.*' => 'required|string|max:100'
        ]);

        $poll->update([
            'question' => $request->question,
            'slug' => Str::slug($request->question),
        ]);
        $poll->options()->delete();

        foreach ($options as $optionText) {
            $poll->options()->create(['text' => $optionText]);
        }

        return redirect()->route('polls.admin', $poll->id)->with('update_success',  __('poll.update_success'));
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

        return redirect('/')->with('destroy_success', __('poll.destroy_success'));
    }
}
