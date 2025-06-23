<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ __('poll.result') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-xl bg-gray-800 p-6 rounded-lg shadow-lg">
    @if(session('vote_success'))
        <div class="mb-4 bg-green-600 text-white px-4 py-2 rounded">
            {{ session('vote_success') }}
        </div>
    @endif
    @if(session('vote_success') || isset($vote_success))
        <script>
            setTimeout(function () {
                window.location.href = "{{ route('polls.result', $poll->id ?? '') }}";
            }, 1000);
        </script>
    @endif

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-bold">{{ __('poll.result') }}</h1>
        <a href="/"
           class="text-sm bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-1.5 rounded transition duration-300">
            {{ __('poll.homepage') }}
        </a>
    </div>

    <h2 class="text-lg font-semibold mb-6">"{{ $poll->question }}"</h2>

    @php
        $total = $totalVotes > 0 ? $totalVotes : 1;
        $colors = ['#6366f1', '#60a5fa', '#34d399', '#fbbf24'];
    @endphp

    <ul class="mb-6">
        @foreach ($poll->options as $index => $option)
            @php
                $voteCount = $option->votes->count();
                $percent = round(($voteCount / $total) * 100, 1);
                $barColor = $colors[$index % count($colors)];
            @endphp
            <li class="mb-4">
                <div class="flex justify-between text-sm font-medium">
                    <span>・{{ $option->text }}</span>
                    <span>{{ $voteCount }} oy (%{{ $percent }})</span>
                </div>
                <div class="w-full bg-gray-700 rounded h-3 mt-1">
                    <div class="h-3 rounded" style="width: {{ $percent }}%; background-color: {{ $barColor }}"></div>
                </div>
            </li>
        @endforeach
    </ul>

    <canvas id="resultChart" class="mb-6" width="400" height="200"></canvas>

    <script>
        const ctx = document.getElementById('resultChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($poll->options->pluck('text')) !!},
                datasets: [{
                    label: 'Oy Dağılımı',
                    data: {!! json_encode($poll->options->map(fn($opt) => $opt->votes->count())) !!},
                    backgroundColor: {!! json_encode($colors) !!},
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        },
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    @if(session('vote_error'))
        <div class="mb-4 bg-red-600 text-white px-4 py-2 rounded">
            {{ session('vote_error') }}
        </div>
    @endif
</div>

</body>
</html>
