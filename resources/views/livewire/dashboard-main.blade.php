<div class="p-8 space-y-8 text-gray-800">
    {{-- Encabezado de bienvenida --}}
    <div class="bg-white rounded-xl p-8 shadow-md border border-gray-200">
        <h1 class="text-3xl font-bold mb-2 flex items-center gap-2">
            👋 <span class="text-gray-900">¡Bienvenido, Administrador!</span>
        </h1>
        <p class="text-gray-600 text-lg">
            Este es tu panel principal. Desde aquí vas a poder acceder a tus herramientas y acciones rápidas.
        </p>
    </div>

    {{-- Acciones rápidas --}}
    <div>
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Acciones rápidas</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <button
                class="bg-white hover:bg-blue-50 text-blue-600 border border-blue-100 rounded-xl shadow-sm px-6 py-6 flex flex-col items-center justify-center transition">
                <span class="text-3xl mb-2">💰</span>
                <span class="font-semibold text-gray-800">Ver balance</span>
            </button>

            <button
                class="bg-white hover:bg-green-50 text-green-600 border border-green-100 rounded-xl shadow-sm px-6 py-6 flex flex-col items-center justify-center transition">
                <span class="text-3xl mb-2">➕</span>
                <span class="font-semibold text-gray-800">Nueva operación</span>
            </button>

            <button
                class="bg-white hover:bg-purple-50 text-purple-600 border border-purple-100 rounded-xl shadow-sm px-6 py-6 flex flex-col items-center justify-center transition">
                <span class="text-3xl mb-2">👥</span>
                <span class="font-semibold text-gray-800">Clientes</span>
            </button>

            <button
                class="bg-white hover:bg-yellow-50 text-yellow-600 border border-yellow-100 rounded-xl shadow-sm px-6 py-6 flex flex-col items-center justify-center transition">
                <span class="text-3xl mb-2">⚙️</span>
                <span class="font-semibold text-gray-800">Configuración</span>
            </button>
        </div>
    </div>
</div>
