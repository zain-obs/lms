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
    <form action="{{ route('verify_code') }}" method="post">
        @csrf
        <div class="flex flex-col justify-center items-center bg-white p-7 rounded-md gap-y-5 shadow-lg">
            <h1 class="text-5xl text-[#243142] bebas">Verify Email</h1>
            <p class="max-w-80 text-gray-500">Hey {{ auth()->user()->name }}. A verification code has been sent to your
                email.
                Please enter it below to activate your account.</p>
            <x-input.input type="text" placeholder="code" name="code">Verification Code</x-input.input>
            <x-button.button>Verify</x-button.button>
            <p>Want to go back? <a href="{{ route('show-login') }}" class="text-gray-600 font-medium">Login</a>
            </p>
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
