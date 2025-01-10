# JAVASCRIPT İLE FORM VERİLERİNİ GÖNDERME

### Form Verilerini API'ye Göndermek

Arkadaşlar, bir frontend projesinde form verilerini API'ye göndermek için JavaScript kullanıyorum. Ancak, gönderdiğim veriler backend tarafından işlenmiyor gibi görünüyor. Kodum şu şekilde:

```javascript
document
    .getElementById("submitButton")
    .addEventListener("click", async function (event) {
        event.preventDefault();

        const formData = {
            name: document.getElementById("name").value,
            email: document.getElementById("email").value,
            message: document.getElementById("message").value,
        };

        try {
            const response = await fetch(
                "https://api.example.com/submit-form",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(formData),
                }
            );

            const result = await response.json();
            console.log("Success:", result);
        } catch (error) {
            console.error("Error:", error);
        }
    });
```

### Sorun

Bu kodu kullanarak formu gönderiyorum, ancak backend tarafında hiçbir şey işlenmiyor gibi. `console.log` çıktıları doğru çalışıyor, ancak backend’e ulaşmıyor olabilir.

### Soru

Bu sorun neden kaynaklanıyor olabilir?

-   API endpoint’inde bir sorun olabilir mi?
-   `CORS` ayarları backend’de yanlış mı yapılandırılmış?

Backend kısmı Laravel ile yazıldı. Yardımcı olabilecek biri var mı? 😊
