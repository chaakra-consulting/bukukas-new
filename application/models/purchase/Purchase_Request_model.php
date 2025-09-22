<?php

class Purchase_Request_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'purchase_request';
        parent::__construct($this->table);
    }

    function get_dropdown_quot($option_fields = array(), $key = "id", $where = array()) {
        $where["deleted"] = 0;
        $where["is_verified"] = 1;
        $list_data = $this->get_all_where($where)->result();
        $result = array();
        foreach ($list_data as $data) {
            $text = "";
            foreach ($option_fields as $option) {
                $text.=$data->$option . " ";
            }
            $result[$data->$key] = $text;
        }
        return $result;
    }


    function get_details($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM purchase_request WHERE  deleted = 0  ".$where." ORDER BY id DESC");
        return $data;
    }

    function get_request_total_summary($invoice_id = 0) {
        $invoice_items_table = $this->db->dbprefix('purchase_request_items');
        $invoices_table = $this->db->dbprefix('purchase_request');
        $clients_table = $this->db->dbprefix('master_vendor');
        $taxes_table = $this->db->dbprefix('taxes');

        $item_sql = "SELECT SUM($invoice_items_table.total) AS invoice_subtotal
        FROM $invoice_items_table
        LEFT JOIN $invoices_table ON $invoices_table.id= $invoice_items_table.fid_quotation    
        WHERE $invoice_items_table.deleted=0 AND $invoice_items_table.fid_quotation=$invoice_id AND $invoices_table.deleted=0";
        $item = $this->db->query($item_sql)->row();


        $invoice_sql = "SELECT $invoices_table.*, tax_table.percentage AS tax_percentage, tax_table.title AS tax_name
        FROM $invoices_table
        LEFT JOIN (SELECT $taxes_table.* FROM $taxes_table) AS tax_table ON tax_table.id = $invoices_table.fid_tax
        WHERE $invoices_table.deleted=0 AND $invoices_table.id=$invoice_id";

        $invoice = $this->db->query($invoice_sql)->row();


        $result = new stdClass();

        $result->invoice_subtotal = $item->invoice_subtotal;
        $result->tax_percentage = $invoice->tax_percentage;
        $result->tax_name = $invoice->tax_name;
        $result->tax = 0;
        if ($invoice->tax_percentage) {
            $result->tax = $result->invoice_subtotal * ($invoice->tax_percentage / 100);
        }
        
        $result->invoice_total = $item->invoice_subtotal + $result->tax;
        // $result->total_paid = $payment->total_paid;

        $result->balance_due = number_format($result->invoice_total, 2, ".", "") ;


        $result->currency_symbol = get_setting("currency_symbol");
        $result->currency =  get_setting("default_currency");
        return $result;
    }

    function get_request_value($invoice_id = 0){

                                                        $query = $this->db->query("SELECT
                                                        SUM( $invoice_items_table.total ) AS invoice_subtotal 
                                                    FROM
                                                        $invoice_items_table
                                                        LEFT JOIN $invoices_table ON $invoices_table.id = $invoice_items_table.fid_quotation
                                                    WHERE
                                                        $invoice_items_table.deleted = 0 
                                                        AND $invoice_items_table.fid_quotation = $invoice_id
                                                        AND i$nvoices_table.deleted =0 ");

        return $query;
    }

    public function approval($id){
        $query = $this->db->query("UPDATE purchase_request SET is_verified='1', status = 'approval'  where id='$id' ");
        //return $query->result_array();
    }  

    public function tolak($id){
        $query = $this->db->query("UPDATE purchase_request SET is_verified='1', status = 'ditolak'  where id='$id' ");
        //return $query->result_array();
    }  

    function get_request($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM purchase_request WHERE  deleted = 0  ".$where." ORDER BY id DESC");
        return $data;
    }

     function get_pembelian($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND purchase_request.id=$id";
        }
        $data = $this->db->query("SELECT purchase_request.id,purchase_request.deleted,purchase_invoices.code,purchase_invoices.status,purchase_invoices.created_at,master_vendor.name FROM purchase_request JOIN purchase_invoices ON purchase_request.id=purchase_invoices.fid_quot JOIN master_vendor ON purchase_request.fid_vendor=master_vendor.id WHERE  purchase_request.deleted = 0  ".$where." ORDER BY purchase_request.id DESC");
        return $data;
    }

    function get_pembayaran($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND purchase_request.id=$id";
        }
        $data = $this->db->query("SELECT purchase_request.id,purchase_request.fid_vendor,purchase_request.deleted,purchase_invoices.id,purchase_invoices.delivery_address,purchase_invoices.code,purchase_payments.paid,purchase_payments.pay_date FROM purchase_request JOIN purchase_invoices ON purchase_request.id=purchase_invoices.fid_quot JOIN purchase_payments ON purchase_invoices.id = purchase_payments.fid_inv  WHERE  purchase_request.deleted = 0  ".$where." ORDER BY purchase_request.id DESC");
        return $data;
    }


}
