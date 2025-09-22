<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aruskas_excel extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master/Master_Aruskas_model');

        // $this->load->model('');
    }

    public function index() {
        $start_date = date("Y-m").'-01';
        $end_date = date("Y-m-d");
    if(!empty($_GET['start']) && !empty($_GET['end'])){
        $start_date = $_GET['start'];
        $end_date = $_GET['end'];

    }
        $view_data['start_date']=$start_date;
        $view_data['end_date']=$end_date; 
        $view_data['date_range'] = format_to_date($start)." - ".format_to_date($end);
        
        $this->template->rander("aruskas_excel/index",$view_data);
    }
    function getId($id){

        if(!empty($id)){
            $kas = array(
                "id" => $id,
            );
            $data = $this->Master_Aruskas_model->get_details($kas)->row();

            echo json_encode(array("success" => true,"data" => $data));
        }else{
            echo json_encode(array('success' => false,'message' => lang('error_occurred')));
        }
    }

    /* open new member modal */

    function modal_form() {
        $this->access_only_admin();

        validate_submitted_data(array(
            "id" => "numeric"
        ));
        $view_data['model_info'] = $this->Master_Aruskas_model->get_one($this->input->post('id'));

        $this->load->view('aruskas_excel/modal_form');
    }

    function modal_form_edit() {
        $this->access_only_admin();

        validate_submitted_data(array(
            "id" => "numeric"
        ));


        $id = $this->input->post('id');
        $kas = array(
            "id" => $id,
        );

        $view_data['model_info'] = $this->Master_Aruskas_model->get_details($kas)->row();

        

        $this->load->view('aruskas_excel/modal_form_edit', $view_data);
    }

    /* save new member */

    function add_kas() {
        $this->access_only_admin();

        //check duplicate email address, if found then show an error message
        

        validate_submitted_data(array(
            "code" => "required"
        ));

        $data = array(
            "code" => $this->input->post('code'),
            "tgl" => $this->input->post('tgl'),
            "ref" => $this->input->post('ref'),
            "uraian" => $this->input->post('uraian'),
            "debet" => $this->input->post('debet'),
            "kredit" => $this->input->post('kredit'),
            "ket" => $this->input->post('ket')

        );
        //add a new team member
        $kas = $this->Master_Aruskas_model->save($data);
        

        if ($kas) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($kas), 'id' => $kas, 'message' => lang('record_saved')));
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
        $debet = unformat_currency($this->input->post('debet'));
        $kredit = unformat_currency($this->input->post('kredit'));
        $data = array(
            "code" => $this->input->post('code'),
            "tgl" => $this->input->post('tgl'),
            "ref" => $this->input->post('ref'),
            "uraian" => $this->input->post('uraian'),
            "debet" => unformat_currency($this->input->post('debet')),
            "kredit" => unformat_currency($this->input->post('kredit')),
            "ket" => $this->input->post('ket'),
        );

        $save_id = $this->Master_Aruskas_model->save($data, $id);
        if ($save_id) {

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id,'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    /* open invitation modal */

    

    //prepere the data for members list
    function list_data($start_date=false,$end_date=false) {
        if(!$start_date)
         $start_date = date("Y-m").'-01';
       if(!$end_date)
         $end_date = date("Y-m-d");
        $list_data = $this->Master_Aruskas_model->get_detailss(array('start_date' => $start_date,'end_date' => $end_date))->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get a row data for member list
    function _row_data($id) {
       $kas = array(
            "id" => $id
        ); 

        $data = $this->Master_Aruskas_model->get_details($kas)->row();
        return $this->_make_row($data);
    }

    //prepare team member list row
    private function _make_row($data) {
        $kas = array(
            "id" => $id
        );
        $kode = array(
            "id" => $code_kas
        );
        $query = $this->Master_Aruskas_model->get_details($kas)->row();
        $queryy = $this->Master_Kode_model->get_details($kode)->row();
        $originalDate = $data->tgl;
        $newDate = date("d-M-Y", strtotime($originalDate));
        $row_data = array(
            $data->tgl,
            $data->ref,
            $queryy->code,
            $queryy->name,
            $queryy->area,
            $data->uraian,
            to_currency ($data->debet),
            to_currency ($data->kredit),
            $data->ket
            // $data->credit_limit,
           
        );

        return $row_data;
    }

    //delete a team member
    function delete() {
        $this->access_only_admin();

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
      
        if ($id != $this->login_user->id && $this->Master_Aruskas_model->delete($id)) {
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

        $view_data['model_info'] = $this->Master_Aruskas_model->get_details($options)->row();

        

        $this->load->view('aruskas_excel/view', $view_data);
    }



}

/* End of file team_member.php */
/* Location: ./application/controllers/team_member.php */