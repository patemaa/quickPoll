<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ __('poll.vote') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-xl bg-gray-800 text-white p-6 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-bold">{{ __('poll.poll') }}</h1>
        <a href="/polls"
           class="text-sm bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-1.5 rounded transition duration-300">
            {{ __('poll.homepage') }}
        </a>
    </div>

    <h2 class="text-lg font-bold mb-6">{{ __('poll.question:') }} {{ $poll->question }}</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-600 text-white px-4 py-2 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('vote_fail'))
        <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-2 rounded flex justify-between items-center">
            <span>{{ session('vote_fail') }}</span>
            <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:underline ml-2">
                {{ __('poll.login') }}
            </a>
        </div>
    @endif

    <form action="{{ route('polls.vote', $poll->id) }}" method="POST">
        @csrf
        <div class="space-y-3 mb-6">
            @foreach ($poll->options as $option)
                <label
                    class="flex items-center bg-gray-700 px-4 py-2 rounded cursor-pointer hover:bg-gray-600 transition">
                    <input type="radio" name="option_id" value="{{ $option->id }}" class="mr-3 accent-indigo-500"
                           required>
                    <span>{{ $option->text }}</span>
                </label>
            @endforeach
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded transition duration-300">
            {{ __('poll.vote') }}
        </button>
    </form>
</div>

</body>
</html>
