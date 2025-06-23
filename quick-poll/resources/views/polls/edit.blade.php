<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('poll.edit_poll') }}
        </h2>
    </x-slot>
    <div class="max-w-xl mx-auto bg-gray-800 p-6 rounded-lg shadow mt-6">

        <x-errors></x-errors>

        <form action="{{ route('polls.update', ['slug' => $poll->id]) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1" for="question">{{ __('poll.question:') }}</label>
                <input type="text" id="question" name="question"
                       class="w-full bg-gray-700 text-white border border-gray-600 rounded p-2 focus:outline-none focus:ring focus:ring-indigo-500"
                       value="{{ old('question', $poll->question) }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">{{ __('poll.options') }}</label>
                @foreach ($poll->options as $i => $option)
                    <input type="text" name="polls_options[]"
                           class="w-full bg-gray-700 text-white border border-gray-600 rounded p-2 mb-2 focus:outline-none focus:ring focus:ring-indigo-500"
                           placeholder="{{ __('poll.option') }} {{ $i + 1 }}"
                           value="{{ old('options.' . $i, $option->text) }}"
                           @if($i < 2) required @endif>
                @endforeach

                @for ($i = $poll->options->count(); $i < 4; $i++)
                    <input type="text" name="polls_options[]"
                           class="w-full bg-gray-700 text-white border border-gray-600 rounded p-2 mb-2 focus:outline-none focus:ring focus:ring-indigo-500"
                           placeholder="{{ __('poll.option') }} {{ $i + 1 }}">
                @endfor

                <p class="text-sm text-gray-400">{{ __('poll.minMaxOption') }}</p>
            </div>

            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded transition">
                {{ __('poll.save') }}
            </button>
        </form>

        <form action="{{ route('polls.destroy', ['slug' => $poll->slug]) }}" method="POST" class="mt-4">
            @csrf
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded transition">
                {{ __('poll.delete') }}
            </button>
        </form>
    </div>
    <x-footer></x-footer>
</x-app-layout>
