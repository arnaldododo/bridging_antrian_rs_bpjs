###################
WS Bridging Antrean RS - BPJS Kesehatan
###################

REST API untuk implementasi sistem bridging terbaru antrian RS ke BPJS Kesehatan dimana pihak Rumah Sakit sebagai penyedia Webservice-nya.

*******************
Pertanyaan ?
*******************

Kami sudah buka tab Discussions untuk mengakomodir pertanyaan.
Dipersilahkan untuk bertanya disini, member lain juga dipersilahkan jika bisa memberikan jawaban.


*******************
Framework
*******************

Implementasi ini menggunakan bahasa pemrograman PHP
Framework yang digunakan adalah Codeigniter versi 3.x


*******
Batasan (Scope)
*******

Code ini berfokus pada implementasi Webservice untuk bridging-nya (wrapper) saja. Adapun untuk sistem antrian-nya dibuat masing-masing Rumah Sakit / di-integrasikan dengan SIM-RS dan tidak tercakup dalam code ini.


*********
Modul WS dan pemanggilan URL
*********

Terdapat 5 modul yang telah diimplementasikan sesuai dengan list dari BPJS Kesehatan.
Dokumentasi spesifikasi WS bisa diminta ke tim IT BPJS Kesehatan (parameter yang perlu dikirim tersedia disini).

1.  Auth (generate token)
	- ``http://localhost/folder_project/antri/auth``
2.  Get nomor antrian (generate)
	- ``http://localhost/folder_project/antri/antrian``
3.  Get rekap antrian
	- ``http://localhost/folder_project/antri/rekap``
4. Get List Jadwal Operasi by nomor peserta
	- ``http://localhost/folder_project/antri/operasi``
5.  Get List Jadwal Operasi by nomor rentang tanggal
	- ``http://localhost/folder_project/antri/jadwaloperasi``

Untuk modul 2 sampai 4 sertakan x-token yang digenerate dari modul 1 pada header saat mengirim request.


***************
Kontribusi
***************

Code ini terbuka untuk kontribusi. Silahkan fork dan kontribusi untuk perbaikan dan pengembangan code ini.
