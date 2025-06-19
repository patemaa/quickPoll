<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ __('poll.vote') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-xl font-bold mb-4">{{ __('poll.poll') }}</h1>

    <h5 class="text-xl font-bold mb-4">{{ __('poll.question:') }} {{ $poll->question }}</h5>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('polls.vote', $poll->id) }}" method="POST">
        @csrf
        <div class="space-y-2 mb-4">
            @foreach ($poll->options as $option)
                <div class="flex items-center">
                    <input type="radio" name="option_id" value="{{ $option->id }}" class="mr-2" required>
                    <label for="option-{{ $option->id }}">{{ $option->text }}</label>
                </div>
            @endforeach
        </div>

        <div class="flex gap-2">
            <button type="submit" class="duration-300 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                {{ __('poll.vote') }}
            </button>
    </form>
</div>

</body>
</html>
