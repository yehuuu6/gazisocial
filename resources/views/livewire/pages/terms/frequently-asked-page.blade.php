<div class="rounded-xl border border-gray-100 bg-white shadow-md p-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Gazi Social Sıkça Sorulan Sorular</h1>

    <div x-data="{
        activeAccordion: '',
        setActiveAccordion(id) {
            this.activeAccordion = (this.activeAccordion == id) ? '' : id
        }
    }"
        class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white border border-gray-200 divide-y divide-gray-200 rounded-md">
        <x-accordion>
            <x-accordion-title>
                Gazi Social nedir?
            </x-accordion-title>
            <x-accordion-text>
                Gazi Social, Gazi Üniversitesi öğrencileri veya aday öğrenciler için geliştirilmiş,
                <span class="underline">üniversiteden bağımsız</span> bir forumdur.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Gazi Social kimler tarafından geliştiriliyor?
            </x-accordion-title>
            <x-accordion-text>
                Gazi Üniversitesinde okuyan bir öğrenci tarafından Laravel (Livewire) frameworkü kullanılarak
                geliştirilmektedir. Merak edenler sitenin kaynak koduna GitHub sayfasından erişebilir.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Gazi Social üniversite ile bağlantılı mı?
            </x-accordion-title>
            <x-accordion-text>
                Hayır. Sitemiz resmi bir Gazi Üniversitesi projesi değildir. Gazi Üniversitesi ile herhangi bir
                bağlantısı yoktur.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Kayıt olmak için üniversite öğrencisi olmak zorunda mıyım?
            </x-accordion-title>
            <x-accordion-text>
                Hayır, foruma Gazi Üniversitesini gelecekte hedefleyen, merak eden adaylar da kayıt olabilir.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Gazi Üniversitesi öğrencisi olduğumu nasıl kanıtlarım?
            </x-accordion-title>
            <x-accordion-text>
                Kayıt olurken üniversite tarafından size verilen <strong>@gazi.edu.tr</strong> mailinizi
                kullanırsanız, forumda öğrenci rolünü otomatik olarak almış olursunuz.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Hangi dillerde içerik paylaşabiliriz?
            </x-accordion-title>
            <x-accordion-text>
                Gazi Social'de Türkçe ve İngilizce dillerinde içerik paylaşabilirsiniz.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Hangi tür içerikler paylaşabiliriz?
            </x-accordion-title>
            <x-accordion-text>
                Etiketlerde belirtilen kategorilerde içerik paylaşabilirsiniz.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Gazi Social'da reklam yapabilir miyim?
            </x-accordion-title>
            <x-accordion-text>
                Hayır, Gazi Social'de reklam yapmak yasaktır. İçeriğinde reklam tespit edilen konular silinecek, bu
                davranış devam ederse ilgili hesaplar askıya alınacaktır.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Moderatör olabilir miyim?
            </x-accordion-title>
            <x-accordion-text>
                Evet. Moderatör olmak için forumda aktif bir şekilde içerik üretmeniz ve diğer kullanıcılara yardımcı
                olmanız gerekmektedir. Moderatör olmak için <x-link href="{{ route('terms') }}"
                    class="text-blue-500">iletişim</x-link> sayfasından bize ulaşabilirsiniz.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Nasıl içerik paylaşabilirim?
            </x-accordion-title>
            <x-accordion-text>
                Gazi Social'da içerik paylaşmak için öncelikle kayıt olmanız gerekmektedir. Kayıt olduktan sonra
                <x-link href="{{ route('posts.create') }}" class="text-blue-500">konu oluştur</x-link> sayfasına giderek
                içeriğinizi paylaşabilirsiniz.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Gazi Social'da yasak olan davranışlar nelerdir?
            </x-accordion-title>
            <x-accordion-text>
                Gazi Social'da aşağıdaki davranışlar yasaktır:
                <ul class="list-disc pl-6">
                    <li>Reklam yapmak</li>
                    <li>Spam yapmak</li>
                    <li>Yanlış bilgi paylaşmak</li>
                    <li>Yasadışı örgütleri veya hayali ülkeleri yüceltmek yasaktır</li>
                    <li>Diğer kullanıcıları rahatsız etmek</li>
                    <li>Yasadışı içerik paylaşmak</li>
                    <li>Diğer kullanıcıları kışkırtmak</li>
                    <li>Diğer kullanıcıların gizliliğini ihlal etmek</li>
                </ul>
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Geliştirme sürecine nasıl katkıda bulunabilirim?
            </x-accordion-title>
            <x-accordion-text>
                Gazi Social'in geliştirme sürecine katkıda bulunmak için GitHub sayfasından projeyi forklayarak
                geliştirmeler yapabilir, pull request gönderebilirsiniz.
            </x-accordion-text>
        </x-accordion>
        <x-accordion>
            <x-accordion-title>
                Hesabımı silebilir miyim?
            </x-accordion-title>
            <x-accordion-text>
                Evet. Hesabınızı silmek için hesap ayarları sayfasına girip, hesabımı sil butonuna tıklamanız yeterli.
                Silinen hesaplara ait tüm veriler (konular, yorumlar, beğeniler vb.) geri dönüşümsüz olarak silinir.
            </x-accordion-text>
        </x-accordion>
    </div>
</div>
