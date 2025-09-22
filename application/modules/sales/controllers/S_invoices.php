<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class S_invoices extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('Produksi_model');//tambahan
        $this->load->model('sales/Sales_Invoices_model');
        $this->load->model('sales/Sales_InvoicesItems_model');
  
           
    }

    function index() {
        $start_date = date("Y").'-01-01';
            $end_date = date("Y-m-d");
        if(!empty($_GET['start']) && !empty($_GET['end'])){
            $start_date = $_GET['start'];
            $end_date = $_GET['end'];

        }
            $view_data['start_date']=$start_date;
            $view_data['end_date']=$end_date; 
        $this->template->rander("invoice/index",$view_data);
    }


    function modal_form() {
        //get custom fields

        $view_data['model_info'] = $this->Sales_Invoices_model->get_one($this->input->post('id'));
        $view_data['taxes_dropdown'] = array("" => "-") + $this->Taxes_model->get_dropdown_list(array("value"));
        $view_data['pers_dropdown'] = array("" => "-") + $this->Master_Perusahaan_model->get_dropdown_list(array("name"));
        $view_data['clients_dropdown'] = array("" => "-") + $this->Master_Customers_model->get_dropdown_list(array("name"));


        $this->load->view('invoice/modal_form',$view_data);
    }

    function modal_form_edit() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));

        $id = $this->input->post('id') ?? $this->uri->segment(4);
        $options = array(
            "id" => $id,
        );
         $view_data['taxes_dropdown'] = array("" => "-") + $this->Taxes_model->get_dropdown_list(array("value"));     
         $view_data['model_info'] = $this->Sales_Invoices_model->get_details($options)->row();
         $view_data['pers_dropdown'] = array("" => "-") + $this->Master_Perusahaan_model->get_dropdown_list(array("name"));
         $view_data['clients_dropdown'] = array("" => "-") + $this->Master_Customers_model->get_dropdown_list(array("name"));

        $this->load->view('invoice/modal_form_edit', $view_data);
    }
    /* insert or update a client */

    function add() {
        $bukpot = $_FILES['code'];
    
        if (!empty($bukpot['name'])) {
            // Proses upload foto
            $config['upload_path']      = './assets/images/bukpot';
            $config['allowed_types']    = 'jpg|png|gif|pdf';
        
            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('code')) {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode(array("success" => false, 'message' => $error['error']));
                return;
            } else {
                $bukpot = $this->upload->data('file_name');
                // Lakukan sesuatu dengan file yang diunggah
            }
        } 
        validate_submitted_data(array(
            "fid_custt" => "required"
        ));
        $customers_id = $this->input->post('id');
        $data = array(
            "code" => $bukpot,
            "fid_custt" => $this->input->post('fid_custt'),
            "fid_custtt" => $this->input->post('fid_custtt'),
            "fid_custttt" => $this->input->post('fid_custttt'),
            "fid_cust" => $this->input->post('fid_cust'),
            //"no_inv" => $this->input->post('no_inv'),
            "potongan" => $this->input->post('potongan'),
            //"bukpot" => $this->input->post('bukpot'),
            "status" => 'draft',
            "paid" => "Not Paid",
            "inv_date" => $this->input->post('inv_date'),
            "fid_tax" => $this->input->post('fid_tax'),
            "created_at" => date("Y-m-d H:i:s")
        );

            $save_id = $this->Sales_Invoices_model->save($data, $customers_id);
            if($save_id){
                    echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id,'message' => lang('record_saved')));
                
            }else{
                 echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
            }
            // echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        
    }

    function save() {
        $bukpot = $_FILES['bukpot'];
    
        if (!empty($bukpot['name'])) {
            // Proses upload foto
            $config['upload_path']      = './assets/images/bukpot';
            $config['allowed_types']    = 'jpg|png|gif|pdf';
        
            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('bukpot')) {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode(array("success" => false, 'message' => $error['error']));
                return;
            } else {
                $bukpot = $this->upload->data('file_name');
                // Lakukan sesuatu dengan file yang diunggah
            }
        } 
        $customers_id = $this->input->post('id');


        validate_submitted_data(array(

            "fid_custt" => "required"
        ));
        $order_id = $this->input->post('fid_order');
        $data = array(
            "code" => $bukpot,
            "fid_custt" => $this->input->post('fid_custt'),
            "fid_custtt" => $this->input->post('fid_custtt'),
            "fid_custttt" => $this->input->post('fid_custttt'),
            "fid_cust" => $this->input->post('fid_cust'),
            "no_inv" => $this->input->post('no_inv'),
            "potongan" => $this->input->post('potongan'),
            //"bukpot" => $this->input->post('bukpot'),
            "inv_date" => $this->input->post('inv_date'),
            "fid_tax" => $this->input->post('fid_tax')
        );

       
        $save_id = $this->Sales_Invoices_model->save($data, $customers_id);
        if ($save_id) {

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id,'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }
    
    function update() {
        $bukpot = $_FILES['bukpot'];
    
        if (!empty($bukpot['name'])) {
            // Proses upload foto
            $config['upload_path']      = './assets/images/bukpot';
            $config['allowed_types']    = 'jpg|png|gif|pdf';
        
            $this->load->library('upload', $config);
        
            if (!$this->upload->do_upload('bukpot')) {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode(array("success" => false, 'message' => $error['error']));
                return;
            } else {
                $bukpot = $this->upload->data('file_name');
                // Lakukan sesuatu dengan file yang diunggah
            }
        } 
        $customers_id = $this->input->post('id');

        $data = array(
            "code" => $bukpot,
            "fid_custt" => $this->input->post('fid_custt'),
            "fid_custtt" => $this->input->post('fid_custtt'),
            "fid_custttt" => $this->input->post('fid_custttt'),
            "fid_cust" => $this->input->post('fid_cust'),
            "no_inv" => $this->input->post('no_inv'),
            "potongan" => $this->input->post('potongan'),
            //"bukpot" => $bukpot,
            "inv_date" => $this->input->post('inv_date'),
            "fid_tax" => $this->input->post('fid_tax')
        );

       
        $save_id = $this->Sales_Invoices_model->save($data, $customers_id);
        if ($save_id) {

            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id,'message' => lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }

    function delete() {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->input->post('id');
        if ($this->input->post('undo')) {
            if ($this->Sales_Invoices_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
            if ($this->Sales_Invoices_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

     /* verifikasi or undo a client */

     function verifikasi($id){  
            $this->Sales_Invoices_model->verifikasi($id);
            redirect(base_url().'sales/s_invoices');
        }

    /* list of clients, prepared for datatable  */

    function list_data($start_date=false,$end_date=false) {
       if(!$start_date)
        $start_date = date("Y").'-01-01';
      if(!$end_date)
        $end_date = date("Y-m-d");

        $list_data = $this->Sales_Invoices_model->get_details(array('start_date' => $start_date,'end_date' => $end_date))->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* return a row of client list  table */

    private function _row_data($id) {
        $options = array(
            "id" => $id
        );
        $data = $this->Sales_Invoices_model->get_details($options)->row();
        return $this->_make_row($data);
    }

    /* prepare a row of client list table */

   
    private function _make_row($data)
    {
        if (!$data) {
            return array();
        }

        $query = $this->Master_Customers_model->get_details(array("id" => $data->fid_cust))->row();
        $queryy = $this->Master_Customers_model->get_details(array("id" => $data->fid_custtt))->row();
        $queryyy = $this->Master_Customers_model->get_details(array("id" => $data->fid_custttt))->row();
        $persss = $this->Master_Perusahaan_model->get_details(array("id" => $data->fid_custt))->row();
        $taxes = $this->Taxes_model->get_details(array("id" => $data->fid_tax))->row();
        $itemss = $this->Sales_InvoicesItems_model->get_details(array("fid_invoices" => $data->id))->row();

        $potongan = 0;
        $ppn = 0;
        if ($itemss && is_numeric($data->potongan) && is_numeric($itemss->rate)) {
            $potonganPersen = floatval($data->potongan);
            $potongan = ($potonganPersen / 100) * floatval($itemss->rate);
        }
        if ($data->fid_tax == 0 && is_numeric($itemss->rate)) {
            $ppn = (11 / 100) * floatval($itemss->rate);
        }
        $value = $this->Sales_Invoices_model->get_invoices_total_summary($data->id);
        $originalDate = $data->inv_date;
        $newDate = date("d-M-Y", strtotime($originalDate));
        $totalsemua = $value->invoice_subtotal + $ppn + $potongan;
        $row_data = array(
            $itemss->title,
            ($data->fid_custt === 0 || $data->fid_custt === NULL) ? '' : $persss->name,
            $data->inv_date,
            anchor(get_uri("assets/images/bukpot/" . $data->code), "#" . $data->code),
            $this->_get_invoices_status_label($data),
            to_currency($value->invoice_subtotal),
            to_currency($ppn),
            to_currency($potongan),
            to_currency($totalsemua),
            ($data->fid_cust == "0") ? '' : $query->name,
            ($data->fid_custtt == "0") ? '' : $queryy->name,
            ($data->fid_custttt == "0") ? '' : $queryyy->name,
        );
        if ($data->is_verified == "0") {
            $row_data[] = modal_anchor(get_uri("sales/s_invoices/modal_form_edit/" . $data->id), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => "Edit Invoices"))
                . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => "Delete Invoices", "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("sales/s_invoices/delete"), "data-action" => "delete"))
                . anchor(get_uri("sales/s_invoices/verifikasi/") . $data->id, "<i class='fa fa-check'></i>", array("class" => "view", "title" => "Verifikasi Invoices", "data-post-id" => $data->id))
                . anchor(get_uri("sales/s_invoices/view/") . $data->id, "<i class='fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id));

        }
        $row_data[] = anchor(get_uri("sales/s_invoices/view/") . $data->id, "<i class='fa fa-eye'></i>", array("class" => "view", "title" => lang('view'), "data-post-id" => $data->id))
            . js_anchor("<i class='fa fa-times fa-fw'></i>", array('title' => "Delete Invoices", "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("sales/s_invoices/delete"), "data-action" => "delete"));

        return $row_data;
    }

    function view($id= 0){
        
        if ($id) {
            $view_data = get_s_invoices_making_data($id);

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

        }else if ($invoice_info->status == "posting") {
            $invoice_status_class   = "label-info";
            $status = "Posting";

        }
        else if ($invoice_info->status == "paid") {
            $invoice_status_class   = "label-primary";
            $status = "Dibayarkan";

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
    


    function item_modal_form() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));
        $view_data['model_info'] = $this->Sales_InvoicesItems_model->get_one($this->input->post('id'));
        if (!$invoice_id) {
            $invoice_id = $view_data['model_info']->fid_invoices;
        }
        $invoice_id = $this->input->post('invoice_id');  
        $view_data['invoice_id'] = $invoice_id;
        $this->load->view('invoice/item_modal_form', $view_data);
    }
    function item_modal_form_edit() {

        validate_submitted_data(array(
            "id" => "numeric"
        ));
        $view_data['model_info'] = $this->Sales_InvoicesItems_model->get_one($this->input->post('id'));
        //if (!$invoice_id) {
          //  $invoice_id = $view_data['model_info']->fid_invoices;
        //}
        //$invoice_id = $this->input->post('invoice_id');  
       // $view_data['invoice_id'] = $invoice_id;
        $this->load->view('invoice/item_modal_form_edit', $view_data);
    }


    /* add or edit an invoice item */

    function save_item() {

        validate_submitted_data(array(
            "id" => "numeric",
            "invoice_id" => "required|numeric"
        ));

        $invoice_id = $this->input->post('invoice_id');

        $id = $this->input->post('id');
        $rate = unformat_currency($this->input->post('invoice_item_rate'));
        $desc=$this->input->post('invoice_item_title');
        //echo $this->db->last_query();exit();		
        $invoice_item_data = array(
            "fid_invoices" => $invoice_id,
            "title" => $desc,
            "rate" => $rate,
            "total" => $rate,
        );
        
        $invoice_item_id = $this->Sales_InvoicesItems_model->save($invoice_item_data, $id);
        
        if ($invoice_item_id) {
            echo json_encode(array(
                "success" => true,
                "invoice_id" => $invoice_id,
                "data" => $this->_make_item_row($invoice_item_data),  // Ganti $item_info dengan $invoice_item_data
                "invoice_total_view" => $this->_get_invoice_total_view($invoice_id),
                'id' => $invoice_item_id,
                'message' => lang('record_saved')
            ));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('error_occurred')));
        }
    }
    function save_edit() {

        validate_submitted_data(array(
            "id" => "numeric",
           
        ));

        //$invoice_id = $this->input->post('invoice_id');

        $id = $this->input->post('id');
        $rate = unformat_currency($this->input->post('invoice_item_rate'));
        $desc=$this->input->post('invoice_item_title');
        //echo $this->db->last_query();exit();		
        $invoice_item_data = array(
            //"fid_invoices" => $invoice_id,
            "title" => $desc,
            "rate" => $rate,
            "total" => $rate,
        );
        
        $invoice_item_id = $this->Sales_InvoicesItems_model->save($invoice_item_data, $id);
        
        if ($invoice_item_id) {
            echo json_encode(array(
                "success" => true,
                //"invoice_id" => $invoice_id,
                "data" => $this->_make_item_row($invoice_item_data),  // Ganti $item_info dengan $invoice_item_data
                //"invoice_total_view" => $this->_get_invoice_total_view($invoice_id),
                'id' => $invoice_item_id,
                'message' => lang('record_saved')
            ));
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
			
				//Ambil Data Jual
				$get_dt_jual=$this->db->query('select * from sales_invoices_items where id="'.$id.'"')->row();
				$jumlahBarangKembali=$get_dt_jual->quantity;
				$idBarangKembali=$get_dt_jual->id_produk;
				
				$get_dt_produksi=$this->db->query('select * from produksi_barangjadi where id="'.$idBarangKembali.'" AND deleted=0')->row();
				$jumlahBarangdiGudang=$get_dt_produksi->bj_qty-$jumlahBarangKembali;
				$jumlahBarangKeluarGudang=$get_dt_produksi->bj_qtykeluar+$jumlahBarangKembali;
					
				$dataupds = array(
					"bj_qty" => $jumlahBarangdiGudang,
					"bj_qtykeluar" => $jumlahBarangKeluarGudang,
				);

				$updAdd=$this->Sales_InvoicesItems_model->_update_data_produksi($dataupds,$idBarangKembali);		
			
			
            if ($this->Sales_InvoicesItems_model->delete($id, true)) {
                $options = array("id" => $id);
                $item_info = $this->Sales_InvoicesItems_model->get_details($options)->row();
                echo json_encode(array("success" => true, "invoice_id" => $item_info->fid_invoices, "data" => $this->_make_item_row($item_info), "invoice_total_view" => $this->_get_invoice_total_view($item_info->fid_invoices), "message" => lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, lang('error_occurred')));
            }
        } else {
			
				//Ambil Data Jual
				$get_dt_jual=$this->db->query('select * from sales_invoices_items where id="'.$id.'" AND deleted=0')->row();
				$jumlahBarangKembali=$get_dt_jual->quantity;
				$idBarangKembali=$get_dt_jual->id_produk;
				
				$get_dt_produksi=$this->db->query('select * from produksi_barangjadi where id="'.$idBarangKembali.'" AND deleted=0')->row();
				$jumlahBarangdiGudang=$get_dt_produksi->bj_qty+$jumlahBarangKembali;
				$jumlahBarangKeluarGudang=$get_dt_produksi->bj_qtykeluar-$jumlahBarangKembali;
					
				$dataupds = array(
					"bj_qty" => $jumlahBarangdiGudang,
					"bj_qtykeluar" => $jumlahBarangKeluarGudang,
				);

				$updAdd=$this->Sales_InvoicesItems_model->_update_data_produksi($dataupds,$idBarangKembali);		
			
            if ($this->Sales_InvoicesItems_model->delete($id)) {
                $item_info = $this->Sales_InvoicesItems_model->get_one($id);
                echo json_encode(array("success" => true, "invoice_id" => $item_info->fid_invoices, "invoice_total_view" => $this->_get_invoice_total_view($item_info->fid_invoices), 'message' => lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => lang('record_cannot_be_deleted')));
            }
        }
    }

    /* list of invoice items, prepared for datatable  */

    function item_list_data($invoice_id = 0) {

        $list_data = $this->Sales_InvoicesItems_model->get_details(array("fid_invoices" => $invoice_id))->result();
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
        $val = $this->Sales_Invoices_model->get_details(array("id" => $data->fid_invoices))->row();

        {
                    return array(
                        modal_anchor(get_uri("sales/s_invoices/item_modal_form_edit"), "<i class='fa fa-pencil'></i>", array("class" => "edit", "title" => lang('edit'), "data-post-id" => $data->id)),
            $data->title,
            to_currency($data->rate),
            to_currency($data->total),


        );


        }
    }

    function get_item_suggestion() {
        $key = $this->input->get('q');
        $suggestion = array();

        $items = $this->Sales_InvoicesItems_model->get_item_suggestion($key);

        foreach ($items as $item) {
            $suggestion[] = array("id" => $item->title, "text" => $item->title, "price" => $item->price , "category" => $item->category,"unit_type" => $item->unit_type);
        }

        //$suggestion[] = array("id" => "+", "text" => "+ " . lang("create_new_item"));

        echo json_encode($suggestion);
    }

    function get_item_suggestion_pembelian() {
        $key = $this->input->get('q');
        $suggestion = array();

        $items = $this->Sales_InvoicesItems_model->get_item_suggestion_sparepart($key);

        foreach ($items as $item) {
            $suggestion[] = array("id" => $item->title, "text" => $item->title, "price" => $item->price , "description" => $item->deskripsi , "category" => 'Sparepart',"unit_type" => '');
        }

        $items2 = $this->Sales_InvoicesItems_model->get_item_suggestion_material($key);

        foreach ($items2 as $item) {
            $suggestion[] = array("id" => $item->pm_deskripsi, "text" => $item->pm_deskripsi, "description" => $item->deskripsi , "price" => $item->pm_unit_harga , "category" => 'Material', "unit_type" => '');
        }

        //$suggestion[] = array("id" => "+", "text" => "+ " . lang("create_new_item"));

        echo json_encode($suggestion);
    }

    function get_item_info_suggestion() {
        $item = $this->Sales_InvoicesItems_model->get_item_info_suggestion($this->input->post("item_name"));
        if ($item) {
            echo json_encode(array("success" => true, "item_info" => $item));
        } else {
            echo json_encode(array("success" => false));
        }
    }
    function get_item_info_suggestion_pembelian() {
		
		$item1 = $this->Sales_InvoicesItems_model->get_item_info_suggestion_sparepart($this->input->post("item_name"));
		$item2 = $this->Sales_InvoicesItems_model->get_item_info_suggestion_material($this->input->post("item_name"));
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
        $view_data["invoice_total_summary"] = $this->Sales_Invoices_model->get_invoices_total_summary($invoice_id);
        return $this->load->view('invoice/inv_total_section', $view_data, true);
    }

    function get_invoice_status_bar($invoice_id = 0) {

        $view_data["invoice_info"] = $this->Sales_Invoices_model->get_details(array("id" => $invoice_id))->row();
        $view_data["client_info"] = $this->Master_Customers_model->get_details(array("id" => $view_data["invoice_info"]->fid_cust . $view_data["invoice_info"]->fid_custtt . $view_data["invoice_info"]->fid_custttt))->row();
        $view_data["mark_info"] = $this->Master_Marketing_model->get_details(array("id" => $view_data["invoice_info"]->marketing))->row();
        $view_data['invoice_status_label'] = $this->_get_invoices_status_label($view_data["invoice_info"]);
        $this->load->view('invoice/inv_status_bar', $view_data);
    }
    

     function preview($invoice_id = 0, $show_close_preview = false) {




        if ($invoice_id) {
            $view_data = get_s_invoices_making_data($invoice_id);


            $view_data['invoice_preview'] = prepare_s_invoice_pdf($view_data, "html");

            //show a back button
            $view_data['show_close_preview'] = true;

            $view_data['invoice_id'] = $invoice_id;
            $view_data['payment_methods'] = "";

            $view_data['invoice_status_label'] = $this->_get_invoices_status_label($view_data["invoice_info"]);

            $this->template->rander("invoice/inv_preview", $view_data);
        } else {
            show_404();
        }
    }

    function download_pdf($invoice_id = 0) {

        if ($invoice_id) {
            $invoice_data = get_s_invoices_making_data($invoice_id);
            // $this->_check_invoice_access_permission($invoice_data);

            prepare_s_invoice_pdf($invoice_data, "download");
        } else {
            show_404();
        }
    }


    function send_invoice_modal_form($invoice_id) {


        if ($invoice_id) {
            $options = array("id" => $invoice_id);
            $invoice_info = $this->Sales_Invoices_model->get_details($options)->row();
            $mark_info = $this->Master_Marketing_model->get_details($options)->row();
            $view_data['invoice_info'] = $invoice_info;
            $contacts_options = array("id" => $invoice_info->fid_cust);
            $contacts = $this->Master_Customers_model->get_details($contacts_options)->result();
            $contact_first_name = "";
            $contact_last_name = "";
            $contacts_dropdown = array();
            foreach ($contacts as $contact) {
                $contacts_dropdown[$contact->id] = $contact->name. " (" . lang("primary_contact") . ")";
                
            }


            $view_data['contacts_dropdown'] = $contacts_dropdown;

            $email_template = $this->Email_templates_model->get_final_template("send_invoice");

            $invoice_total_summary = $this->Sales_Invoices_model->get_invoices_total_summary($invoice_id);

            $parser_data["INVOICE_ID"] = $invoice_info->id;
            $parser_data["CONTACT_FIRST_NAME"] = $contact->name;
            // $parser_data["CONTACT_LAST_NAME"] = $contact_last_name;
            $parser_data["BALANCE_DUE"] = to_currency($invoice_total_summary->balance_due, $invoice_total_summary->currency_symbol);
            $parser_data["DUE_DATE"] = $invoice_info->inv_date;
            $parser_data["PROJECT_TITLE"] = $invoice_info->code;
            $parser_data["INVOICE_URL"] = get_uri("invoices/preview/" . $invoice_info->id);
            $parser_data['SIGNATURE'] = $email_template->signature;

            $view_data['message'] = $this->parser->parse_string($email_template->message, $parser_data, TRUE);
            $view_data['subject'] = $email_template->subject;

            $this->load->view('invoice/send_invoice_modal_form', $view_data);
        } else {
            show_404();
        }
    }

    function send_invoice() {

        validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $invoice_id = $this->input->post('id');

        $contact_id = $this->input->post('contact_id');
        $cc = $this->input->post('invoice_cc');

        $custom_bcc = $this->input->post('invoice_bcc');
        $subject = $this->input->post('subject');
        $message = decode_ajax_post_data($this->input->post('message'));

        $contact = $this->Master_Customers_model->get_one($contact_id);

        $invoice_data = get_s_invoices_making_data($invoice_id);
        $attachement_url = prepare_s_invoice_pdf($invoice_data, "send_email");

        $default_bcc = get_setting('send_bcc_to'); //get default settings
        $bcc_emails = "";

        if ($default_bcc && $custom_bcc) {
            $bcc_emails = $default_bcc . "," . $custom_bcc;
        } else if ($default_bcc) {
            $bcc_emails = $default_bcc;
        } else if ($custom_bcc) {
            $bcc_emails = $custom_bcc;
        }

        if (send_app_mail($contact->email, $subject, $message, array("attachments" => array(array("file_path" => $attachement_url)), "cc" => $cc, "bcc" => $bcc_emails))) {
            // change email status
            $status_data = array("status" => "sent", "last_email_sent_date" => get_my_local_time());
            if ($this->Sales_Invoices_model->save($status_data, $invoice_id)) {
                echo json_encode(array('success' => true, 'message' => lang("invoice_sent_message"), "invoice_id" => $invoice_id));
            }
            // delete the temp invoice
            if (file_exists($attachement_url)) {
                unlink($attachement_url);
            }
        } else {
            echo json_encode(array('success' => false, 'message' => lang('error_occurred')));
        }
    }


    function checkJournal(){
        $id = $this->input->post('inv_id');


        validate_submitted_data(array(
            "code" => "required",
            // "paid_date" => "required"
            
        ));

        
        $code = $this->input->post("code");
        $voucher_code = "";
        $date = $this->input->post("paid_date");
        $type = "sales";
        // $coa_sales = $this->input->post("sales_coa");
        $description = $this->input->post("memo");
        $amount = unformat_currency($this->input->post('amount'));
        // $amount_cr = unformat_currency($this->input->post('amount_cr'));
        $subtotal = unformat_currency($this->input->post('subtotal'));
        $ppn = unformat_currency($this->input->post('ppn'));

        // $dp = unformat_currency($this->input->post('dp'));
        $pay_type = $this->input->post('pay_type');
        $fid_coa = $this->input->post('fid_bank');
        // $fid_cust = $this->input->get('fid_cust');
        // $fid_project = $this->input->get('fid_project');

        $view_data = array();
        $currency = $this->input->post('currency');
        $curr = 12;
        if($currency == "IDR"){
            $curr = 12;
        }
        if($currency == "USD"){
            $curr = 13;
        }


            $ppn_coa = 192;


            if($pay_type == "CREDIT"){



                
                 $query = $this->Sales_InvoicesItems_model->get_hpp($id);
                 $query_hpp = $this->Sales_InvoicesItems_model->get_hpp($id);
                 foreach($query->result() as $row){
                    echo checkJournal($fid_project,$code,$voucher_code,$date,$type,$row->title,$row->sales_journal,0,$row->total);
                 }

                echo checkJournal($fid_project,$code,$voucher_code,$date,$type,$description,$curr,$amount,0);
                echo checkJournal($fid_project,$code,$voucher_code,$date,$type,$description,$ppn_coa,0,$ppn);

                /*    foreach ($query_hpp->result() as $key) {
                    //print_r($key);exit();
                        if($key->hpp_journal!='0'){
                         echo checkJournal($fid_project,$code,$voucher_code,$date,$type,"HPP - ".$key->title,$key->hpp_journal,$key->basic_price,0);
                        }
                        if($key->lawan_hpp!='0'){
                
                        echo checkJournal($fid_project,$code,$voucher_code,$date,$type,"HPP - ".$key->title,$key->lawan_hpp,0,$key->basic_price);
                        }
                    }          */


                 
             }if($pay_type == "CASH"){
                echo checkJournal($fid_project,$code,$voucher_code,$date,$type,$description,$fid_coa,$amount,0);
                
                echo checkJournal($fid_project,$code,$voucher_code,$date,$type,$description,$ppn_coa,0,$ppn);
                 $query = $this->Sales_InvoicesItems_model->get_hpp($id);
                 $query_hpp = $this->Sales_InvoicesItems_model->get_hpp($id);
                foreach($query->result() as $row){
                    echo checkJournal($fid_project,$code,$voucher_code,$date,$type,$row->title,$row->sales_journal,0,$row->total);

                    
                }

                /*foreach ($query_hpp->result() as $key) {
                    if($key->hpp_journal!='0')
                    echo checkJournal($fid_project,$code,$voucher_code,$date,$type,"HPP - ".$key->title,$key->hpp_journal,$key->basic_price,0);
                    if($key->lawan_hpp!='0')
                    echo checkJournal($fid_project,$code,$voucher_code,$date,$type,"HPP - ".$key->title,$key->lawan_hpp,0,$key->basic_price);
                }*/

                
             }
             
                 
            
            

               
            
            
        
    }

}

/* End of file clients.php */
/* Location: ./application/controllers/clients.php */