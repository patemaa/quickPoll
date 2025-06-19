<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quick Poll</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center px-4">

<div class="w-full max-w-md bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold text-gray-800">Quick Poll</h1>
        <a href="/create"
           class="text-sm bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-3 py-1.5 rounded transition duration-300">
            {{ __('messages.create_poll') }}
        </a>
        <a href="{{ route('polls.index') }}"
           class="text-sm bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-3 py-1.5 rounded transition duration-300">
            {{ __('messages.all_polls') }}
        </a>
    </div>

    <form class="space-y-4" action="{{ route('polls.redirect') }}" method="POST">
        @csrf
        <div>
            <label for="pollLink" class="block text-gray-700 font-medium mb-1">{{ __('messages.poll_url') }}</label>
            <input type="url" name="pollLink" id="pollLink" required
                   placeholder="{{ __('messages.url_disclaimer') }}"
                   class="w-full rounded border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 transition">
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 rounded transition duration-300">
            {{ __('messages.enter') }}
        </button>
    </form>
</div>

</body>
</html>
