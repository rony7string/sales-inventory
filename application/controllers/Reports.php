<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *	@author : Ifty Ron
 * website: iftyron.com
 *  version: 1.0
 */
class Reports extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('user_id')) {
            
        } else {


            redirect(base_url() . 'index.php/Users/login');

        }
    }

    //Purchase Report  Form
    public function purchase()
    {
        $data['items'] = $this->Main_model->select('item');        
        $this->header($title = 'Purchase Report');
        $this->load->view('reports/purchase',$data);
        $this->footer();

    }
     // Purchase Report Details
    public function purchaseReportOld()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
        $data['purchases'] = $this->Main_model->purchases($start_date1,$end_date1);
//echo "<pre>";print_r($data['purchases']);exit;       
	   $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Main_model->select('item');
        $this->header();
        $this->load->view('reports/purchase',$data);
        $this->footer();
    }
	function purchaseReport(){
		$start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

        $invoice = $this->Main_model->get_invoice_by_date1($start_date1, $end_date1);
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($invoice)) {
            $this->bps_table();
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->purchase_no] = $this->Main_model->p_detail(array('purchase_no' => $v_invoice->purchase_no));
                $data['order'][] = $v_invoice;
            }
        }

       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Main_model->getSales($start_date1,$end_date1);
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Main_model->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/p_report',$data);
        $this->footer();
	}

    // Sales Report Form
    public function sales_report()
    {
        $data['items'] = $this->Main_model->select('item');
        $this->header($title = 'Sales Report');
        $this->load->view('reports/sales_report',$data);
        $this->footer();

    }

    public function bps_table()
    {
       $this->Main_model->bps_table('sales_detail','sales_id');
    }
    // Get Sales Report Details
    public function salesReport()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

        $invoice = $this->Main_model->get_invoice_by_date($start_date1, $end_date1);
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($invoice)) {
            $this->bps_table();
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->invoice_no] = $this->Main_model->sales_detail(array('sales_no' => $v_invoice->sales_no));
                $data['order'][] = $v_invoice;
            }
        }

       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Main_model->getSales($start_date1,$end_date1);
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Main_model->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/sales_report',$data);
        $this->footer();
    }

}
