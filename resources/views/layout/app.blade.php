<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Gazi Social' }}</title>
</head>

@php
    $categories = [
        (object) ['name' => 'Genel', 'slug' => 'genel'],
        (object) ['name' => 'Teknoloji', 'slug' => 'teknoloji'],
        (object) ['name' => 'Duyurular', 'slug' => 'duyurular'],
        (object) ['name' => 'Etkinlik', 'slug' => 'etkinlik'],
    ];
@endphp

<body class="antialiased h-screen flex flex-col bg-gray-50 overflow-hidden">
    <livewire:components.navbar />
    <main class="flex-1">
        <div class="h-full grid grid-cols-[320px_1fr] gap-6 p-6">
            <div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden">
                <h3 class="text-xl font-bold p-4">Kategoriler</h3>
                <x-seperator />
                <ul class="flex flex-col gap-1 p-4">
                    @foreach ($categories as $category)
                        <li>
                            <a class="flex items-center text-lg gap-2 hover:bg-[#E5E7EB]/50 px-2 py-1 rounded-md font-normal"
                                href="/categories/{{ $category->slug }}"
                                wire:navigate><x-icons.folder />{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
                <x-seperator />
                <x-users.user-activities />
            </div>
            {{ $slot }}
        </div>
    </main>
    <footer class="bg-gray-800 text-white p-4 font-medium flex justify-between items-center">
        <h4>Copyright all rights reserved.</h4>
        <h4>© 2024 Gazi Social</h4>
    </footer>
</body>

</html>
