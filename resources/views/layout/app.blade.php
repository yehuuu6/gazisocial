<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Sosyalleşmenin yeni adresi - Gazi Social' }}</title>
</head>

@php
    $categories = [
        (object) ['name' => 'Genel', 'slug' => 'genel'],
        (object) ['name' => 'Teknoloji', 'slug' => 'teknoloji'],
        (object) ['name' => 'Duyurular', 'slug' => 'duyurular'],
        (object) ['name' => 'Etkinlik', 'slug' => 'etkinlik'],
    ];
@endphp

<body class="antialiased h-screen flex flex-col bg-gray-100 overflow-hidden">
    <livewire:components.navbar />
    <main class="flex-1">
        <div class="h-full flex-1 grid grid-cols-1 md:grid-cols-[320px_1fr] gap-6 p-6">
            <div class="bg-white shadow-md rounded-xl hidden flex-col overflow-hidden md:flex">
                <h3 class="text-xl font-bold p-4">Kategoriler</h3>
                <x-seperator />
                <ul class="flex flex-col gap-1 p-4">
                    @foreach ($categories as $category)
                        <li>
                            <x-link
                                class="flex items-center text-lg hover:no-underline gap-2 hover:bg-[#E5E7EB]/50 px-2 py-1 rounded-md font-normal"
                                href="/categories/{{ $category->slug }}">
                                <x-icons.folder size="20" />{{ $category->name }}
                            </x-link>
                        </li>
                    @endforeach
                </ul>
                <x-seperator />
                <x-users.user-activities />
                <div class="flex bg-white border-t border-gray-300">
                    <input id="message" type="text" wire:model='message' placeholder="Mesajınızı yazın..."
                        class="w-full outline-none px-4" />
                    <button wire:click="sendMessage"
                        class="px-4 py-2 bg-blue-500 text-white font-medium hover:bg-blue-600">Gönder</button>
                </div>
            </div>
            {{ $slot }}
        </div>
    </main>
    <footer class="bg-gray-800 text-white p-2 md:p-4 font-medium flex justify-between items-center">
        <h4 class="text-sm md:text-base">Copyright all rights reserved.</h4>
        <h4 class="text-sm md:text-base">© 2024 Gazi Social</h4>
    </footer>
    @livewire('wire-elements-modal')
</body>

</html>
