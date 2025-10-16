<?php

class Purchase_Consumables_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'purchase_consumables';
        parent::__construct($this->table);
    }

    function get_details($options = array()){
        $id = get_array_value($options, "id");
        $consumable_id = get_array_value($options,"consumable_id");
        $where = "";
        if ($id) {
            $where = " AND id=$id";
        }
        if($consumable_id){
            $where = " AND consumable_id = $consumable_id";
        }
        $data = $this->db->query("SELECT * FROM $this->table WHERE  deleted = 0  ".$where." ORDER BY id DESC");
        return $data;
    }
    
    function get_info($id = "") {
        // $estimate_items_table = $this->db->dbprefix('estimate_items');
        $table_cust = $this->table;

        $sql = "SELECT *
        FROM $table_cust
        WHERE $table_cust.deleted=0 AND $table_cust.id = '$id'
        ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);

        if ($result->num_rows()) {
            return $result->row();
        }
    }
}