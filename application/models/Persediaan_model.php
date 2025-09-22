<?php



class Persediaan_model extends Crud_model {



    private $table = null;



    function __construct() {

        $this->table = 'persedian_material';

        parent::__construct($this->table);

    }



    function get_details($options = array()) {

        $items_table = $this->db->dbprefix('persedian_material');

        $where = "";

        $id = get_array_value($options, "id");

        if ($id) {

            $where .= " AND $items_table.id=$id";

        }



        $sql = "SELECT $items_table.*,master_items.title

        FROM $items_table

        JOIN master_items

        ON $items_table.pid_items=master_items.id

        WHERE $items_table.deleted=0 $where";

        return $this->db->query($sql);

    }



}

