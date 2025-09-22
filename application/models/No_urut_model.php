<?php

class No_urut_model extends Crud_model {

    public function get_nomor() {
        $this->db->select_max('nomor');
        $query = $this->db->get('nomor_urut');
        $nomor = $query->row()->nomor;
        if ($nomor == null) {
            $nomor = 0;
        }
        return $nomor + 1;
    }

    public function insert_nomor($nomor) {
        $data = array(
            'nomor' => $nomor
        );
        $this->db->insert('nomor_urut', $data);
    }
} 
