<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class SyncSso extends MY_Controller
{
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        //$getSsoData = $this->get_api('http://localhost/loginssochaakra/api/getUserApp/' . $user_id . '/kas_chaakra_2024');
        $getSsoData = $this->get_api('https://loginsso.chaakra-consulting.com/api/AppController/getUserApp/' . $user_id . '/kas_chaakra_2024');
        $getSsoData = json_decode($getSsoData);

        $data = [
            'sso_data' => $getSsoData
        ];

        $this->template->rander("sync_sso/index", $data);
    }

    public function sync_sso()
    {

        $data = [
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'app_key' => $this->input->post('app_key'),
        ];

        //$cek_user = $this->post_api('http://localhost/loginssochaakra/api/cek_login', $data);
        $cek_user = $this->post_api('https://loginsso.chaakra-consulting.com/api/UserController/cek_login', $data);
        $getRespon = json_decode($cek_user);

        if ($getRespon->success == false) {
            $this->session->set_flashdata('error', 'Akun sso tidak ada');
            redirect('SyncSso');
        } else {
            $create_data = [
                'user_id' => $getRespon->data_user->id,
                'app_key' => 'kas_chaakra_2024',
                'user_app_id' => $this->session->userdata('user_id'),
                'role' => 1,
                'redirect_url' => '-'
            ];

            //$createUserApp = $this->post_api('http://localhost/loginssochaakra/api/createUserApp', $create_data);
            $createUserApp = $this->post_api('https://loginsso.chaakra-consulting.com/api/AppController/createUserApp', $create_data);
            $getResponCreate = json_decode($createUserApp);

            if ($getResponCreate->success) {
                $this->session->set_flashdata('success', 'Akun SSO Berhasil Di Sync');
            } else {
                $this->session->set_flashdata('error', 'Akun SSO Gagal Di Sync');
            }
        }

        redirect('SyncSso');
    }

    function post_api($url, $data)
    {
        // Encode data menjadi JSON
        $postData = http_build_query($data);

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        // Set Header untuk JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Content-Length: ' . strlen($postData)
        ]);

        // Eksekusi request dan mendapatkan hasilnya
        $response = curl_exec($ch);

        // Cek error saat request
        if ($response === false) {
            echo 'Curl error: ' . curl_error($ch);
            curl_close($ch);
            return false;
        }

        curl_close($ch);

        // Kembalikan hasil response
        return $response;
    }

    function get_api($url, $headers = [])
    {
        // Inisialisasi cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        // Set Header jika ada
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        // Eksekusi request dan mendapatkan hasilnya
        $response = curl_exec($ch);

        // Cek error saat request
        if ($response === false) {
            log_message('error', 'Curl error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        // Tutup cURL
        curl_close($ch);

        // Mengembalikan hasil response
        return $response;
    }
}




/* End of file dashboard.php */

/* Location: ./application/controllers/dashboard.php */