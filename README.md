### Bu Plugin nedir?

Bu plugin özel ayakkabı ve terlik müşterilerine footsphere teknolojisini kullanarak oluşturulan profilleri doğrultusunda satın alma gerçekleştirmesini sağlıyor

### Nasıl çalışıyor?

Sistemde 3 adet kullanıcı grubu mevcut Operasyon Yöneticisi, Üretici ve Müşteri.
Üretici yönetim panelinde kendi profilini ve üretebileceği modelleri hazırlıyor. 
Müşteri ise profilini tamamlayıp (Kişisel bilgiler, Footsphere'den gelen bilgiler) kendisine özel 
üretilebilecek ayakkabılar görmek için 24 saat'lik geçerliliği olan bir istekde bulunuyor.
Sonrasında yönetim panelinde bu istek görüntüleniyor.
24 saat içerisinde bu müşteriye üreticiler üretebileceği ayakkabı ve terlikleri teklif ediyor.
24 saat'in sonunda bu istek üzerine atılmış teklifler onaylanıyor ve ürünler kullanıcı tarafından listelenebilip satın alınabilir hale geliyor.
Operasyon yöneticiside üreticinin ürün eklemesi, teklif vermesi vb süreçlerde onaylama ve düzeltmeler yapıyor.
Müşteri ve üreticinin sistem içerisinden mesajlarına yanıt veriyor.

### Genel yapı

- Woocommerce plugini ile entegre çalışıyor.(Eğer sistemde kurulu olmazsa çalışmaz)
- Bootstrap kullanıldı.
- %70-%80 oranında mobil uyumlu eklenecek bileşenlerde öyle olmalı. 
- Sistem içerisinde üç  kullanıcı tipi(Operasyon Yoneticisi,Üretici ve Müşteri) ve izinler için bu plugin kullanıldı.([/plugins/advanced-access-manager/](https://tr.wordpress.org/plugins/advanced-access-manager/))
- Veritabanı bağlantısını sağlamak için [/github/PHP-MySQLi-Database-Class/](https://github.com/ThingEngineer/PHP-MySQLi-Database-Class)
- Kod yapısı katmanlı mimari ve mvc teknolojisi kullanıldı.(Ref: [Katmanlı Mimari](https://www.youtube.com/watch?v=S_YNRNoJM4o&list=PLqG356ExoxZV1GKedoG_dVYL8AAldKGDr&index=6), [MVC](https://www.youtube.com/watch?v=NTmk36AC6Gc&t=2653s))
- Çoklu dil desteği ve local para birimi desteği /src/core/res/values/language/ klasörünün altına eklenecek dilin kısaltması .json olarak eklenmesi gerekli
  örneğin Türkçe için tr.json olmalı ve içindeki anahtarlar aynı olmalı. local para desteğini /src/core/res/values/GeneralCons.php içerisinde tarayıcıdan çekilen dil değerine göre yapılandırılıyor.




### Kod yapısı


##### /src/business/ 
bu klasörün altında veritabanı ile kullanıcı arayüzü arasındaki bağlantıyı sağlayan sınıflar bulunur.
##### /src/data/ 
bu klasörün altında Mysqli ile direk bağlantı kuran sınıflar var. projenin başka hiçbiryerinde direk bağlantı kuran kod bulunmuyor.
##### /src/entities/
tüm katmanlar tarafından kullanılacak olan varlıklar tutulur. 
##### /src/ui/
kullanıcı arayüzü ile alakalı tüm sınıflar, resimler, js ve css dosyaları vs. 

Örnek Çalışma Yapısı;

![alt text](https://i.ibb.co/HqqpHMR/Screenshot-from-2019-03-21-11-33-33.png)

Kullanıcı profilini güncelleyeceği bir butona tıkladığını varsayalım. bunu /src/ui/controllers altındaki bir controller tarafından yorumlanıp gerekli
işlemler yapıldıktan sonra /src/ui/models/ altındaki ilgili modele gönderilip güncelleme isteğinde bulunulur bu ilgili model sınıfı /src/business/ altındaki ilgili
manager sınıfıyla iletişim kurar ve istekde bulunur bu manager uygun bulduğu takdirde güncellemeyi /src/data/ altındaki veritabanı erişim sınıfına iletir.
ve güncelleme sağlanır.

UI Katmanı hariç diğer katmanların nasıl çalıştığı ilgi klasörde dökümante edilmiş.

##### UI LAYER ;

[video link  ](https://www.youtube.com/watch?v=NTmk36AC6Gc&t=2653s) ve   [video link 2 ](https://www.youtube.com/watch?v=8Y1LAdUb1D4&t=205s)

bu iki videoda anlatılan route sisteminin aynısı kullanılmış. bu videoları izleyerek çalışma yapısını anlaşılabilir.

### DATABASE


-Product tablosunun degerlerinin karşılığını tabloya 0,1,2,3 veya boş olarak kayıt alınıyor sonrasında kullanıcının dilindeki karşılığına göre
görüntüleniyor

     [Type] => Array
        (
            [0] => Shoes
            [1] => Slipper
       )
     [BaseMaterial] => Array
        (
            [0] => Kaçuçuk
            [1] => PU
            [2] => Thermo
        )
    [ClosureType] => Array
        (
            [0] => Pass
            [1] => Velcro
            [2] => Laced
        )

    [TopMeterial] => Array
        (
            [0] => Skin
            [1] => Faux Leather
            [2] => Fabric
        )

    [Season] => Array
        (
            [0] => Spring
            [1] => Summer
            [2] => Autumn
            [3] => Winter
        )

    [liningMeterial] => Array
        (
            [0] => Skin
            [1] => Fabric
        )

    [InsideBaseType] => Array
        (
            [0] => Constant
            [1] => Replaceable
        )

    [InsideBaseMeterial] => Array
        (
            [0] => Skin
            [1] => Sponge
            [2] => Sponge with memory
        )

    [Status] => Array
        (
            [] => Waiting
            [0] => Waiting
            [1] => Accepted
            [2] => Deaccepted
        )


- Customer tablosu müşteri verilerinin tutulduğu yer.

 -ExtraFilePath sutununda kullanıcının yüklediği dosyaların yolları tutulur şu şekilde ;  file1link+-+file2link+-+....
 
 -CanUseProduct sutununda kullanıcının görüntüleyebileceği ürünlerin ID tutulur        ;   proId1,proId2,...
 
 -BespokeStatus sutununda kullanıcının NoCompolete,Compolete,Waiting ve Fix durumları söz konusudur. 

   eğer bilgilerini tamamlamamış ise NoCompolete,
   eğer bilgilerini tamamlamış ise Compolete,
   eğer bilgilerini 24 saatlik istek süresini başlatmış ise Waiting,
   eğer bilgilerini 24 saat süre bitmiş ve ürün listeleyip satın alabiliyor ise Fix durumu olur.
 

### TEST ORTAMI

/src/autoloader.php dosyasının içerisinde $F->createTestPlace(); methodunu kullanarak hazırlanmış test datalarını aktif edilebilir.


        /*
         * Operasyon yoneticisi
         * username : useroperationmanager
         * password : ViewSonic.444
         *
         * Ureticiler
         * username : testproducer  - 3 adet ürün sahibi // 1 onaylanmamış , 1 reddedilmiş , 1 onaylanmış.
         * password : ViewSonic.444
         *
         * username : testproducer2 - 3 adet ürün sahibi  // hepsi onaylı
         * password : ViewSonic.444
         *
         * Müşteriler
         * username : testuser  - Verilerini tamamlamamış. (Fotoğraf ve bilgiler.)
         * password : ViewSonic.444
         *
         * username : testuser2 - Verilerini tamamlamış ve istekde bulunmuş ürün bekliyor. ve
         * password : ViewSonic.444                   birinci üretici üçüncü ürününü teklif etmiş ikinci üretici birinci ürünü teklif etmiş
         *                                            ayrıca 1 adet ürün görüntüleyebiliyor 2500 liralık
         *
         *
         * username : testuser3 - Teklif edilen ürünler onaylanmış ve gösteriliyor.kullanıcının istek süresi bitmiş
         * password : ViewSonic.444            3 ürün görüntüleyebiliyor 60,80,100 liralık
         *
         */




### Sorunlar

- Mobil cihazlardan websiteye girince dialoglar açılırken sorun yaşanıyor
- Üretici ile müşteri arasında ürün fiyatlandırma yaparken local para birimleri söz konusu yani türk bir üretici alman bir müşteriye ürün sunarken 200 tl bir fiyat verdiğinde anlık kur ile işlem görerek karşı tarafa kendi para birimi cinsinden gösteriliyor. kur değişince kur farkı kime yansıcak belli değil.
- 