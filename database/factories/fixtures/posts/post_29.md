# C++ Sorusu: Fonksiyon Çalışmıyor!

### Bir C++ Programım Var Ama Çalışmıyor, Yardım Edin!

Arkadaşlar bir C++ programı yazıyorum, ama aşağıdaki fonksiyonum hiç çalışmıyor.  
Neden böyle olduğunu bir türlü anlayamadım, yardımcı olur musunuz?

```cpp
#include <iostream>
using namespace std;

int topla(int a, int b) {
    return a + b;
}

int main() {
    int x = 5;
    int y = 10;
    int sonuc = topla(x, y);
    cout << "Sonuç: " << sonuc << endl;
    return 0;
}
```

Bu kodun **çıktı vermemesi** ya da **hiç çalışmaması** gibi bir sorunu var. Her şey doğru gibi ama bir şey eksik galiba.  
Neyin yanlış olduğunu bilen var mı?
