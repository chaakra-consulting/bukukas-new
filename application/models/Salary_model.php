<?php



class Salary_model extends Crud_model {



    private $table = null;



    function __construct() {

        $this->table = 'salary';

        parent::__construct($this->table);

    }



	

	public function salary_data($id)

	{

		$this->db->select('*');

		$this->db->from('salary kl');

		$this->db->where(array('id'=>$id));  

		//$this->db->where($id); 

		$result=$this->db->get();

		

        if ($result->num_rows()) {

			

            return $result->row();

        }

    }

	

	public function pengeluaran_barang_item($id)

	{

		$this->db->select('*');

		$this->db->from('pengeluaran_items');

		//$this->db->join('persedian_material pm', 'pm.id = pb.pb_material_id');

		

		$this->db->where($id); 

		return $this->db->get();

    }

	

	public function produksi_bahan($id)

	{

		$this->db->select('*,pb.id as pib');

		$this->db->from('produksi_bahan pb');

		$this->db->join('persedian_material pm', 'pm.id = pb.pb_material_id');

		

		$this->db->where($id); 

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

  

	

    function get_maxi() {

		$this->db->select_max('id');

		$this->db->from('salary');

		return $this->db->get();

	}

  

	

    function get_details($options = array()) {

        $items_table = $this->db->dbprefix('salary');

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

	

	public function get_data_pegawai() { 

		 

		$this->db->select('*,pb.id as pegawai_id,salary as gaji');

		$this->db->from('users pb');

		$this->db->join('team_member_job_info pm', 'pm.user_id = pb.id');

		$this->db->where(array('pb.deleted'=>0,'user_type'=>'staff')); 

		$q=$this->db->get();

		return $q->result();  

	}

	public function get_data_periode($id) { 

		 

		$this->db->select('*,pb.id as salary_id');

		$this->db->from('salary_items pb');

		$this->db->join('users pm', 'pm.id = pb.pegawai_id');

		//$this->db->where(array('pb.bulan'=>$bulan,'pb.deleted'=>0)); 

		$this->db->where(array('pb.fid_salary'=>$id,'pb.deleted'=>0)); 

		

		//$this->db->where($option); 

		$q=$this->db->get();

			//$q = $this->db->get_where('salary_items', array('fid_salary'=>$id));

			return $q->result();  

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

	 

	

	public function get_details_item($option)

	{

		$this->db->select('*');

		$this->db->from('salary_items pi');

		$this->db->where($option); 

		return $this->db->get();

    }

	

	public function get_details_bahan($option)

	{

		$this->db->select('*');

		$this->db->from('produksi_bahan pb');

		$this->db->join('persedian_material pm', 'pm.id = pb.pb_material_id');

		$this->db->where($option); 

		return $this->db->get();

    }

  

	public function save_salary($data) {

		return $this->db->insert('salary_items',$data);

	}

	

	public function save_transaction($data) {

		return $this->db->insert('transaction_journal',$data);

	}

	

	

	public function update_salary_cat($data,$id) {

		$this->db->where(array('id'=>$id));

		return $this->db->update('salary',$data);

	}

	

	public function update_salary($data,$id) {

		$this->db->where(array('id'=>$id));

		return $this->db->update('salary_items',$data);

	}

	

	public function save_item($data) {

		return $this->db->insert('pengeluaran_items',$data);

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

        $data = array('deleted' => '1'); 

        $this->db->where("id", $id);

        $success = $this->db->update('produksi_bahan', $data);

        

        return $success;

    }

  



	public function deleteItem($id)

	{		

        $data = array('deleted' => '1'); 

        $this->db->where("id", $id);

        $success = $this->db->update('pengeluaran_items', $data);

        

        return $success;

    }

  

	public function deleteBarangjadi($id)

	{		

        $data = array('deleted' => 1); 

        $this->db->where("id", $id);

        $success = $this->db->update('produksi_barangjadi', $data);

        

        return $success;

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



        $sql = "SELECT *, 'Produksi' as category, code as kode_produk

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



        $sql = "SELECT *, 'Sparepart' as category, code as kode_produk

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



        $sql = "SELECT *,pm_unit_harga as price, 'Material' as category, code as kode_produk

        FROM $invoice_items_table

        WHERE $invoice_items_table.deleted=0 AND $invoice_items_table.pm_deskripsi = '$item_name'

        ORDER BY id DESC LIMIT 1";

        $result = $this->db->query($sql);



        if ($result->num_rows()) {

            return $result->row();

        }

    }

  



}

