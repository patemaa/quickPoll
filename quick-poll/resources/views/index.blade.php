<!doctype html>
<html lang="en" class="h-full bg-black/90">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
<div class="grid grid-flow-col justify-items-end mt-6 mr-6">
    <a href="/create"
       class=" justify-items-end border border-indigo-600 bg-indigo-600 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300">
        Create Poll</a>

</div>
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="{{ route('polls.redirect') }}" method="POST">
            @csrf
            <div>
                <div>
                    <label for="pollLink" class="mb-2 text-bold text-white">Poll Link</label>
                    <input type="url" name="pollLink" id="pollLink" required placeholder="Enter the poll url..."
                           class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300">
                    Enter
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
