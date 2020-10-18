How To Install this Project
1. Persiapan
	- Memiliki CLI/Command Line Interface berupa Command Prompt (CMD) atau Power Shell atau Git Bash (selanjutnya kita sebut terminal).
	- Memiliki Web Server (misal XAMPP) dengan PHP minimal versi 7.4 Karena project ini menggunakan framework laravel versi 7.0
	- Composer telah ter-install, cek dengan perintah composer -V melalui terminal.
	- Memiliki koneksi internet (untuk proses installasi).

2. Langkah-Langkah
	- git clone https://github.com/mohrahmatullah/klick-daily.git Melalui terminal,
	- Masuk ke direktori klik-daily melalui terminal dengan perintah cd klik-daily.
	- (Sesuai petunjuk installasi) Pada terminal, berikan perintah composer install. Ini perlu koneksi internet.
	- Composer akan menginstall dependency paket dari source code tersebut hingga selesai.
	- Jalankan perintah php artisan, untuk menguji apakah perintah artisan Laravel bekerja.
	- Buat database baru (kosong) pada mysql (via phpmyadmin) dengan nama klikdaily.
	- Duplikat file .env.example, lalu rename menjadi .env.
	- Kembali ke terminal, php artisan key:generate.
	- Setting koneksi database di file .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

		DB_CONNECTION=mysql

		DB_HOST=localhost

		DB_PORT=3306

		DB_DATABASE=klikdaily

		DB_USERNAME=root
		
		DB_PASSWORD=

	- Run migrations (tables and Seeders) php artisan migrate --seed. Cek di phpmyadmin, seharusnya tabel dan isi nya sudah muncul.
	- Setelah selesai, Jalankan perintah php artisan serve maka dapat diakses dengan http://127.0.0.1:8000/
 

Silahkan Ujicoba test dengan aplikasi POSTMAN, berikut link:

1. GET STOCK 

	METHOD = GET

	URL = http://127.0.0.1:8000/api/klikdaily/stocks

2. ADJUST STOCK 

	METHOD = POST

	URL = http://127.0.0.1:8000/api/klikdaily/adjustment

	untuk adjust stock

	- headers

	key => Content-Type

	value => application/json

	- Body
	Berikan Uji coba Test berikut : 
	
	Ini untuk test multiple array 

			[
				{
				"location_id": 1,
				"product": "Indomie Goreng",
				"adjustment": -10
				},
				{
				"location_id": 2,
				"product": "Kopi",
				"adjustment": 6
				}
			]

	Ini untuk test satu array

			[
				{
				"location_id": 1,
				"product": "Indomie Goreng",
				"adjustment": -10
				}
			]

	Catatan dari soal:	
	Apabila product pada request tidak sama dengan product yang tersimpan di lokasi yang
	dipilih maka proses akan gagal atau invalid product.

3. GET LOGS 

	METHOD = GET

	URL = http://127.0.0.1:8000/api/klikdaily/logs/{location_id}
	
	Example: http://127.0.0.1:8000/api/klikdaily/logs/1




Terimakasih atas kesempatannya untuk mengikuti test skill pada Klikdaily