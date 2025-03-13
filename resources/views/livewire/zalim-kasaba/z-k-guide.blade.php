<div class="bg-white rounded-xl shadow-md border border-gray-100">
    <div class="mx-[2%] md:mx-[16%] p-6 md:p-10">
        <section class="mb-10">
            <div class="flex items-center justify-center flex-col gap-2">
                <h1
                    class="text-3xl lg:text-5xl font-ginto font-extrabold bg-gradient-to-bl from-orange-300 to-red-800 bg-clip-text text-transparent leading-normal">
                    Zalim Kasaba
                </h1>
                <p class="text-gray-700 text-center font-medium md:text-lg w-5/6 md:w-2/3">
                    Town of Salem ve Vampir Köyü oyunlarından esinlenerek geliştirdiğimiz, rol yapma oyunu.
                </p>
                <div class="mt-3 flex items-center gap-4 md:gap-10 justify-center">
                    <a href="{{ route('games.zk.create') }}"
                        class="text-white px-3 md:px-5 py-2 md:py-2.5 text-center text-base md:text-lg font-semibold bg-gradient-to-r from-amber-500 to-red-500 border-2 border-amber-500 hover:from-amber-600 hover:to-red-600 rounded-md hover:no-underline">
                        <x-icons.show size="24" class="inline-block mr-1" /> Oyun Oluştur
                    </a>
                    <a href="{{ route('games.zk.lobbies') }}"
                        class="border-2 border-amber-500 hover:bg-amber-50 hover:text-amber-700 px-3 md:px-5 py-2 md:py-2.5 text-center text-base md:text-lg font-semibold bg-gradient-to-r bg-white text-amber-500 rounded-md hover:no-underline">
                        Aktif Oyunlar <x-icons.arrow-right-alt size="24" class="inline-block" />
                    </a>
                </div>
            </div>
        </section>
        <section>
            <div class="rounded-xl border border-orange-200 p-8">
                <h4 class="text-2xl font-bold text-gray-800">
                    📚 Genel Bakış
                </h4>
                <p class="text-gray-700 mt-4">
                    Zalim Kasaba, gizemli bir kasabada geçen, dört farklı grubun kıyasıya bir mücadele sergilediği
                    heyecan verici bir rol yapma oyunudur. Bu gruplar; masumiyetin temsilcisi <span
                        class="font-bold text-green-500">Kasaba halkı</span>, gölgelerde
                    sinsice planlar yapan <span class="font-bold text-red-500">Mafya</span>, düzensizlik ve kaos peşinde
                    koşan <span class="font-bold text-purple-500">Kaos</span> ve kendi çıkarlarını her
                    şeyin üstünde tutan <span class="font-bold text-yellow-500">Tarafsızlar</span> olarak ayrılır.
                    Oyunun temel amacı, mensubu olduğunuz grubun
                    amacına ulaşmaktır. Oyun başladığında, her oyuncu rastgele bir rol alır ve bu rol, diğer
                    oyunculardan gizli tutulur.
                    Yalnızca mafya üyeleri birbirlerini tanır.
                </p>
                <p class="text-gray-700 mt-4">
                    Oyunda 8 tane evre bulunmakta olup, her evrede oyuncuların belirli görevleri vardır.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            🏟️ Lobi
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Oyun yöneticisi yeni bir oyun kurduğunda, diğer oyuncuların katılmasını beklediği evredir.
                        </p>
                    </div>
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            🎲 Hazırlık
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Herkesin rolleri belirlenir ve oyun geri sayım bittikten sonra başlar.
                        </p>
                    </div>
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            🌞 Gündüz
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Kasaba halkı, bu evrede tartışırlar. Herkes topladığı bilgileri paylaşır ve kimin suçlu
                            olduğuna
                            karar vermeye çalışır.
                        </p>
                    </div>
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            🗳️ Oylama
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Herkes kimi idam edeceğine karar verir ve oy kullanır. Yeteri kadar oy alan oyuncuya geri
                            sayım sonunda savunma yapmak için bir süre verilir.
                        </p>
                    </div>
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            🛡️ Savunma
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Yargılanan oyuncu, kendini savunur. Bu evrede sadece o sohbete yazabilir. Diğer oyuncular
                            onu dinler.
                        </p>
                    </div>
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            ⚖️ Yargı
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Bu evrede savunmayı dinleyen oyunculara iki seçenek sunulur. Ya yargılanan oyuncuyu idam
                            ederler
                            ya da masum olduğuna karar verirler.
                            En çok oy alan seçenek uygulanır.
                        </p>
                    </div>
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            🗣️ Son Sözler
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Eğer çoğunluk suçlu olduğuna karar verdiyse, idam edilen oyuncu son sözlerini söyler,
                            diğerleri de dinler.
                        </p>
                    </div>
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            🌙 Gece
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Bu evrede oyuncular rollerine göre gece yeteneklerini kullanabilirler. Sadece mafya üyeleri
                            sohbeti kullanabilir.
                        </p>
                    </div>
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            🔍 Açıklama
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Gece olan olaylar, bu evrede açıklanır. Sonrasında oyun bir sonraki güne geçer.
                        </p>
                    </div>
                    <div class="rounded-xl border border-orange-200 p-6">
                        <h4 class="text-xl font-bold text-gray-800">
                            🏁 Oyun Bitti
                        </h4>
                        <p class="text-gray-700 mt-4">
                            Yaşayan grupların amaçları birbirleri ile çakışmazsa, oyun biter ve amacına ulaşan gruplar
                            kazanmış olur.
                        </p>
                    </div>
                </div>
        </section>
    </div>
</div>
