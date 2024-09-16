<div class="flex flex-col h-full">
    <div class="flex-grow h-full" wire:loading>
        <div class="flex items-start h-full w-full justify-center">
            <x-icons.spinner size="64" class="mt-14" />
        </div>
    </div>
    <div>
        <div wire:loading.remove>
            <h3 class="text-center text-lg text-gray-600 mt-5">Burada gösterilecek bir şey yok.</h3>
        </div>
    </div>
</div>
