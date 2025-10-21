<?php

class Sales_InvoicesPayments_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'sales_invoices_payments';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $id                     = get_array_value($options, "id");
        $fid_sales_invoice      = get_array_value($options, "fid_sales_invoice");
        $status                 = get_array_value($options, "status");
        $payment_date           = get_array_value($options, "payment_date");
        $payment_year           = get_array_value($options, "payment_year");
        $payment_month          = get_array_value($options, "payment_month"); 
        $receipt_code_not_null  = get_array_value($options, "receipt_code_not_null");
        $deleted                = get_array_value($options, "deleted");
        $cust_id                = get_array_value($options, "cust_id");
    
        $where = "WHERE sip.deleted = 0";
    
        if ($id) {
            $where .= " AND sip.id = $id";
        }
    
        if ($fid_sales_invoice) {
            $where .= " AND sip.fid_sales_invoice = $fid_sales_invoice";
        }
    
        if ($payment_date) {
            $where .= " AND sip.payment_date = '$payment_date'";
        }
    
        if ($payment_year) {
            $where .= " AND YEAR(sip.payment_date) = $payment_year";
        }
    
        if ($payment_month) {
            $where .= " AND MONTH(sip.payment_date) = $payment_month";
        }
    
        if ($status) {
            $where .= " AND sip.status = '$status'";
        }
    
        if ($receipt_code_not_null) {
            $where .= " AND sip.receipt_code IS NOT NULL";
        }
    
        if ($deleted) {
            $where .= " AND sip.deleted = '$deleted'";
        }

        $join = "";
        if ($cust_id) {
            $join = "JOIN sales_invoices si ON si.id = sip.fid_sales_invoice";
            $where .= " AND (
                si.fid_cust = $cust_id 
                OR si.fid_custt = $cust_id 
                OR si.fid_custtt = $cust_id
            )";
        }
    
        $order_by = "ORDER BY sip.payment_date ASC";
    
        $sql = "SELECT sip.*
                FROM sales_invoices_payments sip
                $join
                $where
                $order_by";
    
        return $this->db->query($sql);
    }    
    
    public function verifikasi($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('sales_invoices_payments', [
            'bukti'  => $data['bukti'],
            'status' => $data['status']
        ]);

        // Jika update sukses, kembalikan ID-nya
        return $this->db->affected_rows() > 0 ? $id : false;
    }
    // public function verifikasi($data, $id)
    // {
    //     $id = $id;
    //     $status = $data['status'];
    //     $bukti = $data['bukti'];
        
    //     $this->db->where('id', $id);
    //     $this->db->update('sales_invoices_payments', [
    //         'bukti' => $bukti,
    //         'status' => $status
    //     ]);

    //     return $this->db->affected_rows() > 0;
    // }
}