###################
WS Bridging Antrean RS - BPJS Kesehatan
###################

REST API untuk implementasi sistem bridging terbaru antrian RS ke BPJS Kesehatan dimana pihak Rumah Sakit sebagai penyedia Webservice-nya.

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
Modul WS
*********

Terdapat 5 modul yang telah diimplementasikan sesuai dengan list dari BPJS Kesehatan. (Dokumentasi bisa diminta ke tim IT BPJS Kesehatan).

-  Auth (generate token)
-  Get nomor antrian (generate)
-  Get rekap antrian
-  Get List Jadwal Operasi by nomor peserta
-  Get List Jadwal Operasi by nomor rentang tanggal


***************
Kontribusi
***************

Code ini terbuka untuk kontribusi. Silahkan fork dan kontribusi untuk perbaikan dan pengembangan code ini.
