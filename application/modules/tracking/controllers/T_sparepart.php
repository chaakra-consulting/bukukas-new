<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_Sparepart extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('master/Master_Sparepart_model');
    }


    //load note list view
    function index() {
       
        $this->template->rander("sparepart/index");
    }

    //load note list view
    function page($menu) {
       if($menu=="oli"){
		   $data['menu']="oli";
		   $this->template->rander("sparepart/index_page",$data);
	   }elseif($menu=="solar"){
		   
		   $data['menu']="solar";
		   $this->template->rander("sparepart/index_page",$data);
	   }else{
		   $this->template->rander("sparepart/index");
	   }
        
    }

    /* View */
    function view($id= 0){
        
        if ($id) {
            $view_data = get_t_sparepart_making_data($id);

            if ($view_data) {

                $view_data["sparepart"] = $this->Master_Sparepart_model->get_sparepart(array("id" => $id))->row();
                $view_data["keluar"] = $this->Master_Sparepart_model->get_sparepart_keluar(array("id" => $id))->row();
                //$view_data["bayar"] = $this->Sales_Invoices_model->get_pembayaran(array("id" => $id))->row();

                $this->template->rander("sparepart/view", $view_data);
            } else {
                show_404();
            }
        }else{
            show_404();
        }
    }

  
    /* list of items, prepared for datatable  */

    function list_data() {

        $list_data = $this->Master_Sparepart_model->get_details()->result();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_item_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    /* list of items data, prepared for datatable  */

    function list_data_page($menu) {
		$page=$menu;
		if($menu=="oli"){
			$list_data = $this->Master_Sparepart_model->get_details_oli()->result();	
		}elseif($menu=="solar"){
		
			$list_data = $this->Master_Sparepart_model->get_details_solar()->result();		
		}else{
			
			$list_data = $this->Master_Sparepart_model->get_details()->result();
		}
		
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_item_row_page($data,$page);
        }
        echo json_encode(array("data" => $result));
    }

    /* prepare a row of item list table */

    private function _make_item_row($data) {
        // $type = $data->unit_type ? $data->unit_type : "";

        return array(
            "#".$data->code,
            $data->title,
            $data->deskripsi,
            anchor(get_uri("tracking/t_sparepart/view/").$data->id, "<i class='fa fa-eye'></i>", array("class" => "view", "title" => 'Tracking', "data-post-id" => $data->id))
        );
    }
    private function _make_item_row_page($data,$page) {
        // $type = $data->unit_type ? $data->unit_type : "";

        return array(
            $data->code,
            $data->title,
            $data->deskripsi,
            
            anchor(get_uri("tracking/t_sparepart/view/").$data->id, "<i class='fa fa-eye'></i>", array("class" => "view", "title" => 'Tracking', "data-post-id" => $data->id))
        );
    }

}

/* End of file items.php */
/* Location: ./application/controllers/items.php */