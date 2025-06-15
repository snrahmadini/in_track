<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  // Constructor
  public function __construct()
  {
    parent::__construct();
    is_weekends();
    is_logged_in();
    is_checked_in();
    is_checked_out();
    $this->load->library('form_validation');
    $this->load->model('Public_model');
    $this->load->model('Admin_model');
  }

  // Dashboard
  public function index()
  {
    $dquery = "SELECT division_id AS d_id, COUNT(intern_id) AS qty FROM intern_division GROUP BY d_id";
    $d['d_list'] = $this->db->query($dquery)->result_array();
    // Dashboard
    $d['title'] = 'Dashboard';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $d['display'] = $this->Admin_model->getDataForDashboard();

    $this->load->view('templates/dashboard_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('admin/index', $d); // Dashboard Page
    $this->load->view('templates/dashboard_footer');
  }
}
