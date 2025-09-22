<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Equipment_vehicle extends MY_Controller {

    function __construct() {
        parent::__construct();

     }


     function index(){


     	$start =  date("Y")."-01-01";
     	$end = date("Y-m-d");

     	if(isset($_GET['start']) && isset($_GET['end'])){

     		$start = $_GET['start'];
     		$end = $_GET['end'];
            $kendaraan = $_GET['kendaraan'];
     	}else{
     		header("Location:".base_url()."reports/equipment_vehicle?start=".$start."&end=".$end);
     	}

     	$view_data['date_range'] = format_to_date($start)." - ".format_to_date($end);
     	/*$view_data['sales_report'] = $this->db->query("select *,
(select sum(total) as total from pengeluaran_items a join pengeluaran b on a.fid_pengeluaran=b.id where a.deleted = 0 AND ('".$start."')<=b.pr_tanggal AND ('".$end."')>=b.pr_tanggal)  as total,
(select sum(quantity) as qty from pengeluaran_items a join pengeluaran b on a.fid_pengeluaran=b.id where a.deleted = 0 AND ('".$start."')<=b.pr_tanggal AND ('".$end."')>=b.pr_tanggal)  as qty
from master_kendaraan WHERE master_kendaraan.deleted = 0 ");*/

        /*$view_data['sales_report'] = $this->db->query("select *,(select sum(quantity) as total from pengeluaran_items a join pengeluaran b on a.fid_pengeluaran=b.id where a.deleted = 0 AND ('".$start."')<=b.pr_tanggal AND ('".$end."')>=b.pr_tanggal)  as total

            from pengeluaran_items JOIN pengeluaran ON pengeluaran_items.fid_pengeluaran = pengeluaran.id JOIN master_kendaraan ON pengeluaran.pr_id_kendaraan = master_kendaraan.id JOIN master_sparepart ON pengeluaran_items.kode = master_sparepart.code WHERE pengeluaran_items.deleted = 0 AND '$start'<=pengeluaran.pr_tanggal AND '$end'>=pengeluaran.pr_tanggal");*/


            // $view_data['sales_report'] = $this->db->query("select *,(select sum(quantity) as quantity from master_items a join sales_invoices_items b on a.id=b.fid_items join sales_invoices c on b.fid_invoices=c.id where a.deleted = 0 AND ('".$start."')<=c.inv_date AND ('".$end."')>=c.inv_date)  as total

            // from master_items WHERE master_items.deleted = 0");

             $quantity= $this->db->query("select * from sales_invoices_items JOIN sales_invoices ON sales_invoices_items.fid_invoices=sales_invoices.id WHERE sales_invoices_items.deleted = 0 AND ('".$start."')<=sales_invoices.inv_date AND ('".$end."')>=sales_invoices.inv_date order by  sales_invoices_items.fid_items DESC")->result();


             $master_items= $this->db->query("select * from master_items WHERE master_items.deleted = 0")->result();

             $jum=0;
             $arr=[];
             //print_r($quantity); return;

             // for($i=0;$i<count($master_items);$i++){
                for($j=0;$j<count($quantity);$j++){
                    
                            $jum+=$quantity[$j]->quantity;
                            if($quantity[$j]->fid_items!=$quantity[($j+1)]->fid_items){
                                array_push($arr, ['id'=>$quantity[$j]->fid_items,'jum'=>$jum]);
                                $jum=0;
                                
                            }
                        
                    }
                
             // }

                    for($i=0;$i<count($master_items);$i++){
                        $master_items[$i]->total=0;
                        for($j=0;$j<count($arr);$j++){
                            if($master_items[$i]->id==$arr[$j]['id']){
                                $master_items[$i]->total=$arr[$j]['jum'];
    
                            }
                        }
                    }
                    //print_r($master_items); return;

                    $view_data['sales_report'] = $master_items;

     	if(isset($_GET['print'])){
     		print_pdf("sales/sales_pdf",$view_data);
     	}else{
     	

     		$this->template->rander("equipment_vehicle/vehicle",$view_data);
     	}

     	
     }


}