TO DO

25 September 2020

-   1 transaksi bisa lebih dari 1 voucher
-   biaya administrasi dihapus
-   nominal pelunasan diganti menjadi 'detail tabungan'
-   tambahkan duma points

UseCase Admin MyDuma:
A. Pendaftaran Haji 1. Melihat semua data pendaftaran haji 2. Mengedit data pendaftaran haji & statusnya (termasuk upload lampiran) 3. Melihat list jamaah dari customer 4. Chat dengan customer ataupun kbih
B. Tabungan Umrah
C. Tabungan Haji

TO DO API Admin

1. api admin

TO DO Mobile Admin

1. List Menu Admin
2. All Status Pendaftaran Haji Muda dengan total pendaftarannya
3. List Pendaftaran Haji Per Jamaah By Status Pendaftaran Haji
4. Detail Pendaftaran Haji
   a. KBIH
   b. Jamaah
   c. status pendaftaran
   d. Diverifikasi oleh X pada tanggal X
   e. Nominal Talangan, Nominal Administrasi, Nominal Terbayar
   f. Nominal administrasi, tanggal terakhir bayar administrasi, tanggal bayar administrasi
   g. Nominal talangan, tanggal terakhir pelunasan talangan, (list riwayat pembayaran)
   h. Tahun Berangkat
   i. Nomor Porsi
   j. Catatan admin
   k. Catatan kbih
   l. Catatan jamaah
   m. Tanggal setor BPS-BPIH

5. Edit Data Jamaah
6. Ubah Status Pendaftaran Haji

Flow daftar tabungan haji:

1. Isi form dll
2. Pilih kbih
3. Bayar
4. Get contacted sama kbih
5. Scheduling
6. Dapat nomer porsi

Yang perlu disiapkan:

-   CRUD KBIH di web
-   API list KBIH yang available
-   Tabel rencana_haji
-   Api create,update,delete,gets,detail rencana_haji

Alur pendaftaran haji

1. UserGanteng mengisi form pendaftaran haji di aplikasi, kemudian mengirimnya
2. AdminSantun menerima notifikasi pendaftaran haji baru oleh UserGanteng di MyDuma, kemudian melakukan pengecekan data dan ketersediaan dana talangan
3. AdminSantun mengAccept pendaftaran haji UserGanteng, dengan mengisi nominal talangan yang diberikan, beserta tanggal terakhir biaya administrasi & layanan (disamakan)
4. UserGanteng menerima notifikasi bahwa pendaftaran haji di MyDuma telah diAcc
5. UserGanteng melakukan transfer sejumlah (nominal total - nominal talangan) sebagai pelunasan awal sebelum tanggal terakhir minimum pelunasan
6. AdminSantun menerima notifikasi bahwa pelunasan awal telah diselesaikan oleh UserGanteng
7. AdminSantun mengirim form pendaftaran haji ke TimPengurusHaji, yang kemudian mengurus pendaftaran haji UserGanteng ke pihak terkait
8. TimPengurusHaji menginfokan ke AdminSantun (diluar sistem) bahwa UserGanteng berhasil daftar haji dan memperoleh nomor porsi
9. AdminSantun mengupdate data (tahun berangkat, status pendaftaran, tanggal terakhir pelunasan penuh) daftar haji UserGanteng di MyDuma
10. UserGanteng menerima notifikasi bahwa nomor porsi sudah didapat.
11. Selesai

Tabel daftar_haji

-   id
-   jamaah_id
-   kbih_id
-   status_pendaftaran_id
-   nominal_total (nullable)
-   nominal_talangan
-   terakhir_pelunasan_awal
-   terakhir_pelunasan_penuh
-   tahun_berangkat (nullable)
-   nomor_porsi (nullable)

Tabel pelunasan_haji

-   id
-   daftar_haji_id
-   nominal
-   catatan

Tabel daftar_haji_log

-   id
-   daftar_haji_id
-   updated_by_id
-   updated_by_name
-   status_pendaftaran_id_before
-   status_pendaftaran_id_after
-   catatan

Tabel daftar_haji_lampiran

-   id
-   daftar_haji_id
-   file_id

DAFTAR UMRAH
Alur Pendaftaran Umrah

1. User mengisi form pendaftaran umrah, yaitu sbb:
   a. paket tabungan umrah
   b. tahun berangkat
   c. agen_umrah
2. AdminMyDuma menerima notifikasi pendaftaran umrah baru, dan tidak melakukan apa2
3. User membuka menu riwayat pendaftaran umrah. Kemudian melakukan proses menabung,
4.

Tabel daftar_umrah

-   id
-   nominal_tabungan
-   tahun_rencana_berangkat
-   agen_umrah_id
-   status_pendaftaran_umrah_id

Pertanyaan :
A. Pendaftaran Haji

1. Apakah biaya administrasi dibayar diawal ketika mendaftar atau setelah pendaftaran haji diacc oleh sisprohat?
   Betul
2. Penentuan biaya admin ditentukan oleh siapa?
   Oleh sistem, semua biaya admin sama
3. Pembayarannya menggunakan apa?
   Belum tau
4. Ketika admin sisprohat mendapatkan info bahwa pendaftaran haji berhasil dan mendapatkan nomor porsi.
   Bagaimana format nomor porsinya?
   String dan perlu upload lampiran
5. Ketika admin sisprohat mengacc pendaftaran haji user, apa saja yang diinputkan?
   Admin sisprohat tidak melakukan apa2
6. Perlukah ada tanggal akhir pelunasan pendaftaran haji?
   7 tahun setelah di acc (Hanya biaya awal booking nomor porsi)
7. Apakah pendaftaran haji bisa ditolak oleh MyDuma?
   Bisa
8. Apakah pendaftaran haji yang sudah di acc bisa dibatalkan oleh salah satu pihak?
   Bisa
9. Bagaimana proses pembatalan pendaftaran haji oleh user yang :
   a. sudah diacc sisprohat
   b. sudah mendapat nomor porsi
   Masih dibicarakan

B. Pendaftaran Umrah

1. Apakah daftar umrah tidak perlu memilih bulan berangkat?

2.

-   Saat pengisian form jamaah
-   Kirim ke sisprohat setelah mendapatkan nomor porsi
-   ketika milih kbih, diurutkan kbih terdekat
-   kbih bertugas melayani jamaah
-   kbih akan menghubungi user setelah pendaftaran di acc oleh admin & setelah pelunasan biaya administrasi.
-   kbih akan mengupdate nomor porsi dan upload lampiran
-   Saat nomor porsi sudah keluar dan dikirim ke sisprohat, dana nya udah terserap
-   Ada minimal tabungan perbulan (150ribuan)
-   daftar umrah tahunnya bebas
