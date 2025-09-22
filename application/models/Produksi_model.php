<?php

class Produksi_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'produksi';
        parent::__construct($this->table);
    }

	
	public function produksi_bahan($id)
	{
		$this->db->select('*,pb.id as pib');
		$this->db->from('produksi_bahan pb');
		$this->db->join('persedian_material pm', 'pm.id = pb.pb_material_id');
		
		$this->db->where($id); 
		return $this->db->get();
    }
	
	
	
    function get_maxi() {
		$this->db->select_max('id');
		$this->db->from('produksi');
		return $this->db->get();
	}
  
	
	
	public function persedian_material()
	{
		$this->db->select('*');
		$this->db->from('persedian_material');
		//$this->db->join('persedian_material pm', 'pm.id = pb.pb_material_id');
		
		$this->db->where(array('deleted'=>0,'pm_saldo_material >'=>0)); 
		return $this->db->get();
    }
	
	public function master_item()
	{
		$this->db->select('*');
		$this->db->from('master_items');
		//$this->db->join('persedian_material pm', 'pm.id = pb.pb_material_id');
		
		$this->db->where(array('deleted'=>0)); 
		return $this->db->get();
    }
	
	public function produksi_barangjadi($id)
	{
		$this->db->select('*,bj.id as bid');
		$this->db->from('produksi_barangjadi bj');
		$this->db->join('master_items mi', 'mi.id = bj.bj_kategori');
		$this->db->where($id); 
		return $this->db->get();
    }
  
	
    function get_details($options = array()) {
        $items_table = $this->db->dbprefix('produksi');
        $where = "";
        $id = get_array_value($options, "id");
        if ($id) {
            $where .= " AND $items_table.id=$id";
        }

        $sql = "SELECT $items_table.*
        FROM $items_table
        WHERE $items_table.deleted=0 $where";
        return $this->db->query($sql);
    }
	
	public function pilih_material($id) { 
		 
			$q = $this->db->get_where('persedian_material', array('id'=>$id));
			return $q->result();  
	}
	public function update_material($data,$id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('persedian_material',$data);
	}
	 
	public function updatebahan($data,$id) {
		$this->db->where(array('id'=>$id));
		return $this->db->update('produksi_bahan',$data);
	}
	 
	
	public function get_details_bahan($option)
	{
		$this->db->select('*');
		$this->db->from('produksi_bahan pb');
		$this->db->join('persedian_material pm', 'pm.id = pb.pb_material_id');
		$this->db->where($option); 
		return $this->db->get();
    }
  
	public function simpan_bahan($data) {
		return $this->db->insert('produksi_bahan',$data);
	}
	
	public function simpan_jadi($data) {
		return $this->db->insert('produksi_barangjadi',$data);
	}
	
	public function update_bahan($data,$id) {
		$this->db->where(array('pm_order_number'=>$id));
		return $this->db->update('produksi_bahan',$data);
	}
	 

	public function deleteBahan($id)
	{		
		/*
        $data = array('deleted' => '1'); 
        $this->db->where("id", $id);
        $success = $this->db->update('produksi_bahan', $data);*/
		$success = $this->db->delete('produksi_bahan', array('id' => $id));
        
        return $success;
    }
  
	public function deleteBarangjadi($id)
	{		
       // $data = array('deleted' => 1); 
       // $this->db->where("id", $id);
        //$success = $this->db->update('produksi_barangjadi', $data);
		$success = $this->db->delete('produksi_barangjadi', array('id' => $id));
        
        return $success;
    }
  

}
