# Aplikasi Absensi Pegawai

Dikembangkan dengan Laravel v8 dan PHP 7.4

## Installation

-   Clone aplikasi dari github

-   Masuk ke directory nya

-   Install package

    ```bash
      composer install
    ```

-   Copy file .env.example dan rename menjadi .env

-   Setting database pada file .env dan sesuaikan dengan database di local

    `DB_DATABASE:`

    `DB_USERNAME:`

    `DB_PASSWORD:`

-   Setting mailtrap pada file .env dan sesuaikan dengan kredensial mailtrap masing-masing untuk testing email verifikasi dan email notifikasi

    `MAIL_MAILER=smtp`

    `MAIL_HOST=smtp.mailtrap.io`

    `MAIL_PORT=`

    `MAIL_USERNAME=`

    `MAIL_PASSWORD=`

    `MAIL_ENCRYPTION=tls`

    `MAIL_FROM_ADDRESS=notif@example.com`
    
    `MAIL_FROM_NAME="${APP_NAME}"`

-   Generate Key

    ```bash
      php artisan key:generate
    ```

-   Link Storage ke Public

    ```bash
      php artisan storage:link
    ```

-   Jalankan migration

    ```bash
      php artisan migrate
    ```

-   Jalankan Laravel

    ```bash
      php artisan serve
    ```

-   Jalankan Schedule di Local

    ```bash
      php artisan schedule:work
    ```

## Contributing

Silakan Fork Repository lalu lakukan update kode

Jika telah selesai update kode, lakukan Open Pull Request
