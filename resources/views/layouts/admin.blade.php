<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Admin: @yield("title")</title>
</head>
<body class="bg-black">
    <div>
        @yield("content")
    </div>
</body>
</html>