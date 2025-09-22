<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assets extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master/Master_Asset_model');
        // $this->load->model('');
    }

    public function index() {    

        $this->template->rander("asset/index");
    }

    /* open new member modal */

    function modal_form() {
                
        $this->load->view('asset/modal_form', $view_data);
    }

    function modal_form_edit() {
    
        validate_submitted_data(array(
            "id" => "numeric"
        ));
        $id = $this->input->post('id');
        $asset = array(
            "id" => $id,
        );
        $view_data['model_info'] = $this->Master_Asset_model->get_one($this->input->post('id'));
        $this->load->view('asset/modal_form_edit', $view_data);
    }

    /* save new member */

    function add_asset() {
       
        $foto = $_FILES['foto'];
    if (!empty($foto['name'])) { // Periksa apakah ada file yang diunggah
        $config['upload_path'] = './assets/images/asset';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('foto')) {
            echo json_encode(array("success" => false, 'message' => $this->upload->display_errors()));
            die();
        } else {
            $foto = $this->upload->data('file_name');
        }
    } else {
        $foto = ''; // Atur foto menjadi string kosong jika tidak ada file yang diunggah
    }

        validate_submitted_data(array(
            "code" => "required"
        ));

        $data = array(
            "code" => $this->input->post('code'),
            "name_asset" => $this->input->post('name_asset'),
            "jenis" => $this->input->post('jenis'),
            "spesifikasi" => $this->input->post('spesifikasi'),
            "tahun" => $this->input->post("tahun"),
            "harga_awal" => $this->input->post("harga_awal"),
            "depresiasi" => $this->input->post("depresiasi"),
            "harga_akhir" => $this->input->post("harga_akhir"),
            "pj" => $this->input->post('pj'),
            "status" => $this->input->post('status'),
            "foto"  => $foto,
            "verifikasi" => '0',
        );
        //add a new team member
        $asset = $this->Master_Asset_model->save($data);
        
        if ($asset) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($asset), 'id' => $asset, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    function save() {
        $id = $this->input->post('id');

        validate_submitted_data(array(
            "id" => "numeric",
            "code" => "required"
        ));
        $data = array(
         "code" => $this->input->post('code'),
            "name_asset" => $this->input->post('name_asset'),
            "jenis" => $this->input->post('jenis'),
            "spesifikasi" => $this->input->post('spesifikasi'),
            "tahun" => $this->input->post("tahun"),
            "harga_awal" => $this->input->post("harga_awal"),
            "depresiasi" => $this->input->post("depresiasi"),
            "harga_akhir" => $this->input->post("harga_akhir"),
            "pj" => $this->input->post('pj'),
            "status" => $this->input->post('status'),
            "verifikasi" => '0',
        );

        $save_id = $this->Master_Asset_model->save($data, $id);
        if ($save_id) {

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id,'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    /* open invitation modal */
    private function _row_data($id)
    {
        $options = array(
            "id" => $id
        );
        $data = $this->Master_Asset_model->get_details($options)->row();
        return $this->_make_row($data);
    }
    

    //prepere the data for members list
    function list_data() {
       
        $list_data = $this->Master_Asset_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get a row data for member list
    //prepare team member list row
    private function _make_row($data) {
        $options = array(
            "id" => $data->id
        );
    
        // Menetapkan nilai variabel $status_text berdasarkan kondisi $data->status
        if ($data->status == 'Pinjam') {
            $status_text = '<span style="color: blue; font-weight: bold;">'.$data->status.'</span>';
        } elseif ($data->status == 'Dikembalikan') {
            $status_text = '<span style="color: green; font-weight: bold;">'.$data->status.'</span>';
        } else {
            $status_text = $data->status; // Jika nilai tidak sama dengan 'Pinjam' atau 'Dikembalikan'
        }
    
        // Mengisi nilai array $row_data dengan nilai-nilai yang telah ditetapkan sebelumnya
        $row_data = array(
            $data->code,
            $data->name_asset,
            $data->jenis,
            $data->spesifikasi,
              ($data->tahun == null ? "tahun perlu di update" :  $data->tahun),
            "Rp. " . number_format(($data->harga_awal == null ? "0" : $data->harga_awal)),
            "Rp. " . number_format(($data->depresiasi == null ? "0" : $data->depresiasi)),
            "Rp. " . number_format(($data->harga_akhir == null ? "0" : $data->harga_akhir)),
            "<a href='' class='cek-depresiasi' data-code='" . $data->code . "' data-nama_asset='" . $data->name_asset . "' data-jenis='" . $data->jenis . "' data-spesifikasi='" . $data->spesifikasi . "' data-tahun='" . $data->tahun . "' data-harga_awal='Rp. " . number_format(($data->harga_awal == null ? "0" : $data->harga_awal)) . "' data-depresiasi='Rp. " . number_format(($data->depresiasi == null ? "0" : $data->depresiasi)) . "' data-harga_akhir='Rp. " . number_format(($data->harga_akhir == null ? "0" : $data->harga_akhir)) . "' data-toggle='modal' data-target='#exampleModal'>Prediksi Depresiasi</a>",
            "<a href=JavaScript:newPopup('https://bukukas.chaakra-consulting.com/assets/images/asset/".$data->foto."');><img src=https://bukukas.chaakra-consulting.com/assets/images/asset/".$data->foto." width='100' height='100'></a>",
            $data->pj,
            $status_text // Menggunakan variabel $status_text di sini
        );
    
        // Lanjutan dari proses lainnya...
    
        if ($data->status == 'Dikembalikan') {
            $row_data[] = ''; // Mengosongkan elemen array untuk menyembunyikan tombol edit dan delete
        } else {
            // Menambahkan tombol edit dan delete
            $row_data[] = modal_anchor(get_uri("master/assets/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit_item'), "data-post-id" => $data->id))
                . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("master/assets/delete"), "data-action" => "delete"));
        }
    
    return $row_data;
    }

    //delete a team member
    function delete() {
        $this->access_only_admin();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
      
        if ($id != $this->login_user->id && $this->Master_Asset_model->delete($id)) {
            echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
        }
    }

    function view(){
        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );
        $view_data['model_info'] = $this->Master_Asset_model->get_details($options)->row();

        

        $this->load->view('asset/view', $view_data);
    }



}

/* End of file team_member.php */
/* Location: ./application/controllers/team_member.php */