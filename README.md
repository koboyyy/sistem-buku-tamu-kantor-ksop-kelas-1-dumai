## CARA INSTALASI

1. buka aplikasi git bash
2. ketik : cd Desktop
3. ketik: git clone https://github.com/koboyyy/sistem-buku-tamu-kantor-ksop-kelas-1-dumai.git
4. ketik: cd sistem-buku-tamu-kantor-ksop-kelas-1-dumai
5. ketik: composer install
6. ketik: cp .env.example .env
7. ketik: php artisan key:generate
8. ketik: php artisan migrate --seed
9. ketik: php artisan serve

## AKUN TESTING

### Akun Admin:

- username : admin
- password : admin123

### Akun Tamu:

- username : budi@gmail.com
- password : tamu123
