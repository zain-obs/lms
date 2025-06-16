<div class="flex rounded-md p-5 w-full gap-x-5 h-full bg-gray-200">
    <div class="w-52 bg-white p-3 rounded-md flex flex-col justify-between" wire:key="{{ $activeTab }}">
        <div class="flex flex-col gap-y-5">
            <h1 class="text-xl text-gray-700 text-center font-bold">LMS</h1>
            <div wire:ignore id="sortable-container" class="flex flex-col gap-y-3">
                @foreach ($tabs as $index => $tab)
                    <x-tab.tab wire:click="changeTab('{{ $tab }}')" :tab="$activeTab"
                        wire:key="tab-{{ $tab }}" data-tab-id="{{ $index }}">
                        {{ $tab }}
                    </x-tab.tab>
                @endforeach
            </div>
        </div>
        <div x-data="{ start: true, stop: false }" class="flex flex-col gap-y-3">
            <button x-show="start" @click="start = false, stop = true" onclick="startQRScan()"
                class="w-full rounded-md bg-gray-100 text-gray-500 transition-all p-2 flex cursor-pointer justify-between hover:bg-gray-400 hover:text-gray-900">Scan
                QR</button>
            <button x-cloak x-show="stop" @click="start = true, stop = false" onclick="stopQRScan()"
                class="w-full rounded-md bg-gray-100 text-gray-500 transition-all p-2 flex cursor-pointer justify-between hover:bg-gray-400 hover:text-gray-900">Stop
                Scan</button>
            <div id="qr-reader"></div>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button
                    class="w-full rounded-md bg-gray-100 text-gray-500 transition-all p-2 flex cursor-pointer justify-between hover:bg-gray-400 hover:text-gray-900">
                    <span>Logout</span>
                    <i class="ri-logout-box-r-line"></i>
                </button>
            </form>
        </div>
    </div>
    <i wire:loading class="ri-loader-4-line text-4xl animate-spin absolute right-5 top-5"></i>
    <div class="rounded-md flex flex-col gap-y-3 w-full h-full bg-white p-3">
        <span class="font-semibold text-gray-500">Showing > {{ $activeTab }}</span>
        @if ($activeTab == 'Dashboard')
            @can('view dashboard')
                <livewire:dashboard.dashboard />
            @endcan
        @elseif ($activeTab == 'Teachers')
            @can('view teachers')
                <livewire:teachers-table.teachers-table />
            @endcan
        @elseif ($activeTab == 'Students')
            @can('view students')
                <livewire:students-table.students-table />
            @endcan
        @elseif ($activeTab == 'Parents')
            @can('view parents')
                <livewire:parents-table.parents-table />
            @endcan
        @elseif ($activeTab == 'Classes')
            @can('view class')
                <livewire:classroom.classroom />
            @endcan
        @elseif ($activeTab == 'Users')
            @can('view users')
                <livewire:users-table.users-table />
            @endcan
        @elseif ($activeTab == 'Roles and Permissions')
            @can('view users')
                <livewire:roles.roles />
            @endcan
        @endif
    </div>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('sortable-container');
            new Sortable(container, {
                animation: 150,
                onEnd: function() {
                    const newOrder = Array.from(container.children)
                        .map(tab => tab.dataset.tabId);
                    @this.call('updateTabOrder', newOrder);
                }
            });
        });
    </script>

    <script>
        window.qrReader = window.qrReader || null;

        function startQRScan() {
            if (!window.qrReader) {
                window.qrReader = new Html5Qrcode("qr-reader");
            }

            window.qrReader.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },
                (decodedText) => {
                    window.qrReader.stop().then(() => {
                        console.log("QR Code scanned:", decodedText);
                        Livewire.dispatch('scanQrCode', {
                            code: decodedText
                        });
                        clearQRUI();
                    }).catch(err => console.error("Failed to stop scanner", err));
                },
                (errorMessage) => {
                    console.warn("QR Scan error frame:", errorMessage);
                }
            ).catch(err => {
                console.error("Camera start error:", err);
            });
        }

        function stopQRScan() {
            if (window.qrReader) {
                window.qrReader.stop().then(() => {
                    console.log("Scanner stopped.");
                    clearQRUI();
                }).catch(err => {
                    console.error("Error stopping scanner:", err);
                });
            }
        }

        function clearQRUI() {
            document.getElementById("qr-reader").innerHTML = "";
            window.qrReader = null;
        }
    </script>
@endpush
