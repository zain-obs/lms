<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body class="flex flex-col justify-center items-center h-screen bg-gray-200">
    <form action="{{ route('attempt-register') }}" method="post">
        @csrf
        <div class="flex flex-col justify-center items-center bg-white p-7 rounded-md gap-y-5 shadow-lg">
            <h1 class="text-5xl text-[#243142] bebas">Get Started</h1>
            <x-input.input type="text" placeholder="name" name="name">Name</x-input.input>
            <x-input.input type="email" placeholder="email" name="email">Email</x-input.input>
            <x-input.input type="password" placeholder="password" name="password">Password</x-input.input>
            <x-input.input type="password" placeholder="confirm password" name="password_confirmation">Confirm
                Password</x-input.input>
            <x-button.button>Register</x-button.button>
            <p>Already have an account? <a href="{{ route('show-login') }}" class="text-gray-600 font-medium">Login</a>
            </p>
        </div>
    </form>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>
