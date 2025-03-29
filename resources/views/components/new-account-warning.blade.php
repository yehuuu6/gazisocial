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
        <x-icons.info size="120" />
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
                class="text-indigo-900 text-xs flex items-center gap-0.5 mt-2 w-fit font-bold">
                Daha fazla bilgi <x-icons.arrow-right-alt size="14" />
            </x-link>
            <button type="button" x-on:click="dismiss()"
                class="absolute top-2.5 p-2 right-2.5 text-blue-300 hover:text-blue-500">
                <x-icons.close size="20" />
            </button>
        </div>
    </div>
</div>
