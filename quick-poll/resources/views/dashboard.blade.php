<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-4xl mx-auto py-4">
                        <h1 class="self-start text-2xl font-bold mb-6">{{ __('poll.all_polls') }}</h1>

                        @if ($polls->isEmpty())
                            <p class="text-gray-600">{{ __('poll.no_polls') }}</p>
                        @else
                            <ul class="space-y-3">
                                @foreach ($polls as $poll)
                                    <li class="mb-4">
                                        <a href="{{ route('polls.show', $poll->id) }}"
                                           class="block p-4 border border-gray-300 rounded hover:bg-gray-500 transition duration-300">
                                            {{ $poll->question }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-app-layout>
