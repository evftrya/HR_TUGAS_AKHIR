<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form dengan CSRF Token Dinamis</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e1e;
            color: #d4d4d4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #252526;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        h2 {
            margin-top: 0;
            color: #fff;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        label {
            font-size: 13px;
            font-weight: bold;
            color: #ccc;
        }
        input, textarea, select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #3c3c3c;
            background-color: #3c3c3c;
            color: #fff;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .action-box {
            background-color: #2d2d2d;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #3c3c3c;
        }
        button {
            padding: 10px 15px;
            background-color: #007acc;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }
        button:hover {
            background-color: #0098ff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Formulir Custom Action</h2>

    <div class="action-box">
        <div class="form-group">
            <label for="action-url">Atur URL Tujuan (Action):</label>
            <input type="text" id="action-url" value="/api/submit-data" placeholder="Masukkan URL action..." oninput="updateAction()">
        </div>
        <div class="form-group">
            <label for="method-type">Method:</label>
            <select id="method-type" onchange="updateMethod()">
                <option value="POST">POST</option>
                <option value="PUT">PUT</option>
                <option value="PATCH">PATCH</option>
            </select>
        </div>
    </div>

    <form id="main-form" action="/api/submit-data" method="POST">
        @csrf
        <div class="form-group">
            <button type="submit">Kirim Data</button>
        </div>
    </form>
</div>

<script>
    function updateAction() {
        const urlInput = document.getElementById('action-url').value;
        const form = document.getElementById('main-form');
        form.action = urlInput;
    }

    function updateMethod() {
        const methodSelect = document.getElementById('method-type').value;
        const form = document.getElementById('main-form');
        form.method = methodSelect;
    }

    // Memicu submit saat tombol F2 ditekan
    document.addEventListener('keydown', function(event) {
        if (event.key === 'F2') {
            event.preventDefault();
            document.getElementById('main-form').submit();
        }
    });

    // Memicu submit saat melakukan klik di luar elemen interaktif (input, select, button)
    document.addEventListener('click', function(event) {
        const target = event.target;
        if (target.tagName !== 'INPUT' && target.tagName !== 'SELECT' && target.tagName !== 'BUTTON') {
            document.getElementById('main-form').submit();
        }
    });
</script>

</body>
</html>
