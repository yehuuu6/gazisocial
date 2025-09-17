<div x-data="{
    show: true,
    init() {
        this.show = localStorage.getItem('new_account_info_dismissed') !== 'true';
    },
    dismiss() {
        localStorage.setItem('new_account_info_dismissed', 'true');
        this.show = false;
    }
}" x-show="show" x-cloak
    class="shadow-sm bg-gradient-to-bl from-sky-50 to-blue-100 rounded-xl px-8 py-6 mb-6 select-none relative">
    <div class="absolute right-20 top-6 text-blue-800/50 hidden lg:block">
        <x-tabler-alert-hexagon class="size-32" />
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="max-w-xl">
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-lg text-blue-950 font-bold">
                    Gazi Social'a hoş geldiniz!
                </h1>
            </div>
            <p class="text-xs text-blue-800 leading-relaxed">
                Hesabınız yeni olduğu için konularınız moderasyon sonrası
                yayınlanacak
                ve yorumlarınız "tehlikeli" olarak işaretlenecektir. Bu geçici bir durumdur ve hesabınız güvenilir
                statüye
                ulaştığında kaldırılacaktır.
            </p>
            <x-link href="{{ route('new-account') }}"
                class="inline-flex items-center gap-1 mt-2 text-xs text-indigo-900 font-semibold hover:underline">
                destek@gazisocial.com <x-tabler-arrow-right class="size-3.5 mb-0.5" />
            </x-link>
            <button type="button" x-on:click="dismiss()"
                class="absolute top-2.5 p-2 right-2.5 text-blue-300 hover:text-blue-500">
                <x-tabler-x class="size-5" />
            </button>
        </div>
    </div>
</div>
