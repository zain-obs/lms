<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles()
</head>

<body class="w-full h-screen">
    <livewire:layout />
    @livewireScripts()
    @stack('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
        Livewire.on('notification', (data) => {
            Toastify({
                text: data.message,
                duration: 4000,
                close: true,
                gravity: "top",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: data.success ?
                        "linear-gradient(to right, #00b09b, #96c93d)" :
                        "linear-gradient(to right, #f44336, #e57373)"
                }
            }).showToast();
        });
    </script>
    <script>
        document.addEventListener('livewire:load', function() {
            var el = document.getElementById('tabs-container');
            Sortable.create(el, {
                animation: 150,
                onEnd: function(evt) {
                    let order = Array.from(el.children).map(child => child.getAttribute('data-id'));
                    Livewire.emit('tabsReordered', order);
                }
            });
        });
    </script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        const boundClassrooms = new Set();

        window.addEventListener('classroom-id-available', function(event) {
            const classroomId = event.detail.classroomId;
            console.log('Got classroomId:', classroomId);
            if (boundClassrooms.has(classroomId)) return;
            boundClassrooms.add(classroomId);

            window.Echo.channel(`classroom.${classroomId}`)
                .listen('.sent', (data) => {
                    console.log('Received message:', data);

                    document.getElementById('messages').innerHTML += `
                <div class="flex flex-col bg-white shadow-md rounded py-1 px-3">
                    <p class="text-start text-sm">${data.message}</p>
                    <div class="text-xs text-gray-400 flex justify-between">
                        <span>${data.sender}</span>
                        <span>${data.created_at}</span>
                    </div>
                </div>
            `;
                    const el = document.getElementById('messages');
                    el.scrollTop = el.scrollHeight;
                });
        });
    </script>
    @stack('scripts')
</body>

</html>
