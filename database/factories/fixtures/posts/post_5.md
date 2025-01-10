# LARAVEL’DE API GELİŞTİRİRKEN KARŞILAŞTIĞIM SORUN

### Sorun: API Endpoint’inden Beklenmeyen Yanıt Alıyorum

Arkadaşlar, Laravel kullanarak bir API geliştirmeye çalışıyorum. Ancak, POST isteği yaptığımda beklediğim JSON yanıtını alamıyorum. İşte kodum:

```php
// routes/api.php
Route::post('/create-post', [PostController::class, 'store']);
```

Ve `PostController` içindeki yöntemim:

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string',
        'content' => 'required|string',
    ]);

    $post = Post::create($validated);

    return response()->json([
        'message' => 'Post başarıyla oluşturuldu!',
        'post' => $post,
    ], 201);
}
```

### Aldığım Hata

Postman veya bir frontend uygulamasıyla bu endpoint’i çağırdığımda, şu hata mesajını alıyorum:

```
Illuminate\Database\QueryException: SQLSTATE[23000]: Integrity constraint violation...
```

### Soru

Bu hatanın sebebi ne olabilir? Veritabanı tablolarımı kontrol ettim ve gerekli kolonların hepsi mevcut. Ayrıca migration dosyalarını da yeniden çalıştırdım. Fikri olan var mı?

Teşekkürler! 🙂
