<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashflow_model extends CI_Model {

	/*function get_data_akun_dapat() {
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_type in ('Pendapatan','Pendapatan Lain-lain') AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}

	}*/

	function get_data_akun_dapat() {
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_number LIKE '1302' OR account_number LIKE '410%' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}

	}

	function get_data_akun_dapat_old() {
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_number LIKE '410%' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}

	}

	function get_data_akun_piutang() {
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_number LIKE '110%' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}

	}
	function get_data_akun_investasi() {
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_number LIKE '160%' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}

	}
	function get_data_akun_pendanaan() {
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_type in ('Ekuitas','Akun Hutang') AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}

	}
	function getPendNonOp(){
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_type = 'Pendapatan Lain-lain' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	/*function getBebanPokokPenjualan(){
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_type = 'Akun Piutang' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}*/
//account_number LIKE '1302' OR
	function getBebanPokokPenjualan(){
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_number LIKE '1303' OR account_number LIKE '1599' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}
	
	function getBebanPokokPenjualanOld(){
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_number LIKE '1302' OR account_number LIKE '1303' OR account_number LIKE '1599' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	/*function getBebanOperasional(){
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_type = 'Beban' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}*/

	function getBebanOperasional(){
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_number LIKE '610%' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	function getHutangBeban(){
		$query = $this->db->query("SELECT * FROM `acc_coa_type` WHERE `deleted` = 0 AND account_type = 'Hutang Lancar' AND parent IS NULL ORDER BY account_number ASC");
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}
	function get_jml_akun($akun,$month,$year) {
		$start=$year.'-'.$month.'-01';
		$end=$year.'-'.$month.'-31';
			$this->db->select('SUM(debet) AS jum_debet, SUM(credit) AS jum_kredit');
			$this->db->from('transaction_journal');
			$this->db->where('fid_coa', $akun);

		$this->db->where('DATE(date) >= ', ''.$start.'');
		$this->db->where('DATE(date) <= ', ''.$end.'');
		$this->db->where('deleted = ', '0');
		$query = $this->db->get();
		return $query->row();
	}
}