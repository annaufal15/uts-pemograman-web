# UTS – Pengembangan Profil Mahasiswa

## 1. Deskripsi

Proyek ini merupakan pengembangan artefak `bahan-pertemuan-08` untuk Ujian Tengah Semester. Aplikasi menampilkan profil mahasiswa dan formulir kontak dengan PHP, HTML, CSS, serta JavaScript.

## 2. Struktur proyek

```text
bahan-pertemuan-08/
├── img/
│   └── foto-profil.jpg
├── index.php       # Halaman profil, formulir, validasi dan session
├── indexGet.php    # Contoh membaca parameter dengan metode GET
├── script.js       # Navigasi responsif dan validasi sisi klien
├── style.css       # Tampilan responsif
└── README.md       # Dokumentasi pengembangan dan pengujian
```

## 3. Pengembangan yang dilakukan

1. Memeriksa struktur dan kode awal dari artefak pertemuan 08.
2. Mempertahankan materi PHP dasar yang sudah tersedia, yaitu variabel, konstanta, operator, percabangan `if-elseif-else`, `switch`, serta perulangan `for` dan `while`.
3. Menambahkan validasi sisi server pada `index.php`. Data nama, email, semester, tanggal, jenis pesan, topik minat, program studi, dan pesan diperiksa kembali sebelum disimpan.
4. Membatasi pilihan checkbox minat ke nilai `HTML` dan `CSS` yang memang disediakan pada formulir.
5. Menggunakan `htmlspecialchars()` melalui fungsi `e()` saat data pengguna ditampilkan agar masukan tidak ditafsirkan sebagai HTML.
6. Mempertahankan penyimpanan data menggunakan `$_SESSION` dan pola Post/Redirect/Get agar refresh halaman tidak mengirim ulang formulir.
7. Mengisi kembali nilai formulir ketika validasi server gagal, sehingga pengguna tidak perlu mengetik ulang seluruh data.
8. Merapikan `indexGet.php` agar parameter GET ditampilkan dengan aman dan halaman tetap dapat dibuka ketika belum ada parameter.
9. Mempertahankan validasi JavaScript dan navigasi responsif dari artefak awal.

## 4. Hasil pengujian

Pengujian teknis yang dilakukan:

| No. | Pengujian | Hasil yang diharapkan | Hasil |
|---|---|---|---|
| 1 | Pemeriksaan sintaks `index.php` (`php -l`) | Tidak ada kesalahan sintaks PHP | Lulus |
| 2 | Pemeriksaan sintaks `indexGet.php` (`php -l`) | Tidak ada kesalahan sintaks PHP | Lulus |
| 3 | Membuka halaman utama melalui server PHP lokal | HTTP 200 dan teks profil tampil | Lulus |
| 4 | Mengirim formulir dengan data tidak valid melalui HTTP POST | Server menampilkan pesan kesalahan validasi | Lulus |
| 5 | Mengirim formulir dengan data valid melalui HTTP POST | Redirect ke `#hasilKontak` dan data muncul dari session | Lulus |
| 6 | Membuka `indexGet.php` tanpa parameter | Pesan bahwa belum ada data ditampilkan | Lulus |

Catatan: selain pemeriksaan sintaks dengan `php -l` dan `node --check`, halaman diuji menggunakan server bawaan PHP serta permintaan HTTP GET/POST. Pengujian tampilan lintas perangkat dan seluruh interaksi visual tetap perlu diperiksa melalui browser.

## 5. Galat/kendala dan perbaikan

- **Data formulir tidak cukup hanya divalidasi di browser.** Validasi JavaScript dapat dilewati, sehingga pemeriksaan juga ditambahkan di PHP sebelum data disimpan.
- **Data pengguna perlu diamankan saat ditampilkan.** Semua nilai yang berasal dari formulir di-escape menggunakan `htmlspecialchars()`.
- **Parameter GET dapat tidak tersedia.** `indexGet.php` sekarang menggunakan nilai cadangan dan memeriksa apakah parameter telah dikirim.
- **Pengiriman ulang ketika halaman di-refresh.** Setelah data valid disimpan, aplikasi melakukan redirect ke halaman utama (Post/Redirect/Get).

## 6. Cara menjalankan

1. Pastikan PHP 8 atau lebih baru tersedia.
2. Buka terminal pada folder proyek.
3. Jalankan perintah:

   ```bash
   php -S localhost:8000
   ```

4. Buka `http://localhost:8000` pada browser.
5. Isi formulir kontak dan tekan **Kirim** untuk menguji validasi serta penyimpanan session.
6. Untuk melihat contoh metode GET, buka `indexGet.php` setelah mengirim parameter GET atau gunakan formulir uji tersendiri.

## 7. Kesimpulan

Artefak dikembangkan dengan menambahkan pemeriksaan data di sisi server, pengamanan output, pemulihan nilai formulir, dan penanganan parameter GET. Pengujian sintaks PHP telah dilakukan. Pengujian fungsional akhir tetap perlu dijalankan melalui browser/server sebelum URL repositori dikumpulkan.
