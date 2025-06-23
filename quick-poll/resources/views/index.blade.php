<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quick Poll</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex flex-col justify-center items-center px-4 text-white">



@if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif

<div class="w-full max-w-md bg-gray-800 rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Quick Poll</h1>
        @if (Route::has('login'))
            <div class="flex items-center justify-end gap-4">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="text-sm bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-3 py-1.5 rounded transition"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="text-sm bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-3 py-1.5 rounded transition"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="text-sm bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-3 py-1.5 rounded transition">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif



    </div>

    <form class="space-y-4" action="{{ route('polls.redirect') }}" method="POST">
        @csrf
        <div>
            <label for="pollLink" class="block text-gray-300 font-medium mb-1">{{ __('poll.poll_url') }}</label>
            <input type="url" name="pollLink" id="pollLink" required
                   placeholder="{{ __('poll.url_disclaimer') }}"
                   class="w-full rounded border border-gray-600 bg-gray-700 px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 transition">
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 rounded transition">
            {{ __('poll.enter') }}
        </button>
    </form>
</div>

</body>
</html>
