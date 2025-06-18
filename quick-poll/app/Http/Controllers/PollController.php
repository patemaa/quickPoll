<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Option;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Illuminate\Support\Str;

class PollController extends Controller
{
    // Yeni anket oluşturma formu
    public function create()
    {
        return view('polls.create');
    }

    // Anketi kaydet
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

        return redirect()->route('polls.show', $poll->id);
    }


    // Anketi göster (oy verme ekranı)
    public function show($id)
    {
        $poll = Poll::with('options')->findOrFail($id);

        $userIp = FacadeRequest::ip();
        $hasVoted = Option::where('poll_id', $poll->id)
            ->whereHas('votes', function ($query) use ($userIp) {
                $query->where('ip_address', $userIp);
            })->exists();

        if ($hasVoted) {
            return redirect()->route('polls.results', $poll->id);
        }

        return view('polls.show', compact('poll'));
    }

    // Oy kullan
    public function vote(Request $request, $pollId)
    {
        $request->validate([
            'option_id' => 'required|exists:polls_options,id'
        ]);

        $option = Option::findOrFail($request->input('option_id'));
        $poll = Poll::findOrFail($pollId);

        $userIp = FacadeRequest::ip();

        // Aynı IP'den oy verildi mi?
        $alreadyVoted = Vote::where('poll_id', $poll->id)
            ->where('ip_address', $userIp)
            ->exists();

        if ($alreadyVoted) {
            return redirect()->route('polls.results', $poll->id)
                ->with('error', 'Bu anket için zaten oy verdiniz.');
        }

        // IP'yi kayıt eden vote tablosu kullanılmalı
        Vote::create([
            'poll_id' => $poll->id,
            'option_id' => $option->id,
            'ip_address' => $userIp,
        ]);

        return redirect()->route('polls.results', $poll->id)
            ->with('success', 'Oyunuz başarıyla kaydedildi.');
    }

    // Sonuçları göster
    public function results($id)
    {
        $poll = Poll::with('options.votes')->findOrFail($id);
        $totalVotes = $poll->options->sum(fn($opt) => $opt->votes->count());

        return view('polls.results', compact('poll', 'totalVotes'));
    }

    public function redirect(Request $request)
    {
        $request->validate([
            'pollLink' => 'required|string',
        ]);

        $input = trim($request->pollLink);

        return redirect()->to($input);
    }
}
