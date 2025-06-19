<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ __('poll.poll_list') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">{{ __('poll.all_polls') }}</h1>

    @if ($polls->isEmpty())
        <p class="text-gray-600">{{ __('poll.no_polls') }}</p>
    @else
        <ul class="space-y-3">
            @foreach ($polls as $poll)
                <li>
                    <a href="{{ route('polls.show', $poll->id) }}"
                       class="block p-4 border border-gray-300 rounded hover:bg-gray-100 transition">
                        {{ $poll->question }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
    <div class="flex gap-2 mt-6">
        <a href="/" class="duration-300 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">{{ __('poll.homepage') }}</a>
    </div>
</div>
</body>
</html>
