<?php

namespace App\Http\Controllers;

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

        $request->merge(['options' => $options]);

        $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2|max:4',
            'options.*' => 'required|string|max:100'
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
    public function vote(Request $request, $id)
    {
        $request->validate([
            'option' => 'required|exists:options,id'
        ]);

        $option = Option::findOrFail($request->option);
        $poll = Poll::findOrFail($id);

        $userIp = FacadeRequest::ip();

        // Aynı IP'den oy verildi mi?
        $alreadyVoted = $poll->options()
            ->whereHas('votes', function ($query) use ($userIp) {
                $query->where('ip_address', $userIp);
            })->exists();

        if ($alreadyVoted) {
            return redirect()->route('polls.results', $poll->id);
        }

        // IP'yi kayıt eden vote tablosu kullanılmalı
        $option->votes()->create([
            'ip_address' => $userIp
        ]);

        return redirect()->route('polls.results', $poll->id);
    }

    // Sonuçları göster
    public function results($id)
    {
        $poll = Poll::with('options')->findOrFail($id);
        $totalVotes = $poll->options->sum(fn($opt) => $opt->votes->count());

        return view('polls.results', compact('poll', 'totalVotes'));
    }
}
