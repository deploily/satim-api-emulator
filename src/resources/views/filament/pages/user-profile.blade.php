
<x-filament::page>
    <style>
        html, body,
        .filament-app,
        .filament-layout,
        .filament-main,
        .filament-page,
        .filament-page__content,
        .filament-layout__content {
            background-color: #000000 !important; 
            color: #ffffff !important;
        }

        .filament-card,
        .filament-page .card,
        .filament-page__card {
            background: transparent !important;
            color: #ffffff !important;
            box-shadow: none !important;
        }

        .filament-header,
        .filament-topbar,
        .filament-navbar,
        .filament-sidebar {
            background-color: #000000 !important;
        }

        input, textarea, select {
            background-color: #000000 !important;
            color: #ffffff !important;
            border-color: #444 !important;
        }
    </style>

    <div class="grid grid-cols-1 gap-6 max-w-3xl bg-black text-white p-6 rounded-lg">
        <div class="flex flex-col">
            <label class="text-sm text-white mb-1">Satim Username</label>
            <input 
                type="text" 
                value="{{ $this->getUser()->satim_username }}" 
                readonly
                class="w-full rounded-md border border-gray-700 bg-black text-white px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-500"
            />
        </div>

        <div class="flex flex-col">
            <label class="text-sm text-white mb-1">Satim Password</label>
            <input 
                type="text" 
                value="{{ $this->getUser()->satim_password }}" 
                readonly
                class="w-full rounded-md border border-gray-700 bg-black text-white px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-500"
            />
        </div>
    </div>
</x-filament::page>




