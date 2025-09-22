<?php

class Sales_InvoicesItems_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'sales_invoices_items';
        parent::__construct($this->table);
    }


    function get_details($options = array()){
        $id = get_array_value($options, "id");
        $quot_id = get_array_value($options,"fid_invoices");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        if($quot_id){
            $where = " AND fid_invoices = $quot_id";
        }
        $data = $this->db->query("SELECT * FROM sales_invoices_items WHERE  deleted = 0  ".$where." ORDER BY id DESC");
        return $data;
    }
    function get_item_suggestion($keyword = "") {
        $items_table = $this->db->dbprefix('master_items');
        

        $sql = "SELECT *
        FROM $items_table
        WHERE $items_table.deleted=0  AND $items_table.title LIKE '%$keyword%'
        GROUP BY $items_table.title LIMIT 10 
        ";
        return $this->db->query($sql)->result();
    }

    function get_item_suggestion_join($keyword = "") {
        $items_table = $this->db->dbprefix('master_items'); 
        //$barang_items_table = $this->db->dbprefix('produksi_barangjadi');

        $sql = "SELECT *
        FROM $items_table
        WHERE $items_table.deleted=0  AND $items_table.title LIKE '%$keyword%'
        GROUP BY $items_table.title LIMIT 10 
        ";
        return $this->db->query($sql)->result();
    }

    function get_item_info_suggestion($item_name = "") {
        // $estimate_items_table = $this->db->dbprefix('estimate_items');
        $invoice_items_table = $this->db->dbprefix('master_items');

        $sql = "SELECT *
        FROM $invoice_items_table
        WHERE $invoice_items_table.deleted=0 AND $invoice_items_table.title = '$item_name'
        ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);

        if ($result->num_rows()) {
            return $result->row();
        }
    }

    function get_item_info_suggestion_join($item_name = "") {//Tambahan Sym
        // $estimate_items_table = $this->db->dbprefix('estimate_items');
        $invoice_items_table = $this->db->dbprefix('master_items');
        $barang_items_table = $this->db->dbprefix('produksi_barangjadi');

        $sql = "SELECT *, $barang_items_table.bj_harga as pricebarang, $barang_items_table.id as kode_produk
        FROM $invoice_items_table JOIN $barang_items_table
        WHERE $invoice_items_table.deleted=0 AND $barang_items_table.deleted=0 AND  $invoice_items_table.id=$barang_items_table.bj_kategori AND $invoice_items_table.title = '$item_name'  AND $barang_items_table.bj_qty>0 
        ORDER BY bj_timecreated ASC LIMIT 1";
        $result = $this->db->query($sql);

        if ($result->num_rows()) {
            return $result->row();
        }
    }
    function get_item_add($id) {
        $items_table = $this->db->dbprefix('purchase_invoices_items');
        
        $sql = "SELECT *
        FROM $items_table
        WHERE $items_table.deleted=0  AND  $items_table.fid_invoices = $id";
        return $this->db->query($sql)->result();
    }
    function get_hpp($id){
        
        $sql = "SELECT *,(select sales_journal from master_items where id=sales_invoices_items.fid_items) as sales_journal,
        (select sales_journal_lawan from master_items where id=sales_invoices_items.fid_items) as sales_journal_lawan,
        (select hpp_journal from master_items where id=sales_invoices_items.fid_items) as hpp_journal,
        (select lawan_hpp from master_items where id=sales_invoices_items.fid_items) as lawan_hpp
        
        FROM sales_invoices_items
        WHERE deleted=0 AND fid_invoices = '$id' ";
        return $this->db->query($sql);
    }
	
	public function _update_data_produksi($data,$id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('produksi_barangjadi',$data);
	}
	
}