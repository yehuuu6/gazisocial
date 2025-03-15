<div class="rounded-xl border border-gray-100 bg-white shadow-md p-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Sıkça Sorulan Sorular (FAQ)</h1>

    <div x-data="{
        activeAccordion: '',
        setActiveAccordion(id) {
            this.activeAccordion = (this.activeAccordion == id) ? '' : id
        }
    }"
        class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white border border-gray-200 divide-y divide-gray-200 rounded-md">
        <x-ui.accordion>
            <x-slot name="title">
                Gazi Social nedir?
            </x-slot>
            <x-slot name="text">
                Gazi Social, Gazi Üniversitesi öğrencileri veya aday öğrenciler için geliştirilmiş,
                <span class="underline">üniversiteden bağımsız</span> bir forumdur.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Gazi Social kimler tarafından geliştiriliyor?
            </x-slot>
            <x-slot name="text">
                Gazi Üniversitesinde okuyan bir öğrenci tarafından Laravel (Livewire) frameworkü kullanılarak
                geliştirilmektedir.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Gazi Social üniversite ile bağlantılı mı?
            </x-slot>
            <x-slot name="text">
                Hayır. Sitemiz resmi bir Gazi Üniversitesi projesi değildir. Gazi Üniversitesi ile herhangi bir
                bağlantısı yoktur.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Kayıt olmak için üniversite öğrencisi olmak zorunda mıyım?
            </x-slot>
            <x-slot name="text">
                Hayır, foruma Gazi Üniversitesini gelecekte hedefleyen, merak eden adaylar da kayıt olabilir.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Gazi Üniversitesi öğrencisi olduğumu nasıl kanıtlarım?
            </x-slot>
            <x-slot name="text">
                Kayıt olurken üniversite tarafından size verilen <strong>@gazi.edu.tr</strong> mailinizi
                kullanırsanız, forumda öğrenci rolünü otomatik olarak almış olursunuz.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Öğrenciyim ancak gazi.edu.tr mailim yok. Nasıl alabilirim?
            </x-slot>
            <x-slot name="text">
                Detaylı bilgi için <a class="text-blue-600 hover:underline"
                    href="https://gazi.edu.tr/view/announcement/303951/e-posta-talep-sistemi" target="_blank">buraya</a>
                tıklayabilirsiniz.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Hangi dillerde içerik paylaşabiliriz?
            </x-slot>
            <x-slot name="text">
                Gazi Social'de Türkçe ve İngilizce dillerinde içerik paylaşabilirsiniz.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Hangi tür içerikler paylaşabiliriz?
            </x-slot>
            <x-slot name="text">
                Etiketlerde belirtilen kategorilerde içerik paylaşabilirsiniz.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Gazi Social'da reklam yapabilir miyim?
            </x-slot>
            <x-slot name="text">
                Hayır, Gazi Social'de reklam yapmak yasaktır. İçeriğinde reklam tespit edilen konular silinecek, bu
                davranış devam ederse ilgili hesaplar askıya alınacaktır.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Nasıl içerik paylaşabilirim?
            </x-slot>
            <x-slot name="text">
                Gazi Social'da içerik paylaşmak için öncelikle kayıt olmanız gerekmektedir. Kayıt olduktan sonra
                <x-link href="{{ route('posts.create') }}" class="text-blue-600">konu oluştur</x-link> sayfasına giderek
                içeriğinizi paylaşabilirsiniz.
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Gazi Social'da yasak olan davranışlar nelerdir?
            </x-slot>
            <x-slot name="text">
                Gazi Social'da aşağıdaki davranışlar yasaktır:
                <ul class="list-disc pl-6">
                    <li>Reklam yapmak</li>
                    <li>Spam yapmak</li>
                    <li>Yanlış bilgi paylaşmak</li>
                    <li>Yasadışı örgütleri veya hayali ülkeleri yüceltmek</li>
                    <li>Diğer kullanıcıları rahatsız etmek</li>
                    <li>Yasadışı içerik paylaşmak</li>
                    <li>Diğer kullanıcıları kışkırtmak</li>
                    <li>Diğer kullanıcıların gizliliğini ihlal etmek</li>
                </ul>
            </x-slot>
        </x-ui.accordion>
        <x-ui.accordion>
            <x-slot name="title">
                Hesabımı silebilir miyim?
            </x-slot>
            <x-slot name="text">
                Evet. Hesabınızı silmek için hesap ayarları sayfasına girip, hesabımı sil butonuna tıklamanız yeterli.
                Silinen hesaplara ait tüm veriler (konular, yorumlar, beğeniler vb.) geri dönüşümsüz olarak silinir.
            </x-slot>
        </x-ui.accordion>
    </div>
</div>
