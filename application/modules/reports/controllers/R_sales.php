<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class R_sales extends MY_Controller {

function __construct() {
	parent::__construct();

	}


	public function index()
	{
		// Set default date range for the current year
		$start = date("Y") . "-01-01";
		$end   = date("Y-m-d");
	
		if (isset($_GET['start']) && isset($_GET['end'])) {
			$start = $_GET['start'];
			$end   = $_GET['end'];
		} else {
			header("Location:" . base_url() . "reports/r_sales?start=" . $start . "&end=" . $end);
		}
	
		$view_data['date_range'] = format_to_date($start) . " - " . format_to_date($end);
	
		// --- Query utama ---
		$this->db->select("
			si.fid_cust, si.fid_custtt, si.fid_custttt, si.inv_date,
			mc1.name AS customer_name1,
			mc2.name AS customer_name2,
			mc3.name AS customer_name3,
			sii.title,
			sii.total AS total,
			si.fid_tax AS tax_name,
			(sii.total * (taxes.value / 100)) AS tax_amount,
			(sii.total * (si.potongan / 100)) AS pph_amount,
			COUNT(DISTINCT CASE WHEN sip.status = 'terbayar' AND sip.deleted = 0 THEN sip.id END) AS termin_1,
			si.termin AS termin_all,
			SUM(CASE 
				WHEN sip.status = 'terbayar' 
				AND sip.deleted = 0 
				THEN sip.total 
				ELSE 0 
				END
			) 
			AS total_terbayar,
			(
				sii.total 
				+ (sii.total * (taxes.value / 100)) 
				+ (sii.total * (si.potongan / 100))
			) AS total_all
		");
		$this->db->from("sales_invoices si");
		$this->db->join("sales_invoices_items sii", "si.id = sii.fid_invoices", "left");
		$this->db->join("taxes", "si.fid_tax = taxes.id", "left");
		$this->db->join("master_customers mc1", "si.fid_cust = mc1.id", "left");
		$this->db->join("master_customers mc2", "si.fid_custtt = mc2.id", "left");
		$this->db->join("master_customers mc3", "si.fid_custttt = mc3.id", "left");
	
		// Join ke tabel pembayaran
		$this->db->join("sales_invoices_payments sip", "sip.fid_sales_invoice = si.id", "left");
	
		$this->db->where("si.inv_date BETWEEN '$start' AND '$end'");
		$this->db->where("si.deleted = 0");
	
		// Group by invoice (bukan per item) agar jumlah termin per invoice benar
		$this->db->group_by("si.id");
	
		$view_data['sales_report'] = $this->db->get()->result();
	
		// Total pajak
		$view_data['total_tax'] = 0;
		foreach ($view_data['sales_report'] as $report) {
			$view_data['total_tax'] += $report->tax_amount;
		}
	
		if (isset($_GET['print'])) {
			print_pdf("sales/sales_pdf", $view_data);
		} else {
			$this->template->rander("sales/sales_product", $view_data);
		}
	}
}