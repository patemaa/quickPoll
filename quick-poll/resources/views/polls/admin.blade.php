<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
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
                    <ol>
                        <li> ・ {{ $option->text }}</li>
                    </ol>
                </div>
            @endforeach
        </div>

        <div class="flex gap-2">
            <a href="{{ route('polls.edit', $poll->id) }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 duration-300">{{ __('poll.edit') }}</a>

            <button type="button" onclick="copyLink()"
                    class=" bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 duration-300">
                {{ __('poll.copy_link') }}
            </button>

            <a href="{{ route('polls.results', $poll->id) }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 duration-300">{{ __('poll.vote_tracking') }}
            </a>

            <a href="/"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 duration-300">{{ __('poll.homepage') }}</a>
        </div>
        <p id="copy-msg" class="text-sm text-green-600 mt-2 hidden duration-300">{{ __('poll.link_copied') }}</p>
    </form>

    @if (session('success'))
        <div class="text-green-700 bg-green-100 p-3 rounded mb-4 mt-5">
            {{ session('success') }}
        </div>
    @endif
    @if(session('success') || isset($success))
        <script>
            setTimeout(function() {
                window.location.href = "{{ route('polls.admin', $poll->id ?? '') }}";
            }, 1000);
        </script>
    @endif

    @if (session('update_success'))
        <div class="text-green-700 bg-green-100 p-3 rounded mb-4 mt-5">
            {{ session('update_success') }}
        </div>
    @endif
    @if(session('update_success') || isset($update_success))
        <script>
            setTimeout(function() {
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

</body>
</html>
