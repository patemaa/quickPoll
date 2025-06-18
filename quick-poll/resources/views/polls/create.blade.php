<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Anket Oluştur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Yeni Anket Oluştur</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/store" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-medium mb-1" for="question">Soru</label>
            <input type="text" id="question" name="question" class="w-full border border-gray-300 rounded p-2" value="{{ old('question') }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Seçenekler</label>
            @for ($i = 0; $i < 4; $i++)
                <input type="text" name="options[{{ $i }}]" class="w-full border border-gray-300 rounded p-2 mb-2" placeholder="Seçenek {{ $i + 1 }}" value="{{ old('options.' . $i) }}" {{ $i < 2 ? 'required' : '' }}>
            @endfor
            <p class="text-sm text-gray-500">* En az 2, en fazla 4 seçenek girin.</p>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Anketi Oluştur</button>
    </form>
</div>
</body>
</html>
