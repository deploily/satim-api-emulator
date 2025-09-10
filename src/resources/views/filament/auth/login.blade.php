<x-filament-panels::page.simple>
    <x-slot name="title">
        Login
    </x-slot>

    <div class="space-y-6">
        <p class="text-center text-gray-700">Welcome to Satim 👋</p>

        <a 
            href="{{ route('login.keycloak') }}" 
            class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white text-lg font-medium rounded-lg shadow hover:bg-primary-700 transition"
        >
            🔑 Login with Keycloak
        </a>
    </div>
</x-filament-panels::page.simple>
