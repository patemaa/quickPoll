<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('poll.admin') }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto bg-gray-800 p-6 rounded-lg shadow mt-6">

        <h5 class="text-xl font-semibold mb-6">{{ __('poll.question:') }} {{ $poll->question }}</h5>

        <x-errors></x-errors>

        <form action="{{ route('polls.vote', $poll->id) }}" method="POST">
            @csrf

            <div class="space-y-2 mb-6">
                @foreach ($poll->options as $option)
                    <div class="bg-gray-700 px-4 py-2 rounded text-white">
                        ・{{ $option->text }}
                    </div>
                @endforeach
            </div>

            <div class="flex flex-wrap gap-3 mb-4">
                <a href="{{ route('polls.edit', $poll->id) }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
                    {{ __('poll.edit') }}
                </a>

                <button type="button" onclick="copyLink()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
                    {{ __('poll.copy_link') }}
                </button>

                <a href="{{ route('polls.result', $poll->id) }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
                    {{ __('poll.vote_tracking') }}
                </a>

                <a href="/polls"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
                    {{ __('poll.vote') }}
                </a>
            </div>

            <p id="copy-msg" class="text-sm text-green-400 mt-2 hidden">{{ __('poll.link_copied') }}</p>
        </form>

        @if (session('success'))
            <div class="text-green-400 bg-green-900 p-3 rounded mb-4 mt-5">
                {{ session('success') }}
            </div>
        @endif

        @if (session('success') || isset($success))
            <script>
                setTimeout(function () {
                    window.location.href = "{{ route('polls.admin', $poll->id ?? '') }}";
                }, 1000);
            </script>
        @endif

        @if (session('update_success'))
            <div class="text-green-400 bg-green-900 p-3 rounded mb-4 mt-5">
                {{ session('update_success') }}
            </div>
        @endif

        @if (session('update_success') || isset($update_success))
            <script>
                setTimeout(function () {
                    window.location.href = "{{ route('polls.admin', $poll->id ?? '') }}";
                }, 1000);
            </script>
        @endif
    </div>

    <script>
        function copyLink() {
            let url = window.location.href;

            if (url.endsWith('/admin')) {
                url = url.replace('/admin', '');
            }

            navigator.clipboard.writeText(url).then(function () {
                const msg = document.getElementById("copy-msg");
                msg.classList.remove("hidden");

                setTimeout(() => {
                    msg.classList.add("hidden");
                }, 2000);
            });
        }
    </script>
    <x-footer></x-footer>
</x-app-layout>
