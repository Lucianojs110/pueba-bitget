<!DOCTYPE html>
<html lang="es" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }"
    class="h-full bg-[#f4f6fb] dark:bg-gray-900 dark:text-gray-100">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>

<body class="h-full flex bg-[#f4f6fb] font-sans text-gray-800">

    <!-- CONTENEDOR PRINCIPAL -->
    <div x-data="{ open: window.innerWidth >= 768 }" x-init="window.addEventListener('resize', () => open = window.innerWidth >= 768)" class="flex w-full">


        <!-- Sidebar -->
        <aside x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
            class="fixed inset-y-0 left-0 z-50 w-56 bg-white border-r shadow-sm transform md:translate-x-0 md:static md:inset-0 md:block">
            <div class="h-16 flex items-center justify-between px-5 border-b">
                <img src="/images/logo.png" alt="Service Flow" class="h-8 md:h-9 lg:h-10 w-auto object-contain">
            </div>

            <nav class="mt-5 px-3 space-y-1 text-[15px]">
                @php

                    $links = [
                        ['label' => 'Inicio', 'active' => true],
                        ['label' => 'Clientes', 'active' => false],
                        ['label' => 'Vehículos', 'active' => false],
                        ['label' => 'Órdenes de trabajo', 'active' => false],
                        ['label' => 'Etapas', 'active' => false],
                        ['label' => 'Checklists', 'active' => false],
                        ['label' => 'Técnicos', 'active' => false],
                        ['label' => 'Configuración', 'active' => false],
                    ];
                @endphp



                @foreach ($links as $link)
                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors leading-tight font-medium
                            {{ $link['active'] ? 'bg-[#eaf0ff] text-[#0a2d6b]' : 'text-gray-600 hover:bg-[#eef3ff] hover:text-[#0a2d6b]' }}"
                        style="font-size: 13px;">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <!-- Overlay (solo móvil) -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/40 z-40 md:hidden" @click="open = false">
        </div>

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="h-16 bg-white border-b flex items-center justify-between px-4 md:px-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <button @click="open = !open" class="md:hidden text-gray-700 hover:text-[#0a2d6b] text-xl">
                        ☰
                    </button>

                </div>
                <div class="relative flex items-center gap-4" x-data="{ openUserMenu: false }">

                    <!-- Dropdown -->
                    <div class="relative flex items-center gap-4" x-data="{ openUserMenu: false }">
                        <!-- Botón del usuario -->
                        <button @click="openUserMenu = !openUserMenu"
                            class="bg-[#eaf0ff] text-[#0a2d6b] w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm uppercase focus:outline-none">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </button>




                        <!-- Dropdown -->
                        <div x-show="openUserMenu" @click.away="openUserMenu = false" x-transition.origin.top.right
                            class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-md shadow-lg z-50 text-center"
                            style="top: 100%;">
                            <div class="py-3 text-sm text-gray-700">
                                <!-- Cabecera usuario -->
                                <div class="px-4 pb-3 border-b border-gray-100">
                                    <p class="font-semibold text-gray-800 capitalize">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>

                                <!-- Enlaces -->
                                <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100 transition">
                                    Perfil
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full block px-4 py-2 hover:bg-gray-100 transition">
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}" defer></script>
    @livewireScripts
</body>

</html>
