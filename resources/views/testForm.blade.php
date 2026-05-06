<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Action</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 w-full max-w-md">

        <h2 class="text-xl font-semibold text-gray-800 mb-6">Ubah Action Form Dinamis</h2>

        <div class="mb-5">
            <label for="url_input" class="block text-sm font-medium text-gray-700 mb-2">URL Action Tujuan:</label>
            <input
                type="url"
                id="url_input"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                placeholder="https://example.com/submit-data"
            >
        </div>

        <x-form id="dynamic_form" route="k">
            <input type="text" value="ccc">
        </x-form>

    </div>

    <script>
        // Ambil elemen yang dibutuhkan
        const urlInput = document.getElementById('url_input');
        const dynamicForm = document.getElementById('dynamic_form');
        const actionDisplay = document.getElementById('action_display');

        // Tambahkan event listener untuk memantau perubahan pada input URL
        urlInput.addEventListener('input', function() {
            const newAction = this.value.trim();

            if (newAction !== '') {
                // Ubah atribut action pada form
                dynamicForm.action = newAction;
                // Tampilkan action di dalam teks informasi
                actionDisplay.textContent = newAction;
            } else {
                dynamicForm.action = '#';
                actionDisplay.textContent = '#';
            }
        });
    </script>
</body>
</html>
