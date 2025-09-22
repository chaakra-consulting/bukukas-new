<?php

class Master_Sparepart_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'master_sparepart';
        parent::__construct($this->table);
    }

     function get_details($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_sparepart WHERE  type_category=0 AND deleted = 0  ".$where." ORDER BY id DESC");
        return $data;
    }


     function get_details_oli($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_sparepart WHERE type_category=1 AND deleted = 0  ".$where." ORDER BY id DESC");
        return $data;
    }


     function get_details_solar($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_sparepart WHERE  type_category=2 AND deleted = 0  ".$where." ORDER BY id DESC");
        return $data;
    }


    function get_sparepart($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_sparepart WHERE  deleted = 0 AND type_category = 0  ".$where." ORDER BY id DESC");
        return $data;
    }

     function get_sparepart_keluar($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND master_sparepart.id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_sparepart JOIN pengeluaran_items ON master_sparepart.code=pengeluaran_items.kode JOIN pengeluaran ON pengeluaran_items.fid_pengeluaran=pengeluaran.id WHERE  master_sparepart.deleted = 0 AND type_category = 0  ".$where." ORDER BY master_sparepart.id DESC");
        return $data;
    }



    function get_oli($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_sparepart WHERE  deleted = 0 AND type_category = 1  ".$where." ORDER BY id DESC");
        return $data;
    }

     function get_oli_keluar($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND master_sparepart.id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_sparepart JOIN pengeluaran_items ON master_sparepart.code=pengeluaran_items.kode JOIN pengeluaran ON pengeluaran_items.fid_pengeluaran=pengeluaran.id WHERE  master_sparepart.deleted = 0 AND type_category = 1  ".$where." ORDER BY master_sparepart.id DESC");
        return $data;
    }


     function get_solar($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_sparepart WHERE  deleted = 0 AND type_category = 2  ".$where." ORDER BY id DESC");
        return $data;
    }

     function get_solar_keluar($options = array()){
        $id = get_array_value($options, "id");
        $where = "";
        if ($id) {
            $where = " AND master_sparepart.id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_sparepart JOIN pengeluaran_items ON master_sparepart.code=pengeluaran_items.kode JOIN pengeluaran ON pengeluaran_items.fid_pengeluaran=pengeluaran.id WHERE  master_sparepart.deleted = 0 AND type_category = 2  ".$where." ORDER BY master_sparepart.id DESC");
        return $data;
    }

}
