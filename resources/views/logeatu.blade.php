<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

     <script src="https://www.google.com/recaptcha/enterprise.js?render=6LdKa-spAAAAAAyu2yS_UuTV3QUIhbX4-iixYvyC"></script>
</head>
<body>
    <div id="app">
        <login></login>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
