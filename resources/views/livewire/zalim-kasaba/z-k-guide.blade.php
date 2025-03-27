<div>
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 md:p-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-col items-center mb-8">
                <h1 class="text-3xl lg:text-5xl font-extrabold text-primary mb-3">Zalim Kasaba</h1>
                <p class="text-gray-600 text-center font-medium mb-6">
                    Town of Salem ve Vampir Köyü oyunlarından esinlenerek geliştirdiğimiz rol yapma oyunu.
                </p>
                <div class="flex items-center gap-4 flex-wrap justify-center">
                    <a href="{{ route('games.zk.create') }}"
                        class="text-white px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 rounded-md font-medium shadow-sm hover:shadow-md transition-all">
                        <x-icons.show size="20" class="inline-block mr-1" /> Oyun Oluştur
                    </a>
                    <a href="{{ route('games.zk.lobbies') }}"
                        class="border border-gray-300 px-5 py-2.5 text-gray-700 rounded-md font-medium bg-white hover:bg-gray-50 transition-all">
                        Aktif Oyunlar <x-icons.arrow-right-alt size="20" class="inline-block" />
                    </a>
                </div>
            </div>

            <!-- Genel Bakış Kartı -->
            <div x-data="{ open: true }"
                class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden border border-gray-200">
                <div @click="open = !open" class="bg-gradient-to-r from-blue-500 to-blue-400 p-4 cursor-pointer">
                    <h2 class="text-white font-bold text-lg flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <x-icons.info size="24" />
                            Genel Bakış
                        </span>
                        <x-icons.arrow-down size="20" x-cloak x-show="!open" />
                        <x-icons.arrow-up size="20" x-cloak x-show="open" />
                    </h2>
                </div>
                <div x-show="open" x-collapse class="p-5">
                    <p class="text-gray-600 mb-4">
                        Zalim Kasaba, gizemli bir kasabada geçen, dört farklı tarafın kıyasıya bir mücadele sergilediği
                        rol yapma oyunudur. Taraflar; <span class="font-medium text-green-600">Kasaba</span>,
                        <span class="font-medium text-red-600">Mafya</span>,
                        <span class="font-medium text-purple-600">Kaos</span> ve <span
                            class="font-medium text-yellow-600">Tarafsızlar</span> olarak ayrılır.
                    </p>
                    <p class="text-gray-600">
                        Oyunun temel amacı, mensubu olduğunuz grubun amacına ulaşmaktır. Oyun başladığında, her oyuncu
                        rastgele bir rol alır ve bu rol, diğer oyunculardan gizli tutulur. Yalnızca <span
                            class="font-medium text-red-600">Mafya</span> üyeleri
                        birbirlerini tanır ve rollerini bilirler.
                    </p>
                    <br>
                    <p class="text-gray-600">
                        Oyunda diğer oyuncular ile aktif olarak iletişim halinde olmanız gerekmektedir. Bunun için
                        dilerseniz oyun içi sohbeti kullanabilir, dilerseniz de arkadaşlarınızla yan yana oturarak oyunu
                        oynayabilirsiniz. Yalnızca oyunun belirli evrelerinde konuşma hakkınız olacaktır. Geceleri
                        sohbet kullanılamaz, ancak <span class="text-red-600 font-medium">Mafya</span> üyeleri arasında
                        özel bir
                        sohbet odası vardır ve birbirlerinin
                        aksiyonlarını görebilirler.
                    </p>
                    <br>
                    <p class="text-gray-600">
                        <code class="text-xs text-pink-500">/w (Oyuncu Numarası) (Mesaj)</code> komutu ile ya da oyuncu
                        listesinden istediğiniz kişiye tıklayarak oyunculara
                        özel mesajlar
                        gönderebilirsiniz.
                        Kasabadaki diğer oyuncular fısıldadığınızı görebilirler ancak mesaj içeriği yalnızca siz ve
                        alıcı arasındadır.
                    </p>
                </div>
            </div>

            <!-- Oyun Aşamaları Kartı -->
            <div x-data="{ open: true }"
                class="bg-white rounded-lg shadow-sm mb-8 overflow-hidden border border-gray-200">
                <div @click="open = !open" class="bg-gradient-to-r from-amber-500 to-amber-400 p-4 cursor-pointer">
                    <h2 class="text-white font-bold text-lg flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <x-icons.time size="24" />
                            Oyun Aşamaları
                        </span>
                        <x-icons.arrow-down size="20" x-cloak x-show="!open" />
                        <x-icons.arrow-up size="20" x-cloak x-show="open" />
                    </h2>
                </div>
                <div x-show="open" x-collapse>
                    <div class="p-5">
                        <p class="text-gray-600 mb-4">
                            Oyunda 8 tane evre bulunmakta olup, her evrede oyuncuların belirli görevleri vardır.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">🏟️</span>
                                    Lobi
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Oyun yöneticisi yeni bir oyun kurduğunda, diğer oyuncuların katılmasını beklediği
                                    evredir.
                                </p>
                            </div>
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">🎲</span>
                                    Hazırlık
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Herkesin rolleri belirlenir ve oyun geri sayım bittikten sonra başlar.
                                </p>
                            </div>
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">🌞</span>
                                    Gündüz
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Kasaba halkı, bu evrede tartışırlar. Herkes topladığı bilgileri paylaşır ve kimin
                                    suçlu
                                    olduğuna karar vermeye çalışır.
                                </p>
                            </div>
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">🗳️</span>
                                    Oylama
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Herkes kimi idam edeceğine karar verir ve oy kullanır. Yeteri kadar oy alan oyuncuya
                                    geri
                                    sayım sonunda savunma yapmak için bir süre verilir.
                                </p>
                            </div>
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">🛡️</span>
                                    Savunma
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Yargılanan oyuncu, kendini savunur. Bu evrede sadece o sohbete yazabilir. Diğer
                                    oyuncular
                                    onu dinler.
                                </p>
                            </div>
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">⚖️</span>
                                    Yargı
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Bu evrede savunmayı dinleyen oyunculara iki seçenek sunulur. Ya yargılanan oyuncuyu
                                    idam
                                    ederler ya da masum olduğuna karar verirler. En çok oy alan seçenek uygulanır.
                                </p>
                            </div>
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">🗣️</span>
                                    Son Sözler
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Eğer çoğunluk suçlu olduğuna karar verdiyse, idam edilen oyuncu son sözlerini
                                    söyler,
                                    diğerleri de dinler.
                                </p>
                            </div>
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">🌙</span>
                                    Gece
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Bu evrede oyuncular rollerine göre gece yeteneklerini kullanabilirler. Sadece mafya
                                    üyeleri
                                    sohbeti kullanabilir.
                                </p>
                            </div>
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">🔍</span>
                                    Açıklama
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Gece olan olaylar, bu evrede açıklanır. Sonrasında oyun bir sonraki güne geçer.
                                </p>
                            </div>
                            <div class="rounded-md border border-gray-200 p-4">
                                <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-2">
                                    <span class="bg-amber-100 py-1.5 px-2 rounded-full text-amber-600">🏁</span>
                                    Oyun Bitti
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Yaşayan grupların amaçları birbirleri ile çakışmazsa, oyun biter ve amacına ulaşan
                                    gruplar
                                    kazanmış olur.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Roller Bölümü -->
            <div x-data="{
                active: 'town',
                roles: {
                    town: true,
                    mafia: false,
                    chaos: false,
                    neutral: false
                },
                toggleRole(role) {
                    this.active = role;
                    this.roles = {
                        town: role === 'town',
                        mafia: role === 'mafia',
                        chaos: role === 'chaos',
                        neutral: role === 'neutral'
                    }
                }
            }" class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-purple-600 to-purple-500 p-4">
                    <h2 class="text-white font-bold text-lg flex items-center gap-2">
                        <x-icons.user size="24" />
                        Roller
                    </h2>
                </div>
                <div class="border-b border-gray-200">
                    <nav class="flex overflow-x-auto" aria-label="Tabs">
                        <button @click="toggleRole('town')"
                            :class="active === 'town' ? 'border-green-500 text-green-600 font-medium' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap">
                            <span class="flex items-center gap-1.5">
                                <span class="text-lg">🏘️</span>
                                Kasaba Rolleri
                            </span>
                        </button>
                        <button @click="toggleRole('mafia')"
                            :class="active === 'mafia' ? 'border-red-500 text-red-600 font-medium' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap">
                            <span class="flex items-center gap-1.5">
                                <span class="text-lg">🌹</span>
                                Mafya Rolleri
                            </span>
                        </button>
                        <button @click="toggleRole('chaos')"
                            :class="active === 'chaos' ? 'border-purple-500 text-purple-600 font-medium' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap">
                            <span class="flex items-center gap-1.5">
                                <span class="text-lg">🌀</span>
                                Kaos Rolleri
                            </span>
                        </button>
                        <button @click="toggleRole('neutral')"
                            :class="active === 'neutral' ? 'border-yellow-500 text-yellow-600 font-medium' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap">
                            <span class="flex items-center gap-1.5">
                                <span class="text-lg">🕊️</span>
                                Tarafsız Roller
                            </span>
                        </button>
                    </nav>
                </div>

                <!-- Kasaba Rolleri -->
                <div x-show="roles.town" class="p-4">
                    <p class="text-gray-600 mb-6">
                        Kasaba halkını korumak ve mafyayı ortaya çıkarmak için görev yapan bu roller, geceleri özel
                        yetenekleri ile kasabayı güvende tutmaya çalışırlar.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <!-- Köylü -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-green-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/townie.jpg') }}" alt="Köylü"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-green-600 font-medium text-sm">Kasaba 🏘️</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">Köylü</h4>
                                <p class="text-gray-600 text-sm">
                                    Herhangi bir yeteneğin yok. Sadece kasabanın huzur bulmasını istiyorsun. Oylamalarda
                                    kasabaya destek ol.
                                </p>
                            </div>
                        </div>

                        <!-- Doktor -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-green-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/doctor.jpg') }}" alt="Doktor"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-green-600 font-medium text-sm">Kasaba 🏘️</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">Doktor</h4>
                                <p class="text-gray-600 text-sm">
                                    Gece kendini veya bir başkasını koruyabilirsin. Kendi kendini yalnızca bir kez
                                    koruyabilirsin.
                                </p>
                            </div>
                        </div>

                        <!-- Gözcü -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-green-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/lookout.jpg') }}" alt="Gözcü"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-green-600 font-medium text-sm">Kasaba 🏘️</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">Dikizci</h4>
                                <p class="text-gray-600 text-sm">
                                    Birinin evini gözetle ve o gece eve kimlerin gittiğini öğren.
                                </p>
                            </div>
                        </div>

                        <!-- Avcı -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-green-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/hunter.jpg') }}" alt="Avcı"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-green-600 font-medium text-sm">Kasaba 🏘️</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">Avcı</h4>
                                <p class="text-gray-600 text-sm">
                                    Silahındaki 3 mermiyi kullanarak istediğin birini vurabilirsin. Masum birini
                                    vurursan sonraki gece intihar edersin.
                                </p>
                            </div>
                        </div>

                        <!-- Muhafız -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-green-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/guard.jpg') }}" alt="Muhafız"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-green-600 font-medium text-sm">Kasaba 🏘️</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">
                                    Bekçi
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Gece seçtiğin oyuncuyu sorguya çek. Sorgu bütün gün sürdüğü için sorgulanan kişi
                                    yeteneğini kullanamadan eve geri döner.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mafya Rolleri -->
                <div x-show="roles.mafia" class="p-4">
                    <p class="text-gray-600 mb-6">
                        Geceleri toplanıp kasaba halkını öldürmeye çalışan mafya üyeleri, gündüzleri de kendilerini
                        gizleyerek kasaba halkını manipüle etmeye çalışırlar.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <!-- Godfather -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-red-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/godfather.jpg') }}" alt="Godfather"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-red-600 font-medium text-sm">Mafya 🌹</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">Baron</h4>
                                <p class="text-gray-600 text-sm">
                                    Mafyanın liderisin. Tetikçi senin emrinde çalışır ve seçtiğin oyuncuyu
                                    öldürmeye gider. Eğer tetikçi yoksa ellerini kirletmekten korkmazsın. Gece mafya ile
                                    konuşabilirsin.
                                </p>
                            </div>
                        </div>

                        <!-- Mafioso -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-red-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/mafioso.jpg') }}" alt="Mafioso"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-red-600 font-medium text-sm">Mafya 🌹</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">
                                    Tetikçi
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Baronun seçtiği kişiyi öldür. Eğer baron birini seçmezse, kendi seçtiğin kişiyi
                                    öldürürsün. Gece mafya ile konuşabilirsin.
                                </p>
                            </div>
                        </div>

                        <!-- Temizlikçi -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-red-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/janitor.jpg') }}" alt="Temizlikçi"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-red-600 font-medium text-sm">Mafya 🌹</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">Temizlikçi</h4>
                                <p class="text-gray-600 text-sm">
                                    Mafya tarafından öldürülen kişinin vasiyetini ve kimliğini temizlersin, sadece sen
                                    temizlediğin kişinin kimliğini görebilirsin. Gece mafya ile konuşabilirsin. Eğer
                                    Baron ve Tetikçi öldüyse, sen Tetikçi rolüne terfi edersin.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kaos Rolleri -->
                <div x-show="roles.chaos" class="p-4">
                    <p class="text-gray-600 mb-6">
                        Kasaba halkını manipüle eden ve çıkan kargaşadan beslenen bu rollerin tek isteği, masum
                        kasabalıların ortadan kaldırılması.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <!-- Cadı -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-purple-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/witch.jpg') }}" alt="Cadı"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-purple-600 font-medium text-sm">Kaos 🌀</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">Cadı</h4>
                                <p class="text-gray-600 text-sm">
                                    Geceleri dokunulmazsın. Bir mafya üyesi sana saldırırsa, kimliklerinizi
                                    öğrenirsiniz. Bir avcı seni öldürmeye gelirse, ona sahte bir
                                    anı yükleyip geri gönderirsin. 2 adet zehirinle köylüleri dikkatlice
                                    zehirlemelisin.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarafsız Roller -->
                <div x-show="roles.neutral" class="p-4">
                    <p class="text-gray-600 mb-6">
                        Kendi özel amaçları olan bu roller, kasaba veya mafyadan olmaksızın kendi hedeflerine ulaşmak
                        için uğraşırlar.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <!-- Soytarı -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-yellow-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/jester.jpg') }}" alt="Soytarı"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-yellow-600 font-medium text-sm">Tarafsız 🕊️</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">Zibidi</h4>
                                <p class="text-gray-600 text-sm">
                                    İdam edilmek isteyen bir manyaksın. Eğer idam edilirsen, gece bir kişiyi
                                    lanetleyerek öldürebilirsin. Gece öldürülürsen, kaybedersin.
                                </p>
                            </div>
                        </div>

                        <!-- Melek -->
                        <div class="rounded-lg shadow-sm overflow-hidden border border-yellow-100 flex flex-row">
                            <div class="w-1/3 relative overflow-hidden">
                                <img src="{{ asset('zalim-kasaba/angel.jpg') }}" alt="Melek"
                                    class="h-full w-full object-cover object-top">
                            </div>
                            <div class="w-2/3 p-4">
                                <div class="flex items-center gap-1 mb-1">
                                    <span class="text-yellow-600 font-medium text-sm">Tarafsız 🕊️</span>
                                </div>
                                <h4 class="text-base font-bold text-gray-800 mb-1">Melek</h4>
                                <p class="text-gray-600 text-sm">
                                    Gündüz insanken, gece melek formuna geçebilirsin. Gece seni öldürmeye gelenler
                                    güzelliğinden etkilenip geri döner. Melek formuna yalnızca 3 kez dönüşebilirsin.
                                    Oyunun sonuna kadar hayatta kalırsan kazanırsın.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
