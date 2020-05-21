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
    public function auth_post()
    {
        // Get all the headers
        $headers = $this->input->request_headers();
        // Extract the token
        $user = $this->post('username');
        $pass = $this->post('password');

        // Check if valid user
        $hasil_cek = $this->antrian->auth($user, $pass);
        $hasil = $this->check($hasil_cek);
        if ($hasil->status) {
            // Create a token from the user data and send it as reponse
            $isitoken = array(
                'isi_token' => array(
                    'user' => $user,
                    'pass' => $pass,
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

    /* get no antrean */
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

    /* get rekap antrian */
    public function rekap_post()
    {
        // Get all the headers
        $headers = $this->input->request_headers();
        // Extract the token
        $header_token = $headers['x-token'];
        /* parameter dikirim post */
        $tanggalperiksa = $this->post('tanggalperiksa');
        $kodepoli = $this->post('kodepoli');
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

                $poli = $this->antrian->get_poli($kodepoli);
                $cekpoli = $this->check($poli);
                if ($cekpoli->status === false) {
                    $this->gagal('Poli tidak tersedia.');
                    exit();
                }

                $belum_dilayani = $this->antrian->get_dilayani($kodepoli, $tanggalperiksa);
                $cek_belum_dilayani = $this->check($belum_dilayani);
                if ($cek_belum_dilayani->status === false) {
                    $belum_dilayani = '0';
                } else {
                    $belum_dilayani = $belum_dilayani[0]->jml;
                }
                $sudah_dilayani = $this->antrian->get_dilayani($kodepoli, $tanggalperiksa, '1');
                $cek_sudah_dilayani = $this->check($sudah_dilayani);
                if ($cek_sudah_dilayani->status === false) {
                    $sudah_dilayani = '0';
                } else {
                    $sudah_dilayani = $sudah_dilayani[0]->jml;
                }

                $lastupdate = $this->antrian->get_estimasi($kodepoli, date('Y-m-d'));

                $status = parent::HTTP_OK;
                $response = array(
                    'response' => array(
                        'namapoli' => $poli[0]->nama_poli,
                        'totalantrean' => $belum_dilayani,
                        'jumlahterlayani' => $sudah_dilayani,
                        'lastupdate' => $lastupdate,

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
