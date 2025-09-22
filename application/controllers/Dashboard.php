<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->database();
        $this->load->library('template');
    }

    /**
     * Display the dashboard with purchase data
     */
    public function index()
    {
        // Get the year from GET parameter or default to current year
        $year = $this->input->get('search');
        if (empty($year) || !is_numeric($year)) {
            $year = date('Y');
        }

        // Prepare query for total purchases per month for the selected year
        $query = $this->db->query("
            SELECT 
                DATE_FORMAT(pi.inv_date, '%M') AS month_name,
                MONTH(pi.inv_date) AS month_number,
                YEAR(pi.inv_date) AS year,
                SUM(pii.total) AS total_per_month
            FROM 
                purchase_invoices pi
            JOIN 
                purchase_invoices_items pii ON pi.id = pii.fid_invoices
            WHERE 
                YEAR(pi.inv_date) = ?
                AND pi.paid = 'PAID'
                AND pi.deleted = 0
                AND pi.code != '506 - Gaji'
            GROUP BY 
                month_name, month_number, year
            ORDER BY 
                year, month_number
        ", array($year));

        // Prepare the data for the view
        $data = [];
        foreach ($query->result() as $row) {
            $data[] = [
                'month' => $row->month_name,
                'total' => $row->total_per_month
            ];
        }

        // Load the view with the data
        $this->template->rander("dashboard/index", ['data' => $data]);
    }

    /**
     * Display the dashboard with sales data
     */
    public function index2()
    {
        // Get the year from GET parameter or default to current year
        $year = $this->input->get('search');
        if (empty($year) || !is_numeric($year)) {
            $year = date('Y');
        }

        // Prepare query for total purchases per month for the selected year
        $query = $this->db->query("
            SELECT 
                DATE_FORMAT(si.inv_date, '%M') AS month_name,
                MONTH(si.inv_date) AS month_number,
                YEAR(si.inv_date) AS year,
                SUM(sii.total) AS total_per_month
            FROM 
            sales_invoices si
            JOIN 
                sales_invoices_items sii ON si.id = sii.fid_invoices
            WHERE 
                YEAR(si.inv_date) = ?
                AND sii.deleted = 0
            GROUP BY 
                month_name, month_number, year
            ORDER BY 
                year, month_number
        ", array($year));

        // Prepare the data for the view
        $data = [];
        foreach ($query->result() as $row) {
            $data[] = [
                'month' => $row->month_name,
                'total' => $row->total_per_month
            ];
        }

        // Load the view with the data
        $this->template->rander("dashboard/index2", ['data' => $data]);
    }


    public function save_sticky_note()
    {
        $note_data = ['sticky_note' => $this->input->post("sticky_note")];
        $this->Users_model->save($note_data, $this->login_user->id);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
