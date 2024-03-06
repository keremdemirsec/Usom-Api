# Discord Webhook İşlem Projesi

Bu proje, Verilen URL'in USOM sitesinde kayıtlı olup olmadığını kontrol eder. Kullanıcıya basit bir arayüz sunar.

## Başlangıç

Projenin yerel bir kopyasını almak ve çalıştırmak için aşağıdaki adımları takip edebilirsiniz.

### Gereksinimler

Projenin çalışması için aşağıdaki yazılımlara ihtiyaç vardır:

- PHP

### Kurulum

1. Bu depoyu klonlayın:

    ```bash
    git clone https://github.com/keremdemirsec/Usom-Api
    ```

2. Proje klasörüne gidin:

    ```bash
    cd Usom-Api
    ```

3. Sunucuyu açın:

    ```bash
    php -S 127.0.0.1:8080
    ```

4. URL'e gidin:

    ```bash
    http://127.0.0.1:8080/usom.php?auth=yinemi&domain=domain.com
    ```

## Kullanım

- `auth`: Auth Keyi belirtmek için kullanılır.
- `domain`: Sorgulanacak Domaini belirtmek için kullanılır.

## Lisans

Bu proje [MIT Lisansı](LICENSE) altında lisanslanmıştır. Detaylar için lisans dosyasını inceleyin.

## İletişim

Eğer sorularınız, önerileriniz veya geri bildirimleriniz varsa, bana [e-posta](mailto:keremdemirsec@email.com) üzerinden ulaşabilirsiniz.
