<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background: #f9fafb; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        input, textarea { width: 100%; border: 1px solid #ccc; padding: 8px; border-radius: 4px; box-sizing: border-box; }
        button { background: #2563eb; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; width: 100%; }
        button:disabled { background: #94a3b8; }
        .error { color: #ef4444; font-size: 12px; margin-top: 4px; }
        .success { color: #16a34a; font-weight: bold; text-align: center; display: none; }
    </style>
</head>
<body>

<form id="ticketForm">
    <div class="form-group">
        <label>Имя</label>
        <input type="text" name="name" required>
        <div class="error" id="err-name"></div>
    </div>

    <div style="display: flex; gap: 10px;">
        <div class="form-group" style="flex: 1;">
            <label>Email</label>
            <input type="email" name="email" required>
            <div class="error" id="err-email"></div>
        </div>
        <div class="form-group" style="flex: 1;">
            <label>Телефон</label>
            <input type="text" name="phone_number" placeholder="+7..." required>
            <div class="error" id="err-phone_number"></div>
        </div>
    </div>

    <div class="form-group">
        <label>Тема</label>
        <input type="text" name="topic" required>
    </div>

    <div class="form-group">
        <label>Сообщение</label>
        <textarea name="body" rows="4" required></textarea>
        <div class="error" id="err-body"></div>
    </div>

    <div class="form-group">
        <label>Файлы (files[])</label>
        <input type="file" name="files[]" multiple>
        <div class="error" id="err-files"></div>
    </div>

    <button type="submit" id="btn">Отправить</button>
    <div id="ok" class="success">Тикет создан!</div>
</form>

<script>
    const form = document.getElementById('ticketForm');
    const btn = document.getElementById('btn');
    const ok = document.getElementById('ok');

    form.onsubmit = async (e) => {
        e.preventDefault();
        btn.disabled = true;
        
        document.querySelectorAll('.error').forEach(el => el.innerText = '');

        const formData = new FormData(form);

        try {
            const res = await axios.post('/api/tickets', formData, {
                headers: { 'Accept': 'application/json' }
            });
            ok.style.display = 'block';
            form.reset();
        } catch (err) {
            if (err.response && err.response.status === 422) {
                const errors = err.response.data.errors;
                for (let key in errors) {
                    const cleanKey = key.split('.')[0];
                    const errDiv = document.getElementById(`err-${cleanKey}`);
                    if (errDiv) errDiv.innerText = errors[key][0];
                }
            } else {
                alert('Ошибка сервера500');
            }
        } finally {
            btn.disabled = false;
        }
    };
</script>
</body>
</html>