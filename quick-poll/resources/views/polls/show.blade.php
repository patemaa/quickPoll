@auth
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('poll.poll') }}
            </h2>
        </x-slot>

        <div class="w-full max-w-xl bg-gray-800 text-white p-6 rounded-lg shadow-lg mx-auto mt-6">

            <x-errors></x-errors>

            <h2 class="text-lg font-bold mb-6">{{ __('poll.question:') }} {{ $poll->question }}</h2>
            @if (session('vote_fail'))
                <div
                    class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-2 rounded flex justify-between items-center">
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
                            <input type="radio" name="option_id" value="{{ $option->id }}"
                                   class="mr-3 accent-indigo-500"
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
    </x-app-layout>
@endauth

@guest
    <x-guest-layout>
        <div class="w-full max-w-xl bg-gray-800 text-white p-6 rounded-lg shadow-lg">

            <x-errors></x-errors>

            <h2 class="text-lg font-bold mb-6">{{ __('poll.question:') }} {{ $poll->question }}</h2>

            @if (session('vote_fail'))
                <div
                    class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-2 rounded flex justify-between items-center">
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
                            <input type="radio" name="option_id" value="{{ $option->id }}"
                                   class="mr-3 accent-indigo-500"
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
    </x-guest-layout>
@endguest
