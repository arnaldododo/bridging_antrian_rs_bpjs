<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';

use Restserver\Libraries\REST_Controller;

class Antri extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['jwt', 'authorization']);
        $this->load->model('antrian');
        $this->load->database();
    }

    private function gagal($pesan = 'Anda tidak memiliki akses / Layanan tidak tersedia.')
    {
        $status = parent::HTTP_UNAUTHORIZED;
        $response = array(
            'metadata' => array(
                'message' => $pesan,
                'code' => $status
            )
        );
        $this->response($response, $status);
    }

    /* cek jumlah isi hasil query database */
    private function check($data)
    {
        $obj = new stdClass;
        if (count($data) == 0) {
            $obj->status = false;
            $obj->message = "Data tidak tersedia!";
        } else {
            $obj->status = true;
        }
        return $obj;
    }

    /* get token */
    public function auth_get()
    {
        // Get all the headers
        $headers = $this->input->request_headers();
        // Extract the token
        $header_user = $headers['username'];
        $header_pass = $headers['password'];

        // Check if valid user
        $hasil_cek = $this->antrian->auth($header_user, $header_pass);
        $hasil = $this->check($hasil_cek);
        if ($hasil->status) {
            // Create a token from the user data and send it as reponse
            $isitoken = array(
                'isi_token' => array(
                    'user' => $header_user,
                    'pass' => $header_pass,
                    'tipe' => 'Antrian mobile JKN BPJS Kesehatan'
                )
            );
            $token = AUTHORIZATION::generateToken($isitoken);
            // Prepare the response
            $status = parent::HTTP_OK;
            $response = array(
                'response' => array(
                    'token' => $token
                ),
                'metadata' => array(
                    'message' => 'ok',
                    'code' => $status
                )
            );
            $this->response($response, $status);
        } else {
            $this->gagal();
        }
    }

    public function antrean_post()
    {
        // Get all the headers
        $headers = $this->input->request_headers();
        // Extract the token
        $header_token = $headers['x-token'];
        /* parameter dikirim post */
        $nomorkartu = $this->post('nomorkartu');
        $nik = $this->post('nik');
        $notelp = $this->post('notelp');
        $tanggalperiksa = $this->post('tanggalperiksa');
        $kodepoli = $this->post('kodepoli');
        $nomorreferensi = $this->post('nomorreferensi');
        $jenisreferensi = $this->post('jenisreferensi');
        $jenisrequest = $this->post('jenisrequest');
        $polieksekutif = $this->post('polieksekutif');

        // Use try-catch
        // JWT library throws exception if the token is not valid
        try {
            // Validate the token
            // Successfull validation will return the decoded user data else returns false
            $token = AUTHORIZATION::validateToken($header_token);
            if ($token === false) {
                $this->gagal();
                exit();
            } else {
                /* kalau token valid lanjut disini */

                /* cek apakah peserta sudah terdaftar sebelumnya */
                $noantrian = $this->antrian->cek_terdaftar($nomorkartu, $kodepoli, $tanggalperiksa);
                $ceknoantrian = $this->check($noantrian);
                if ($ceknoantrian->status === true) {
                    $this->gagal('Anda sudah terdaftar antrian.');
                    exit();
                }
                $poli = $this->antrian->get_poli($kodepoli);
                $cekpoli = $this->check($poli);
                if ($cekpoli->status === false) {
                    $this->gagal('Poli tidak tersedia.');
                    exit();
                }

                $terakhir = $this->antrian->get_antrian_terakhir($kodepoli, $tanggalperiksa);
                $cek_antrianterakhir = $this->check($terakhir);
                if ($cek_antrianterakhir->status === false) {
                    $angkaantrian = 1;
                } else {
                    $angkaantrian = intval($terakhir[0]->no_antrian + 1);
                }
                $nomorantrean = $poli[0]->kode_antri . $angkaantrian;

                $estimasi = $this->antrian->get_estimasi($kodepoli, $tanggalperiksa);

                $kodebooking = $this->antrian->input($angkaantrian, $nomorkartu, $nik, $notelp, $tanggalperiksa, $kodepoli, $nomorreferensi, $jenisreferensi, $jenisrequest, $polieksekutif);

                $status = parent::HTTP_OK;
                $response = array(
                    'response' => array(
                        'nomorantrean' => $nomorantrean,
                        'kodebooking' => $kodebooking,
                        'jenisantrean' => $jenisrequest,
                        'estimasidilayani' => $estimasi,
                        'namapoli' => $poli[0]->nama_poli,
                        'namadokter' => ''
                    ),
                    'metadata' => array(
                        'message' => 'ok',
                        'code' => $status
                    )
                );
                $this->response($response, $status);
            }
        } catch (Exception $e) {
            // Token is invalid
            // Send the unathorized access message
            $this->gagal();
        }
    }
}
/* End of file Antri.php */
