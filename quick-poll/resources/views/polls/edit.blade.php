<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Edit Poll</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">{{ __('messages.edit_poll') }}</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div>

    <form action="{{ route('polls.update', ['slug' => $poll->id]) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-medium mb-1" for="question">{{ __('messages.question:') }}</label>
            <input type="text" id="question" name="question"
                   class="w-full border border-gray-300 rounded p-2"
                   value="{{ old('question', $poll->question) }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">{{ __('messages.options') }}</label>
            @foreach ($poll->options as $i => $option)
                <input type="text" name="options[]"
                       class="w-full border border-gray-300 rounded p-2 mb-2"
                       placeholder="{{ __('messages.option') }} {{ $i + 1 }}"
                       value="{{ old('options.' . $i, $option->text) }}"
                       @if($i < 2) required @endif>
            @endforeach

            @for ($i = $poll->options->count(); $i < 4; $i++)
                <input type="text" name="options[]"
                       class="w-full border border-gray-300 rounded p-2 mb-2"
                       placeholder="{{ __('messages.option') }} {{ $i + 1 }}">
            @endfor

            <p class="text-sm text-gray-500">{{ __('messages.minMaxOption') }}</p>
        </div>

        <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 duration-300">
            {{ __('messages.save') }}
        </button>
    </form>
    <form action="{{ route('polls.destroy', ['slug' => $poll->slug]) }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            {{ __('messages.delete') }}
        </button>
    </form>
</div>
</div>
</body>
</html>
