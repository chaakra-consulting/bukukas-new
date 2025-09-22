<?php

class Master_Marketing_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'master_marketing';
        parent::__construct($this->table);
    }


    function get_details($perss = array()){
        $id = get_array_value($perss, "id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        $data = $this->db->query("SELECT * FROM master_marketing WHERE  deleted = 0  ".$where." ORDER BY id DESC");
        return $data;
    }

    function get_suggestion($keyword = "") {
        // $items_table = $this->db->dbprefix('master_items');
        

        $sql = "SELECT *
        FROM $this->table
        WHERE deleted = 0  AND name LIKE '%$keyword%' ";
        return $this->db->query($sql)->result();
    }

    function get_info_suggestion($item_name = "") {
        // $estimate_items_table = $this->db->dbprefix('estimate_items');
        $table_cust = $this->table;

        $sql = "SELECT *
        FROM $table_cust
        WHERE $table_cust.deleted=0 AND $table_cust.name = '$item_name'
        ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);

        if ($result->num_rows()) {
            return $result->row();
        }
    }

}
