<?php

class Purchase_InvoicesItems_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'purchase_invoices_items';
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
        $data = $this->db->query("SELECT * FROM $this->table WHERE  deleted = 0  ".$where." ORDER BY id DESC");
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
	
	
    function get_item_suggestion_sparepart($keyword = "") {
        $items_table = $this->db->dbprefix('master_sparepart');
        
        $sql = "SELECT *
        FROM $items_table
        WHERE $items_table.deleted=0  AND $items_table.title LIKE '%$keyword%'
        GROUP BY $items_table.title LIMIT 10 
        ";
        return $this->db->query($sql)->result();
    }

	
    function get_item_info_suggestion_sparepart($item_name = "") {
        // $estimate_items_table = $this->db->dbprefix('estimate_items');
        $invoice_items_table = $this->db->dbprefix('master_sparepart');

        $sql = "SELECT *, 'Sparepart' as category, deskripsi as description, code as kode_produk
        FROM $invoice_items_table
        WHERE $invoice_items_table.deleted=0 AND $invoice_items_table.title = '$item_name'
        ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);

        if ($result->num_rows()) {
            return $result->row();
        }
    }
	
    function get_item_suggestion_material($keyword = "") {
        $items_table = $this->db->dbprefix('persedian_material');
        

        $sql = "SELECT *
        FROM $items_table
        WHERE $items_table.deleted=0 AND $items_table.pm_deskripsi LIKE '%$keyword%'
        GROUP BY $items_table.pm_deskripsi LIMIT 10 
        ";
        return $this->db->query($sql)->result();
    }

	
    function get_item_info_suggestion_material($item_name = "") {
        // $estimate_items_table = $this->db->dbprefix('estimate_items');
        $invoice_items_table = $this->db->dbprefix('persedian_material');

        $sql = "SELECT *,pm_unit_harga as price, 'Material' as category, pm_deskripsi as description, code as kode_produk
        FROM $invoice_items_table
        WHERE $invoice_items_table.deleted=0 AND $invoice_items_table.pm_deskripsi = '$item_name'
        ORDER BY id DESC LIMIT 1";
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
	
	
    function get_item_sparepart($kode) {
        // $estimate_items_table = $this->db->dbprefix('estimate_items');
        $invoice_items_table = $this->db->dbprefix('master_sparepart');

        $sql = "SELECT *, 'Sparepart' as category, code as kode_produk
        FROM $invoice_items_table
        WHERE $invoice_items_table.deleted=0 AND $invoice_items_table.code = '$kode'
        ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);

        if ($result->num_rows()) {
            return $result->row();
        }
    }
	
	
	public function _update_item_sparepart($data,$id) {
		$this->db->where(array('code'=>$id));
		return $this->db->update('master_sparepart',$data);
	}
	
    function get_item_material($kode) {
        // $estimate_items_table = $this->db->dbprefix('estimate_items');
        $invoice_items_table = $this->db->dbprefix('persedian_material');

        $sql = "SELECT *, 'Material' as category, code as kode_produk
        FROM $invoice_items_table
        WHERE $invoice_items_table.deleted=0 AND $invoice_items_table.code = '$kode'
        ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);

        if ($result->num_rows()) {
            return $result->row();
        }
    }
	
	
	public function _update_item_material($data,$id) {
		$this->db->where(array('code'=>$id));
		return $this->db->update('persedian_material',$data);
	}
	
	
}