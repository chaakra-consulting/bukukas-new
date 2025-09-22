<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Neraca extends MY_Controller {

    function __construct() {
        parent::__construct();

        //check permission to access this module
                $this->load->model('reports/Accounting_model');
                $this->load->model('reports/Reports_model');
                $this->load->model('master/Master_Saldoawal_model');
 
    }

    /* load clients list view */

    function index() {
		//echo 'oke';
        $periode_default = date("Y")."-01-01";
        $periode_now = date("Y-m-d");
        if(!empty($_GET['start']) && !empty($_GET['end'])){
            $periode_default = $_GET['start'];
            $periode_now = $_GET['end'];

        }
        if($this->input->get("type") == 1){
            header("Location:".get_uri("accounting/neraca/monthly"));
        }
        $view_data['getJenisKas'] = $this->Accounting_model->getJenisKas();

        $view_data['getAkun'] = $this->Accounting_model->getAkun();

         $view_data['getCoa'] = $this->Accounting_model->getCoaHeadNeraca();

        $view_data['getCoaAsetTidakLancar'] = $this->Accounting_model->getCoaAsetTidakLancar();

        $view_data['getCoaAsetTidakLancar'] = $this->Accounting_model->getCoaAsetTidakLancar();

        $view_data['getCoaJangkaPanjang'] = $this->Accounting_model->getCoaJangkaPanjang();

        if(isset($_GET['print']) == 2){
            
            prepare_report_pdf($view_data,"neraca/pdf","download");
        }else if(isset($_GET['print']) == 3){
            
            prepare_report_pdf($view_data,"neraca/excel","download");
        }else{
            $this->template->rander("neraca/index",$view_data); 
        }


    }

    function monthly(){
        $view_data['neraca'] = $this->Reports_model->getNeracaMonthly();
        $this->template->rander("neraca/monthly",$view_data);
    }

}