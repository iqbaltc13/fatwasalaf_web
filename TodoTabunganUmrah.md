Alur tabungan umrah aplikasi MyDuma
1. Pendaftar mengisi form tabungan umrah, yaitu: 
	a. Data Nasabah 
		- Nama
		- Email
		- Nomor HP
		- Nomor HP Alternatif
		- Nomor KTP
		- Alamat
		- Nama Ibu
		- Tempat lahir
		- Tanggal lahir
	b. Tahun Berangkat
	c. Paket Tabungan
2. Sistem memverifikasi form pendaftaran dan mengcreate Virtual Account
3. Pendaftar melakukan transfer biaya administrasi sejumlah nominal yang sudah ditentukan oleh super-admin ke rekening virtual account yang sudah dibuat untuk pendaftar.
4. Pendaftar melakukan proses menabung, dengan melakukan transfer ke VA tersebut
5. Jika tabungan sudah mencapai >80%, pendaftar melakukan fiksasi data terkait keberangkatan umrahnya, yaitu : 
	a. Biro Umrah
	b. Paket Umrah
		- harga final
		- fasilitas
		- list hotel yang disewa
		- durasi di mekkah
		- durasi di madinah
		- tanggal berangkat
		- pesawat pergi
		- pesawat pulang
	c. Data Jamaah (dan lampirannya)

Yang perlu disiapkan oleh admin : 
1. Master Paket Tabungan
2. Master Biro Umrah
3. Master Paket Umrah


TABEL
jenis_pembayaran
- id
- name (biaya_administrasi, tabungan)
- display_name
- note

nasabah
- id
- jenis_layanan_id
- customer_id
- nomor_va (unique)
- nomor_ktp
- email
- nomor_hp
- alamat
- nama_ibu
- tempat_lahir
- tanggal_lahir

pembayaran
- id
- nasabah_id
- jenis_pembayaran_id
- $table->morphs('pembayaran');
	- pembayaranable_id
	- pembayaranable_type (tabungan_umrah,tabungan_haji,haji_muda)
- nominal_diisi_customer
- nominal
- catatan
- verified_at
- verified_by_id
- verified_by_name
- customer_id
- lampiran_customer_id

paket_tabungan_umrah
- id
- nama
- nominal_tabungan
- biaya_administrasi
- catatan
- is_default
- created_by_name
- last_updated_by_name

tabungan_umrah
- id
- user_id
- nasabah_id
- tanggal_berangkat
- paket_tabungan_umrah_id
- nominal_tabungan
- biaya_administrasi
- catatan
- status_tabungan_umrah_id
- catatan_customer
- catatan_admin
- last_updated_by_name

tabungan_haji
- id
- nasabah_id
- tahun_berangkat
- nominal_tabungan
- biaya_administrasi
- status_tabungan_haji_id
- catatan_customer
- catatan_admin
- last_updated_by_name


Catatan : 
- Nasabah diganti dengan 'Duma Friend'
- 


