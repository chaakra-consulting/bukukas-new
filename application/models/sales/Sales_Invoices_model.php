<?php

class Sales_Invoices_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'sales_invoices';
        parent::__construct($this->table);
    }


    function get_details($options = array()){
    $id = get_array_value($options, "id");
    $start_date = get_array_value($options, "start_date");
    $end_date = get_array_value($options, "end_date");
    $where = "";
    
    if ($id) {
        $where = " AND id=$id";
    }
    
    if ($start_date) {
        $where .= " AND (inv_date >= '".$start_date."' AND inv_date <= '".$end_date."')";
    }
    
    $data = $this->db->query("SELECT * FROM $this->table 
                              WHERE deleted = 0 ".$where." 
                              ORDER BY ABS(DATEDIFF(inv_date, CURDATE())) ASC, id DESC");
    
    return $data;
}


    function get_detailss($options = array()){
        $id = get_array_value($options, "id");
        $start_date=get_array_value($options, "start_date");
        $end_date=get_array_value($options, "end_date");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        if ($start_date) {
            $start_date = get_array_value($options, "start_date");
            $end_date = get_array_value($options, "end_date");  
            $where .= " AND (inv_date >='".$start_date."'AND  inv_date <='".$end_date."')";
        }

        $data = $this->db->query("SELECT * FROM $this->table WHERE  deleted = 0  ".$where." ORDER BY id DESC");
        return $data;

    }

    function get_invoices_total_summary($invoice_id = 0, $invoice_termin = null) {
        $invoice_items_table = $this->db->dbprefix('sales_invoices_items');
        $invoices_table = $this->db->dbprefix('sales_invoices');
        $invoices_payments_table = $this->db->dbprefix('sales_invoices_payments');
        $clients_table = $this->db->dbprefix('master_customers');
        $taxes_table = $this->db->dbprefix('taxes');

        $item_sql = "SELECT SUM($invoice_items_table.total) AS invoice_subtotal
        FROM $invoice_items_table
        LEFT JOIN $invoices_table ON $invoices_table.id= $invoice_items_table.fid_invoices    
        WHERE $invoice_items_table.deleted=0 AND $invoice_items_table.fid_invoices=$invoice_id AND $invoices_table.deleted=0";
        $item = $this->db->query($item_sql)->row();


        $invoice_sql = "SELECT $invoices_table.*, tax_table.percentage AS tax_percentage, tax_table.title AS tax_name
        FROM $invoices_table
        LEFT JOIN (SELECT $taxes_table.* FROM $taxes_table) AS tax_table ON tax_table.id = $invoices_table.fid_tax
        WHERE $invoices_table.deleted=0 AND $invoices_table.id=$invoice_id";
        $invoice = $this->db->query($invoice_sql)->row();

        if($invoice_termin){
            $paymentAll = $this->db
            ->select("COUNT(*) AS payment_count, SUM(total) AS payment_subtotal")
            ->from("(SELECT * 
                    FROM $invoices_payments_table
                    WHERE deleted = 0
                    AND fid_sales_invoice = $invoice_id
                    ORDER BY payment_date ASC) AS ordered")
            ->get()
            ->row();

            $payment = $this->db
                ->select("COUNT(*) AS payment_count, SUM(total) AS payment_subtotal")
                ->from("(SELECT * 
                        FROM $invoices_payments_table
                        WHERE deleted = 0
                        AND fid_sales_invoice = $invoice_id
                        ORDER BY payment_date ASC
                        LIMIT " . max(0, $invoice_termin - 1) . ") AS ordered")
                ->get()
                ->row();

            $current_payment = $this->db
                ->select("p.total AS payment_subtotal")
                ->from("(SELECT p.*, 
                                ROW_NUMBER() OVER (ORDER BY p.payment_date ASC) AS rn
                        FROM $invoices_payments_table p
                        LEFT JOIN $invoices_table i
                                ON i.id = p.fid_sales_invoice
                        WHERE p.deleted = 0
                        AND i.deleted = 0
                        AND p.fid_sales_invoice = $invoice_id
                        ORDER BY p.payment_date ASC
                        ) AS p")
                ->where('p.rn', $invoice_termin)   // ambil urutan ke-n
                ->limit(1)
                ->get()
                ->row();
            
        }else{
            $paymentAll = $this->db
            ->select("COUNT(*) AS payment_count, SUM(total) AS payment_subtotal")
            ->from("(SELECT * 
                    FROM $invoices_payments_table
                    WHERE deleted = 0
                    AND fid_sales_invoice = $invoice_id
                    ORDER BY payment_date ASC) AS ordered")
            ->get()
            ->row();

            $payment_sql = "SELECT COUNT($invoices_payments_table.id) AS payment_count,SUM($invoices_payments_table.total) AS payment_subtotal
            FROM $invoices_payments_table
            LEFT JOIN $invoices_table ON $invoices_table.id = $invoices_payments_table.fid_sales_invoice    
            WHERE $invoices_payments_table.deleted = 0 
            AND $invoices_payments_table.fid_sales_invoice = $invoice_id 
            AND $invoices_table.deleted = 0 
            AND $invoices_payments_table.status = 'terbayar'
            ORDER BY $invoices_payments_table.payment_date ASC";
            $payment = $this->db->query($payment_sql)->row();
            
            $current_payment_sql = "SELECT $invoices_payments_table.total AS payment_subtotal
                FROM $invoices_payments_table
                LEFT JOIN $invoices_table ON $invoices_table.id = $invoices_payments_table.fid_sales_invoice    
                WHERE $invoices_payments_table.deleted = 0 
                AND $invoices_payments_table.fid_sales_invoice = $invoice_id 
                AND $invoices_table.deleted = 0 
                AND $invoices_payments_table.status = 'belum-terbayar'
                ORDER BY $invoices_payments_table.payment_date ASC
                LIMIT 1";
            $current_payment = $this->db->query($current_payment_sql)->row();
        }

        $result = new stdClass();

        $result->invoice_subtotal = $item->invoice_subtotal;
        $result->tax_percentage = $invoice->tax_percentage;
        $result->tax_name = $invoice->tax_name;
        $result->diskon = $invoice->potongan;
        $result->payment_subtotal = $payment->payment_subtotal;
        $result->tax = 0;
        if ($invoice->tax_percentage) {
            $result->tax = $result->invoice_subtotal * ($invoice->tax_percentage / 100);
        }
        if ($invoice->potongan) {
            $result->potongan = $result->invoice_subtotal * ($invoice->potongan / 100);
        }
        
        $result->invoice_total = $item->invoice_subtotal + $result->tax + ($result->potongan);
        $result->grand_total = $item->invoice_subtotal + $result->tax + ($result->potongan);
        $result->grand_total_no_pph = $item->invoice_subtotal + $result->tax;
        $result->payment_subtotal_minus = $result->grand_total - $payment->payment_subtotal;
        
        $result->payment_subtotal_termin = $current_payment->payment_subtotal ? $current_payment->payment_subtotal : 0;
        
        $factorPPH = round(($result->invoice_subtotal + $result->tax) / $result->grand_total , 8);
        $result->payment_subtotal_termin_no_pph = round($result->payment_subtotal_termin * $factorPPH);

        // jika dengan pph
        if ($invoice->potongan) {
            $result->payment_total_termin_no_ppn_with_pph = round($result->payment_subtotal_termin / (1 + ($invoice->tax_percentage/100) + ($invoice->potongan/100)), 0);
            $result->payment_pph_termin_no_ppn_with_pph = round($result->payment_total_termin_no_ppn_with_pph * ($invoice->potongan / 100), 0);
            $result->payment_ppn_termin_no_ppn_with_pph = round($result->payment_total_termin_no_ppn_with_pph * ($invoice->tax_percentage / 100), 0);
        }else{
            $result->payment_total_termin_no_ppn_with_pph = 
            $result->payment_pph_termin_no_ppn_with_pph =
            $result->payment_ppn_termin_no_ppn_with_pph = 0;
        }

        // jika tanpa pph
        $result->payment_total_termin_no_ppn = ($invoice->tax_percentage) ? round($result->payment_subtotal_termin_no_pph / (1 + ($invoice->tax_percentage/100)), 0) : $result->payment_subtotal_termin_no_pph;
        $result->payment_ppn_termin_no_ppn = round($result->payment_total_termin_no_ppn * ($invoice->tax_percentage / 100), 0);

        $result->payment_done_subtotal = $payment->payment_subtotal;  
        $result->payment_done_subtotal_no_pph = round($payment->payment_subtotal * $factorPPH);
        //$result->percentage_done_no_pph = $result->payment_done_subtotal_no_pph / $result->grand_total_no_pph * 100;

        $subtotal_invoice = $payment->payment_subtotal + $current_payment->payment_subtotal;
        $result->payment_invoice_total = $paymentAll->payment_subtotal;
        $result->payment_sisa = $result->grand_total - $subtotal_invoice;
        $result->payment_sisa_no_pph = $result->grand_total_no_pph - $subtotal_invoice;

        $result->termin_terbayar = $invoice_termin ? ($invoice_termin > 2 ? 'Termin 1 - '. ($invoice_termin - 1) : 'Termin 1') : 0;
        $result->termin = $invoice_termin ? 'Termin '.$invoice_termin : 0;
        $result->percentage_done = round($result->payment_done_subtotal / $result->grand_total * 100, 0);
        
        $result->percentage_now = round($result->payment_subtotal_termin / $result->grand_total * 100, 0);

        $result->balance_due = number_format($result->invoice_total, 2, ".", "") ;
        $result->currency_symbol = get_setting("currency_symbol");
        $result->currency =  get_setting("default_currency");
        //print_r($payment);exit;
        //print_r($result->tax);exit;
        return $result;
    }

    function get_invoices_value($invoice_id = 0){

        $query = $this->db->query("SELECT
                                            SUM( $invoice_items_table.total ) AS invoice_subtotal 
                                        FROM
                                            $invoice_items_table
                                            LEFT JOIN $invoices_table ON $invoices_table.id = $invoice_items_table.fid_order 
                                        WHERE
                                            $invoice_items_table.deleted = 0 
                                            AND $invoice_items_table.fid_order = $invoice_id
                                            AND i$nvoices_table.deleted =0 ");

        return $query;
    }

     public function verifikasi($id){
        $query = $this->db->query("UPDATE sales_invoices SET is_verified='1', status = 'terverifikasi'  where id='$id' ");
        //return $query->result_array();
    }
    public function send($id){
        $query = $this->db->query("UPDATE sales_invoices SET  dikirim = 'Diterima', keterangan ='Diterima' where id='$id' ");
        //return $query->result_array();
    }
    function get_invoices($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM sales_invoices WHERE  deleted = 0  ".$where." ORDER BY id DESC");
        return $data;
    }

    function get_pembayaran($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND sales_invoices.id=$id";
        }
        $data = $this->db->query("SELECT sales_invoices.id,sales_invoices.code,sales_invoices.fid_cust,sales_invoices.fid_custt,sales_invoices.deleted,sales_payments.paid,sales_payments.pay_date,sales_invoices.vessel_id,sales_invoices.marketing,master_customers.name,master_customers.address FROM sales_invoices JOIN sales_payments ON sales_invoices.id=sales_payments.fid_inv JOIN master_customers ON sales_invoices.fid_cust=master_customers.id  WHERE  sales_invoices.deleted = 0  ".$where." ORDER BY sales_invoices.id DESC");
        return $data;
    }



}
