<?php

class Purchase_ConsumablesUsage_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'purchase_consumables_usages';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $id = get_array_value($options, "id");
        $consumable_id = get_array_value($options, "consumable_id");
        $used_by = get_array_value($options, "used_by");
        $start_date = get_array_value($options, "start_date");
        $end_date = get_array_value($options, "end_date");

        $this->db->from($this->table);
        $this->db->where('deleted', 0);

        if ($id) {
            $this->db->where('id', $id);
        }
        if ($used_by) {
            $this->db->where('used_by', $used_by);
        }
        if ($consumable_id) {
            $this->db->where('consumable_id', $consumable_id);
        }
        if ($start_date) {
            $this->db->where('usage_date >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('usage_date <=', $end_date);
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    function get_details_by_consumable($options = array()) {
        $id = get_array_value($options, "id");
        $consumable_id = get_array_value($options, "consumable_id");
    
        $where = "WHERE mc.deleted = 0";
        if ($id) {
            $where .= " AND u.id = $id";
        }
        if ($consumable_id) {
            $where .= " AND mc.id = $consumable_id";
        }
    
        $sql = "
            SELECT 
                mc.id AS consumable_id,
                mc.name AS consumable_name,
                mc.satuan AS satuan,
                IFNULL(p.total_purchased, 0) AS total_purchased,
                IFNULL(u.total_used, 0) AS total_used,
                (IFNULL(p.total_purchased, 0) - IFNULL(u.total_used, 0)) AS remaining_stock
            FROM master_consumables mc
            LEFT JOIN (
                SELECT consumable_id, SUM(quantity_consumables) AS total_purchased
                FROM purchase_invoices_items
                WHERE deleted = 0
                GROUP BY consumable_id
            ) p ON p.consumable_id = mc.id
            LEFT JOIN (
                SELECT consumable_id, SUM(quantity) AS total_used
                FROM purchase_consumables_usages
                WHERE deleted = 0
                GROUP BY consumable_id
            ) u ON u.consumable_id = mc.id
            $where
            ORDER BY mc.name ASC;
        ";
        // print_r($this->db->query($sql));exit;
    
        return $this->db->query($sql);
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