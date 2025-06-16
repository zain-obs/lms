<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body class="flex flex-col justify-center items-center h-screen bg-gray-200">
    <form action="{{ route('attempt-login') }}" method="post">
        @csrf
        <div class="flex flex-col justify-center items-center bg-white p-7 rounded-md gap-y-5 shadow-lg">
            <h1 class="text-5xl text-[#243142] bebas">Welcome Back</h1>
            <x-input.input type="email" placeholder="email" name="email">Email</x-input.input>
            <x-input.input type="password" placeholder="password" name="password">Password</x-input.input>
            <div class="flex items-center w-full justify-end -mt-3 gap-x-2">
                <p>Remember me</p>
                <input class="mt-1" type="checkbox" name="remember_me" id="remember_me" value="1">
            </div>
            <x-button.button>Login</x-button.button>
            <p>Don't have an account? <a href="{{ route('show-register') }}"
                    class="text-gray-600 font-medium">Register</a></p>
        </div>
    </form>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        @if (session('message'))
            Toastify({
                text: "{{ session('message') }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "{{ session('success') === true ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #f44336, #e57373)' }}"
                }
            }).showToast();
        @endif
    </script>
</body>

</html>
