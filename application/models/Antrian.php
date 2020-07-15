<?php
class Antrian extends CI_Model
{
    public function auth($username, $password)
    {
        /* encode dulu username nya, karena di db di encrypt */
        $username = base64_encode($username);
        $password = base64_encode($password);
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
    }

    public function cek_terdaftar($nomorkartu, $kodepoli, $tgl_periksa)
    {
        $this->db->where('no_peserta', $nomorkartu);
        $this->db->where('poli', $kodepoli);
        $this->db->where('tgl_periksa', $tgl_periksa);
        $this->db->from('antrian');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_poli($kodepoli)
    {
        $this->db->where('kode_poli', $kodepoli);
        $this->db->from('poli');
        $query = $this->db->get();
        return $query->result();
    }

    public function input($no_antrian, $nomorkartu, $nik, $notelp, $tanggalperiksa, $kodepoli, $nomorreferensi, $jenisreferensi, $jenisrequest, $polieksekutif)
    {
        $data = array(
            'no_antrian' => $no_antrian,
            'no_peserta' => $nomorkartu,
            'nik' => $nik,
            'notelp' => $notelp,
            'tgl_periksa' => $tanggalperiksa,
            'poli' => $kodepoli,
            'no_referensi' => $nomorreferensi,
            'jns_referensi' => $jenisreferensi,
            'jns_req' => $jenisrequest,
            'poli_eksekutif' => $polieksekutif,
        );
        $this->db->insert('antrian', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function get_estimasi($kodepoli, $tanggalperiksa)
    {
        /* perhitungan estimasi disesuaikan sendiri dengan sistem antrian RS */
        date_default_timezone_set('Asia/Jakarta');
        $stamp = strtotime($tanggalperiksa);
        $time_in_ms = $stamp * 1000;
        return $time_in_ms;
    }

    public function get_antrian_terakhir($kodepoli, $tanggalperiksa)
    {
        $this->db->select('no_antrian');
        $this->db->where('poli', $kodepoli);
        $this->db->where('tgl_periksa', $tanggalperiksa);
        $this->db->order_by('no_antrian', 'DESC');
        $this->db->limit(1);
        $this->db->from('antrian');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_dilayani($kodepoli, $tanggalperiksa, $layan = '0')
    {
        $this->db->select('count(*) as jml');
        $this->db->where('poli', $kodepoli);
        $this->db->where('tgl_periksa', $tanggalperiksa);
        $this->db->where('poli_eksekutif', '0');
        $this->db->where('sudah_dilayani', $layan);
        $this->db->group_by('sudah_dilayani');
        $this->db->from('antrian');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_kodebooking_op($nopeserta)
    {
        $this->db->where('nopeserta', $nopeserta);
        $this->db->where('terlaksana', 0);
        $this->db->from('jadwal_operasi');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_list_op($tanggal_awal, $tanggal_akhir)
    {
        $this->db->where('tanggaloperasi >= ', $tanggal_awal);
        $this->db->where('tanggaloperasi <= ', $tanggal_akhir);
        $this->db->from('jadwal_operasi');
        $query = $this->db->get();
        return $query->result();
    }
}
