<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ __('poll.result') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    @if(session('vote_success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
            {{ session('vote_success') }}
        </div>
    @endif
        @if(session('vote_success') || isset($vote_success))
            <script>
                setTimeout(function() {
                    window.location.href = "{{ route('polls.result', $poll->id ?? '') }}";
                }, 1000);
            </script>
        @endif

    <h1 class="text-2xl font-bold mb-4">{{ __('poll.result') }}</h1>

    <h2 class="text-lg font-semibold mb-2">{{ $poll->question }}</h2>

    @php
        $total = $totalVotes > 0 ? $totalVotes : 1; // sıfıra bölme önlemi
        $colors = ['#6366f1', '#60a5fa', '#34d399', '#fbbf24']; // renk dizisi
    @endphp

    <ul class="mb-6">
        @foreach ($poll->options as $index => $option)
            @php
                $voteCount = $option->votes->count();
                $percent = round(($voteCount / $total) * 100, 1);
                $barColor = $colors[$index % count($colors)];
            @endphp
            <li class="mb-2">
                <div class="flex justify-between">
                    <span>{{ $option->text }}</span>
                    <span>{{ $voteCount }} oy (%{{ $percent }})</span>
                </div>
                <div class="w-full bg-gray-200 rounded h-3 mt-1">
                    <div class="h-3 rounded" style="width: {{ $percent }}%; background-color: {{ $barColor }}"></div>
                </div>
            </li>
        @endforeach
    </ul>

    {{-- Chart.js grafik --}}
    <canvas id="resultChart" width="400" height="200"></canvas>

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
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    @if(session('vote_error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
            {{ session('vote_error') }}
        </div>
    @endif

</div>
</body>
</html>
