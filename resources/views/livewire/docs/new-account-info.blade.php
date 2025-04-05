<div>
    <div
        class="mb-4 shadow-sm flex flex-col md:flex-row gap-1 md:gap-2 items-end md:items-center justify-between w-full bg-gradient-to-bl from-lime-50 to-green-100 px-6 py-4 select-none text-lime-700 rounded-xl">
        <div class="inline-flex gap-3">
            <x-icons.info size="20" class="flex-shrink-0" />
            <span class="text-xs lg:text-sm font-medium">
                Gazi Üniversitesi öğrencileri, bu kısıtlamalardan muaftır. Gazili öğrenciler, üniversitenin
                kendilerine
                sağladığı @gazi.edu.tr uzantılı e-posta adresleriyle üye olarak tam
                erişim haklarına ve "Gazili" rozetine anında sahip olabilirler.
            </span>
        </div>
        <button type="button" disabled
            class="hidden md:flex text-xs lg:text-sm text-transparent bg-transparent px-2 py-1 rounded font-medium">
            holder
        </button>
    </div>
    <div class="rounded-xl border border-gray-100 bg-white shadow-md p-6 lg:p-8">
        <h1 class="text-3xl font-bold text-primary mb-6">
            Yeni Hesaplar Hakkında Bilgilendirme
        </h1>
        <div class="space-y-6">
            <p class="text-gray-700 text-base lg:text-lg leading-relaxed">
                Gazi Social, topluluğumuzun huzurunu ve güvenliğini sağlamak amacıyla, yeni oluşturulan hesaplar için
                belirli kısıtlamalar uygulamaktadır. Bu önlemler, üyelerimizin zararlı ve spam içerik paylaşmalarını
                önlemek
                amacıyla uygulanmaktadır.
            </p>

            <p class="text-gray-700 text-base lg:text-lg leading-relaxed">
                Kısıtlama uygulanan kullanıcıların açtığı konular, moderasyon ekibinin onayı olmadan yayına alınmayacak
                ve
                yine bu kullanıcıların yaptığı yorumlar diğer üyeler tarafından "tehlikeli içerik" olarak görünecektir.
            </p>

            <p class="text-gray-700 text-base lg:text-lg leading-relaxed">
                Yukarıda belirtilen kısıtlamalar, <strong>üye olduktan 3 gün sonra otomatik olarak
                    kaldırılacaktır</strong>.
                Bu süre boyunca
                ihlal gerçekleştirdiği tespit edilen hesaplar askıya alınacaktır. Kısıtlama kalktıktan sonra eskiden
                yapılan
                yorumlar
                "tehlikeli içerik" olmaktan çıkacak, bundan sonra yapılan yorumlar ve açılan konular da kısıtlamalardan
                muaf
                olacaktır.
            </p>

            <a href="https://epostatalep.gazi.edu.tr/login" target="_blank"
                class="inline-block bg-blue-600 text-base lg:text-lg text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                Edu mail adresinizi almak için tıklayın
            </a>

            <div class="mt-8 p-6 bg-gray-50 text-base lg:text-lg rounded-lg border border-gray-100">
                <p class="text-gray-800 font-semibold">
                    Hesap oluşturma sırasında yaşanan problemler ve diğer sorunlarınız için bizimle iletişime
                    geçebilirsiniz.
                </p>

                <div class="mt-3 flex items-center">
                    <span class="font-semibold mr-2">İletişim:</span>
                    <a class="text-blue-500 hover:text-blue-700 transition-colors hover:underline"
                        href="mailto:destek@gazisocial.com">
                        destek@gazisocial.com
                    </a>
                </div>
            </div>
        </div>
        <div class="w-36 md:w-48 mt-5">
            <img src="{{ asset('\logos/GS_LOGO_DEFAULT.png') }}" alt="logo" class="size-full object-cover">
        </div>
    </div>

</div>
