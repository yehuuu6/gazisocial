<div class="flex items-center gap-0.5">
    <button wire:click="setNewest()" wire:loading.class="animate-pulse" wire:loading.attr="disabled" wire:target="setNewest"
        class="{{ $this->getActiveClass('created_at') }} rounded-md px-3 py-2 text-sm font-medium hover:no-underline">
        En Yeni
    </button>
    <button wire:click="setPopular()" wire:loading.class="animate-pulse" wire:loading.attr="disabled"
        wire:target="setPopular"
        class="{{ $this->getActiveClass('popularity') }} rounded-md px-3 py-2 text-sm font-medium hover:no-underline">
        Popüler
    </button>
</div>
