<?php

class Widget_model extends CI_Model {

    private $table = null;

    function __construct() {

    }


    function sales_today(){

        $data = $this->db->query("select *,
(select sum(total) as total from sales_invoices_items a join sales_invoices b on a.fid_invoices=b.id where b.status = 'posting' AND a.deleted = 0 AND a.fid_items=master_items.id AND ('".$start."')<=b.end_date AND ('".$end."')>=b.end_date)  as total,
(select sum(quantity) as qty from sales_invoices_items a join sales_invoices b on a.fid_invoices=b.id where b.status = 'posting' AND a.deleted = 0 AND a.fid_items=master_items.id AND ('".$start."')<=b.end_date AND ('".$end."')>=b.end_date)  as qty
from master_items WHERE master_items.deleted = 0");
    }


   public function get_total_piutang(){
            $query = $this->db->query('SELECT SUM(amount) AS piutang FROM sales_invoices WHERE  paid="Not Paid" AND deleted=0 AND end_date  >= now( )')->row_object();
            return $query->piutang;
        }

    public function get_total_hutang(){
            $query = $this->db->query('SELECT SUM(amount) AS hutang FROM purchase_invoices WHERE paid="Not Paid" AND deleted=0 AND end_date  >= now( )')->row_object();
            return $query->hutang;
        }


    public function get_total_online(){
            $query = $this->db->query('SELECT SUM(total) AS online FROM sales_invoices JOIN sales_invoices_items ON sales_invoices.id=sales_invoices_items.fid_invoices WHERE  sales_invoices.penjualan="online" AND sales_invoices.status="posting" AND sales_invoices.deleted=0')->row_object();
            return $query->online;
        }

    public function get_total_offline(){
            $query = $this->db->query('SELECT SUM(total) AS offline FROM sales_invoices JOIN sales_invoices_items ON sales_invoices.id=sales_invoices_items.fid_invoices WHERE  sales_invoices.penjualan="offline" AND sales_invoices.status="posting" AND sales_invoices.deleted=0')->row_object();
            return $query->offline;
        }
    
    public function calculateTotalNominalPerMonth() {
            $query = $this->db->query('SELECT YEAR(inv_date) as year, MONTH(inv_date) as month, SUM(total) FROM purchase_invoices JOIN purchase_invoices_items ON purchase_invoices.id=purchase_invoices_items.fid_invoices WHERE  purchase_invoices.deleted=0 AND purchase_invoices.status="terverifikasi" GROUP BY YEAR(inv_date), MONTH(inv_date)')->row_object();
            return $query->total;
        }
    
    }
