<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class P_invoices extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('purchase/Purchase_Invoices_model');
        $this->load->model('purchase/Purchase_InvoicesItems_model');
    }

    function index() {
        $start_date = date("Y-m").'-01';
            $end_date = date("Y-m-d");
        if(!empty($_GET['start']) && !empty($_GET['end'])){
            $start_date = $_GET['start'];
            $end_date = $_GET['end'];

        }
            $view_data['start_date']=$start_date;
            $view_data['end_date']=$end_date; 
            $code = isset($_GET['code']) ? $_GET['code'] : '501 - Operasional';
        $this->template->rander("invoice/index",$view_data);
    }  
    
    function gaji() {
        $year = date("Y");
        // $end_date = date("Y-m-d");
        if(!empty($_GET['year'])){
            $year = $_GET['year'];

        }
            $view_data['year']=$year; 
        $this->template->rander("invoice/gaji",$view_data);
    }  
    
    /* load client add/edit modal */

    function modal_form() {
        //get custom fields

        $view_data['model_info'] = $this->Purchase_Invoices_model->get_one($this->input->post('id'));
        $view_data['clients_dropdown'] = array("" => "-") + $this->Master_Vendors_model->get_dropdown_list(array("name"));
        $this->load->view('invoice/modal_form',$view_data);
    }

    function modal_form_edit() {
        validate_submitted_data(array(
            "id" => "numeric"
        ));
    
        $id = $this->input->post('id');
        $options = array("id" => $id);
            
        $model_info = $this->Purchase_Invoices_model->get_details($options)->row();
    
        if (!empty($model_info->bukti)) {
            $model_info->bukti_url = "https://bukukas.chaakra-consulting.com/assets/images/bukti/" . $model_info->bukti;
        } else {
            $model_info->bukti_url = "";
        }
    
        $view_data['model_info'] = $model_info;
        $view_data['clients_dropdown'] = array("" => "-") + $this->Master_Vendors_model->get_dropdown_list(array("name"));
     
        $this->load->view('invoice/modal_form_edit', $view_data);
    }
    
    function posting_modal_form() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));


        $id = $this->input->post('id');
        $options = array(
            "id" => $id,
        );


        $view_data = get_p_invoices_making_data($id);
        //$view_data['bank_dropdown'] = $this->Master_Coa_Type_model->getCoaDrop('account_number','1101');     
        $view_data['model_info'] = $this->Purchase_Invoices_model->get_details($options)->row();
       
        

        $this->load->view('invoice/posting_modal_form', $view_data);
    }

    /* insert or update a client */

    function add() {
        validate_submitted_data(array(
            "code" => "required",
            //"fid_vendor" => "required"
        ));
        $foto = $_FILES['foto'];
    if (!empty($foto['name'])) { // Periksa apakah ada file yang diunggah
        $config['upload_path'] = './assets/images/bukti';
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

        $data = array(
            "code" => $this->input->post('code'),
            //"fid_vendor" => $this->input->post('fid_vendor'),
            "memo" => $this->input->post('memo'),
            "bukti" => $foto,
           // "fid_quot" => $this->input->post('fid_quot'),
            //"inv_address" => $this->input->post('inv_address'),
            //"delivery_address" => $this->input->post('delivery_address'),
            "status" => 'draft',
            "paid" => "Not Paid",
            //"email_to" => $this->input->post('email_to'),
            "inv_date" => $this->input->post('inv_date'),
            //"end_date" => $this->input->post('end_date'),
            
            //"currency" => $this->input->post('currency'),
            //"fid_tax" => $this->input->post('fid_tax'),
            "created_at" => date("Y-m-d H:i:s")
        );

       
           $save_id = $this->Purchase_Invoices_model->save($data);
            
            if($save_id){
                
                    echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id,'message' => lang('record_saved')));
                
            }else{
                 echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
            }
        }
    

    function save() {
        $customers_id = $this->input->post('id');
        
        $foto = $_FILES['foto'];
        if (!empty($foto['name'])) { // Periksa apakah ada file yang diunggah
            $config['upload_path'] = './assets/images/bukti';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
    
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto')) {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode(array("success" => false, 'message' => $error['error']));
                die();
            } else {
                $foto = $this->upload->data('file_name');
            }
        } else {
            $foto = ''; // Atur foto menjadi string kosong jika tidak ada file yang diunggah
        }

        validate_submitted_data(array(
            "code" => "required",
           // "fid_vendor" => "required"
        ));
        $data = array(
            "code" => $this->input->post('code'),
            //"fid_vendor" => $this->input->post('fid_vendor'),
            "memo" => $this->input->post('memo'),
            "bukti" => $foto,
            //"fid_custt" => $this->input->post('fid_custt'),
            // "fid_order" => $this->input->post('fid_order'),
            //"inv_address" => $this->input->post('inv_address'),
            //"delivery_address" => $this->input->post('delivery_address'),
            //"end_date" => $this->input->post('end_date'),
            //"email_to" => $this->input->post('email_to'),
            "inv_date" => $this->input->post('inv_date'),
            //"fid_tax" => $this->input->post('fid_tax'),
            //currency" => $this->input->post('currency')
        );


        $save_id = $this->Purchase_Invoices_model->save($data, $customers_id);
        if ($save_id) {

          
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id,'message' => lang('record_saved')));
               
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }
    
    function save_edit() {
        $customers_id = $this->input->post('id');
    
        $foto = null;
    
        // Jika ada file baru diupload
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './assets/images/bukti';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
    
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('foto')) {
                echo json_encode(array("success" => false, 'message' => $this->upload->display_errors()));
                return;
            } else {
                $foto = $this->upload->data('file_name');
            }
        } else {
            // Ambil data lama dari get_details jika tidak ada upload baru
            $existing = $this->Purchase_Invoices_model->get_details(["id" => $customers_id])->row();
            $foto = $existing ? $existing->bukti : '';
        }
    
        validate_submitted_data(array(
            "code" => "required",
        ));
    
        $data = array(
            "code" => $this->input->post('code'),
            "memo" => $this->input->post('memo'),
            "bukti" => $foto,
            "inv_date" => $this->input->post('inv_date'),
        );
    
        $save_id = $this->Purchase_Invoices_model->save($data, $customers_id);
        if ($save_id) {
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }
    
    /* delete or undo a client */

    function delete() {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Purchase_Invoices_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Purchase_Invoices_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    /* verifikasi or undo a client */

    function verifikasi($id){  
            $this->Purchase_Invoices_model->verifikasi($id);
            redirect(base_url().'purchase/p_invoices');
        }

    function bayar($id){  
            $this->Purchase_Invoices_model->bayar($id);
            redirect(base_url().'purchase/p_invoices');
        }
    /* list of clients, prepared for datatable  */

    function list_data($start_date = false, $end_date = false) {
        if (!$start_date) {
            $start_date = date("Y-m");
        }
    
        if (!$end_date) {
            $end_date = date("Y-m-d");
        }
    
        // Ambil nilai account_number dari request atau parameter yang sesuai
        $account_number = $this->input->get('account_number');
    
        $list_data = $this->Purchase_Invoices_model->get_details(array(
            'start_date' => $start_date,
            'end_date' => $end_date,
            'account_number' => $account_number
        ))->result();
    
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
    
        echo json_encode(array("data" => $result));
    }
    
    // function list_data_gaji($start_date = false, $end_date = false) {
    function list_data_gaji($year = false) {
        // if (!$start_date) {
        //     $start_date = date("Y-m");
        // }
    
        // if (!$end_date) {
        //     $end_date = date("Y-m-d");
        // }

        if (!$year) {
            $year = date("Y");
        }
    
        $list_data = $this->Purchase_Invoices_model->get_details_gaji(array(
            'year' => $year,
            // 'start_date' => $start_date,
            // 'end_date' => $end_date,
        ))->result();
    
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row_gaji($data);
        }
    
        echo json_encode(array("data" => $result));
    }
    

    /* return a row of client list  table */

    private function _row_data($id) {
        $options = array(
            "id" => $id
        );
        $data = $this->Purchase_Invoices_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    /* prepare a row of client list table */

    private function _make_row($data) {
        $options = array(
            "id" => $data->fid_vendor
        );        
        $query = $this->Master_Vendors_model->get_details($options)->row();
        $value = $this->Purchase_Invoices_model->get_invoices_total_summary($data->id);
        $originalDate = $data->inv_date;
        $newDate = date("d-M-Y", strtotime($originalDate));
        $row_data = array(
            $data->inv_date,
            $data->memo,
            "<a href=JavaScript:newPopup('https://bukukas.chaakra-consulting.com/assets/images/bukti/".$data->bukti."');><img src=https://bukukas.chaakra-consulting.com/assets/images/bukti/".$data->bukti." width='100' height='100'></a>",
            anchor(get_uri("purchase/p_invoices/view/" . $data->id), "#".$data->code),
            to_currency($value->invoice_subtotal),
            $this->_get_invoices_status_label($data),
            $this->_get_invoices_paid_label($data),
        );

        if($data->status != "paid" AND $data->status != "posting" AND $data->is_verified == "0"){
           $row_data[] = modal_anchor(get_uri("purchase/p_invoices/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => 'Edit Pengeluaran', "data-post-id" => $data->id))
                . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_client'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("purchase/p_invoices/delete"), "data-action" => "delete"))
                .anchor(get_uri("purchase/p_invoices/verifikasi/").$data->id, "<i class='fa fa-check'></i>", array("class" => "view", "title" => "Verifikasi Purchase Order", "data-post-id" => $data->id));;

        }
        if($data->paid != "PAID"){
        $row_data[] = anchor(get_uri("purchase/p_invoices/bayar/").$data->id, "<i class='fa fa-money'></i>", array("class" => "view", "title" => "Pay", "data-post-id" => $data->id))
        .anchor(get_uri("purchase/p_invoices/view/").$data->id, "<i class='fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id))
        . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_client'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("purchase/p_invoices/delete"), "data-action" => "delete"));
        }
        $row_data[] = anchor(get_uri("purchase/p_invoices/view/").$data->id, "<i class='fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id))
        . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_client'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("purchase/p_invoices/delete"), "data-action" => "delete"));

        return $row_data;
    }
    
    
    private function _make_row_gaji($data) {
        $options = array(
            "id" => $data->fid_vendor
        );        
        $query = $this->Master_Vendors_model->get_details($options)->row();
        $value = $this->Purchase_Invoices_model->get_invoices_total_summary($data->id);
        $originalDate = $data->inv_date;
        $newDate = date("d-M-Y", strtotime($originalDate));
        $row_data = array(
            $data->inv_date,
            date('F', strtotime($data->inv_date)),
            date('Y', strtotime($data->inv_date)),
            $data->memo,
            to_currency($value->invoice_subtotal),
            // $this->_get_invoices_status_label($data),
            // $this->_get_invoices_paid_label($data),
        );
        

        if($data->status != "paid" AND $data->status != "posting" AND $data->is_verified == "0"){
           $row_data[] = modal_anchor(get_uri("purchase/p_invoices/modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => 'Edit Pengeluaran', "data-post-id" => $data->id))
                . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_client'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("purchase/p_invoices/delete"), "data-action" => "delete"))
                .anchor(get_uri("purchase/p_invoices/verifikasi/").$data->id, "<i class='fa fa-check'></i>", array("class" => "view", "title" => "Verifikasi Purchase Order", "data-post-id" => $data->id));;

        }
        if($data->paid != "PAID"){
        $row_data[] = anchor(get_uri("purchase/p_invoices/bayar/").$data->id, "<i class='fa fa-money'></i>", array("class" => "view", "title" => "Pay", "data-post-id" => $data->id))
        .anchor(get_uri("purchase/p_invoices/view/").$data->id, "<i class='fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id))
        . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_client'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("purchase/p_invoices/delete"), "data-action" => "delete"));
        }
        $row_data[] = 
        // anchor(get_uri("purchase/p_invoices/view/").$data->id, "<i class='fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id))
        js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete_client'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("purchase/p_invoices/delete"), "data-action" => "delete"));

        return $row_data;
    }

    function view($id= 0){
        
        if ($id) {
            $view_data = get_p_invoices_making_data($id);

            if ($view_data) {
                $view_data['invoice_status'] = $this->_get_invoices_status_label($view_data["invoice_info"], true);
                
                $view_data['invoice_status_label'] = $this->_get_invoices_status_label($view_data["invoice_info"]);

                $this->template->rander("invoice/view", $view_data);
            } else {
                show_404();
            }
        }else{
            show_404();
        }
    }

     //prepare invoice status label 
     private function _get_invoices_status_label($invoice_info, $return_html = true) {
        // return get_order_status_label($data, $return_html);
        $invoice_status_class = "label-default";
        $status = "draft";
        $now = get_my_local_time("Y-m-d");
        if ($invoice_info->status == "draft" ) {
            $invoice_status_class = "label-warning";
            $status = "Draft";
        } else if ($invoice_info->status == "sent") {
            $invoice_status_class   = "label-success";
            $status = "Sudah Terkirim";

        }
        else if ($invoice_info->status == "terbayar") {
            $invoice_status_class   = "label-primary";
            $status = "Terbayar";

        }
        else if ($invoice_info->status == "terverifikasi") {
            $invoice_status_class   = "label-success";
            $status = "Terverifikasi";

        }
        $invoice_status = "<span class='label $invoice_status_class large'>" . $status . "</span>";
        if ($return_html) {
            return $invoice_status;
        } else {
            return $status;
        }
    }
    
    private function _get_invoices_paid_label($invoice_info, $return_html = true) {
        // return get_order_status_label($data, $return_html);
        $invoice_status_class = "label-default";
        $paid = "Not Paid";
        $now = get_my_local_time("Y-m-d");
        if ($invoice_info->paid == "draft" ) {
            $invoice_status_class = "label-warning";
            $status = "Draft";
        } else if ($invoice_info->paid == "Not Paid") {
            $invoice_status_class   = "label-danger";
            $paid = "Belum Dibayar";

        }
        else if ($invoice_info->paid == "PAID") {
            $invoice_status_class   = "label-primary";
            $paid = "Dibayar";

        }
        $invoice_status = "<span class='label $invoice_status_class large'>" . $paid . "</span>";
        if ($return_html) {
            return $invoice_status;
        } else {
            return $paid;
        }
    }

    function item_modal_form() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));

        $invoice_id = $this->input->post('invoice_id');
        if (!$invoice_id) {
            $invoice_id = $view_data['model_info']->fid_invoices;
        }
        $view_data['invoice_id'] = $invoice_id;
        $this->load->view('invoice/item_modal_form', $view_data);
    }
    function item_modal_form_edit() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));

        $invoice_id = $this->input->post('invoice_id');

        $view_data['model_info'] = $this->Purchase_InvoicesItems_model->get_one($this->input->post('id'));
        if (!$invoice_id) {
            $invoice_id = $view_data['model_info']->fid_invoices;
        }
        $view_data['invoice_id'] = $invoice_id;
        $this->load->view('invoice/item_modal_form_edit', $view_data);
    }
    function item_modal_form_view() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));

        $invoice_id = $this->input->post('invoice_id');

        $view_data['model_info'] = $this->Purchase_InvoicesItems_model->get_one($this->input->post('id'));
        if (!$invoice_id) {
            $invoice_id = $view_data['model_info']->fid_invoices;
        }
        $view_data['invoice_id'] = $invoice_id;
        $this->load->view('invoice/item_modal_form_view', $view_data);
    }
    /* add or edit an invoice item */

    function save_item() {

        validate_submitted_data(array(
            "id" => "numeric",
            "invoice_id" => "required|numeric"
        ));

        $invoice_id = $this->input->post('invoice_id');
        $basic_price = unformat_currency($this->input->post('invoice_item_basic'));
        $quantity = unformat_currency($this->input->post('invoice_item_quantity'));
        $id = $this->input->post('id');
        $invoice_item_data = array(
            "fid_invoices" => $invoice_id,
            "title" => $this->input->post('title'),
            "description" => $this->input->post('description'),
            "quantity" => $quantity,
            "basic_price" => $basic_price,
            "total" => $basic_price * $quantity,
        );

        $invoice_item_id = $this->Purchase_InvoicesItems_model->save($invoice_item_data, $id);
		
        if ($invoice_item_id) {

            $options = array("id" => $invoice_item_id);
            $item_info = $this->Purchase_InvoicesItems_model->get_details($options)->row();
            
            echo json_encode(array("success" => true, "invoice_id" => $item_info->fid_invoices, "data" => $this->_make_item_row($item_info), "invoice_total_view" => $this->_get_invoice_total_view($item_info->fid_invoices), 'id' => $invoice_item_id, 'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }
    function save_item_edit() {

        validate_submitted_data(array(
            "id" => "numeric",
            
        ));

        
        $basic_price = unformat_currency($this->input->post('invoice_item_basic'));
        $quantity = unformat_currency($this->input->post('invoice_item_quantity'));
        $id = $this->input->post('id');
        $invoice_item_data = array(
           
            "title" => $this->input->post('title'),
            "description" => $this->input->post('description'),
            "quantity" => $quantity,
            "basic_price" => $basic_price,
            "total" => $basic_price * $quantity,
        );

        $invoice_item_id = $this->Purchase_InvoicesItems_model->save($invoice_item_data, $id);
		
        if ($invoice_item_id) {

            $options = array("id" => $invoice_item_id);
            $item_info = $this->Purchase_InvoicesItems_model->get_details($options)->row();
            
            echo json_encode(array("success" => true, 
            "data" => $this->_make_item_row($item_info), "invoice_total_view" => $this->_get_invoice_total_view($item_info->fid_invoices), 
            'id' => $invoice_item_id, 
            'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }
    /* delete or undo an invoice item */

    function delete_item() {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Purchase_InvoicesItems_model->delete($id, true)) {
                $options = array("id" => $id);
                $item_info = $this->Purchase_InvoicesItems_model->get_details($options)->row();
                echo json_encode(array("success" => true, "invoice_id" => $item_info->fid_invoices, "data" => $this->_make_item_row($item_info), "invoice_total_view" => $this->_get_invoice_total_view($item_info->fid_invoices), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Purchase_InvoicesItems_model->delete($id)) {
                $item_info = $this->Purchase_InvoicesItems_model->get_one($id);
                echo json_encode(array("success" => true, "invoice_id" => $item_info->fid_invoices, "invoice_total_view" => $this->_get_invoice_total_view($item_info->fid_invoices), 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of invoice items, prepared for datatable  */

    function item_list_data($invoice_id = 0) {

        $list_data = $this->Purchase_InvoicesItems_model->get_details(array("fid_invoices" => $invoice_id))->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_item_row($data);
        }
        echo json_encode(array("data" => $result));
        // $this->output->enable_profiler(TRUE);
        // print_r($list_data);

    }

    /* prepare a row of invoice item list table */

    private function _make_item_row($data) {
        $item = "<b>$data->title</b>";
        if ($data->description) {
            $item.="<br /><span>" . nl2br($data->description) . "</span><br><span style='float:right;'>".$data->category."<span>";
        }

        $val = $this->Purchase_Invoices_model->get_details(array("id" => $data->fid_invoices))->row();

        if($val->status != "paid" AND $val->is_verified == "0"){
            return array(
                modal_anchor(get_uri("purchase/p_invoices/item_modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit'), "data-post-id" => $data->id))
                . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => lang('delete'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("purchase/p_invoices/delete_item"), "data-action" => "delete")),
                $item,
                to_decimal_format($data->quantity),
                to_currency($data->basic_price),
                to_currency($data->total)
                
            );

        }else{
            return array(
                modal_anchor(get_uri("purchase/p_invoices/item_modal_form_view"), "<i class='fa fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id)),
                $item,
                to_decimal_format($data->quantity),
                to_currency($data->basic_price),
                to_currency($data->total)

            );

        }
    }

    function get_item_suggestion() {
        $key = $this->input->get('q');
        $suggestion = array();

        $items = $this->Purchase_InvoicesItems_model->get_item_suggestion($key);

        foreach ($items as $item) {
            $suggestion[] = array("id" => $item->title, "text" => $item->title, "price" => $item->price , "category" => $item->category,"unit_type" => $item->unit_type);
        }

        //$suggestion[] = array("id" => "+", "text" => "+ " . lang("create_new_item"));

        echo json_encode($suggestion);
    }

    function get_item_suggestion_pembelian() {
        $key = $this->input->get('q');
        $suggestion = array();

        $items = $this->Purchase_InvoicesItems_model->get_item_suggestion_sparepart($key);

        foreach ($items as $item) {
            $suggestion[] = array("id" => $item->title, "text" => $item->title, "price" => $item->price , "description" => $item->deskripsi , "category" => 'Sparepart',"unit_type" => '');
        }

        $items2 = $this->Purchase_InvoicesItems_model->get_item_suggestion_material($key);

        foreach ($items2 as $item) {
            $suggestion[] = array("id" => $item->pm_deskripsi, "text" => $item->pm_deskripsi, "description" => $item->deskripsi , "price" => $item->pm_unit_harga , "category" => 'Material', "unit_type" => '');
        }

        //$suggestion[] = array("id" => "+", "text" => "+ " . lang("create_new_item"));

        echo json_encode($suggestion);
    }

    function get_item_info_suggestion() {
        $item = $this->Purchase_InvoicesItems_model->get_item_info_suggestion($this->input->post("item_name"));
        if ($item) {
            echo json_encode(array("success" => true, "item_info" => $item));
        } else {
            echo json_encode(array("success" => false));
        }
    }
    function get_item_info_suggestion_pembelian() {
		
		$item1 = $this->Purchase_InvoicesItems_model->get_item_info_suggestion_sparepart($this->input->post("item_name"));
		$item2 = $this->Purchase_InvoicesItems_model->get_item_info_suggestion_material($this->input->post("item_name"));
		$hit1=count($item1);
		$hit2=count($item2);
		if($hit1>0){
			$item=$item1;
		}
		
		if($hit2>0){
			$item=$item2;
		}
		
		 
        if ($item) {
            echo json_encode(array("success" => true, "item_info" => $item));
        } else {
            echo json_encode(array("success" => false));
        }
    }

    private function _get_invoice_total_view($invoice_id = 0) {
        $view_data["invoice_total_summary"] = $this->Purchase_Invoices_model->get_invoices_total_summary($invoice_id);
        return $this->load->view('invoice/inv_total_section', $view_data, true);
    }

    function get_invoice_status_bar($invoice_id = 0) {

        $view_data["invoice_info"] = $this->Purchase_Invoices_model->get_details(array("id" => $invoice_id))->row();
        $view_data["order_info"] = $this->Purchase_Order_model->get_details(array("id" => $view_data['invoice_info']->fid_order ))->row();
        $view_data["client_info"] = $this->Master_Vendors_model->get_details(array("id" => $view_data["invoice_info"]->fid_vendor))->row();
        $view_data['invoice_status_label'] = $this->_get_invoices_status_label($view_data["invoice_info"]);
        $this->load->view('invoice/inv_status_bar', $view_data);
    }

     function preview2($invoice_id = 0, $show_close_preview = false) {




        if ($invoice_id) {
            $view_data = get_p_invoices_making_data2($invoice_id);
            //$view_data2 = $this->item_list_data($invoice_id);
			//$view_data = get_p_invoices_making_data($id);
			print_r($view_data);
			//$list_data = $this->Purchase_InvoicesItems_model->get_details(array("fid_invoices" => $invoice_id))->result();
            $view_data['invoice_preview'] = prepare_s_invoice_pdf($view_data, "html");

            //show a back button
            $view_data['show_close_preview'] = true;

            $view_data['invoice_id'] = $invoice_id;
            $view_data['payment_methods'] = "";
			/*
			$view_data['invoice_status'] = $this->_get_invoices_status_label($view_data["invoice_info"], true);
                
                $view_data['invoice_status_label'] = $this->_get_invoices_status_label($view_data["invoice_info"]);

			*/
            $view_data['invoice_status_label'] = $this->_get_invoices_status_label($view_data["invoice_info"]);

            $this->template->rander("invoice/inv_preview", $view_data);
        } else {
            show_404();
        }
    }

     function preview($invoice_id = 0, $show_close_preview = false) {




        if ($invoice_id) {
            $view_data = get_p_invoices_making_data2($invoice_id);
            //$view_data2 = $this->item_list_data($invoice_id);
			//$view_data = get_p_invoices_making_data($id);
			//print_r($view_data);
			//$list_data = $this->Purchase_InvoicesItems_model->get_details(array("fid_invoices" => $invoice_id))->result();
            $view_data['invoice_preview'] = prepare_s_invoice_pdf($view_data, "html");

            //show a back button
            $view_data['show_close_preview'] = true;

            $view_data['invoice_id'] = $invoice_id;
            $view_data['payment_methods'] = "";
			/*
			$view_data['invoice_status'] = $this->_get_invoices_status_label($view_data["invoice_info"], true);
                
                $view_data['invoice_status_label'] = $this->_get_invoices_status_label($view_data["invoice_info"]);

			*/
            $view_data['invoice_status_label'] = $this->_get_invoices_status_label($view_data["invoice_info"]);

            $this->template->rander("invoice/inv_preview", $view_data);
        } else {
            show_404();
        }
    }

    function download_pdf($invoice_id = 0) {

        if ($invoice_id) {
            $invoice_data = get_p_invoices_making_data2($invoice_id);
            // $this->_check_invoice_access_permission($invoice_data);

            prepare_s_invoice_pdf($invoice_data, "download");
        } else {
            show_404();
        }
    }


    


}

/* End of file clients.php */
/* Location: ./application/controllers/clients.php */